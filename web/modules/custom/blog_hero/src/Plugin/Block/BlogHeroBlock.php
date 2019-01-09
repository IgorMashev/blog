<?php

namespace Drupal\blog_hero\Plugin\Block;

use Drupal\blog_hero\Plugin\BlogHeroPluginManager;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a blog hero block.
 *
 * @Block(
 *   id = "blog_hero",
 *   admin_label = @Translation("Blog Hero"),
 *   category = @Translation("Custom")
 * )
 */
class BlogHeroBlock extends BlockBase implements ContainerFactoryPluginInterface {

  protected $blogHeroEntityManager;

  protected $blogHeroPathManager;

  /**
   * BlogHeroBlock constructor.
   *
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   * @param \Drupal\blog_hero\Plugin\BlogHeroPluginManager $blog_hero_entity
   * @param \Drupal\blog_hero\Plugin\BlogHeroPluginManager $blog_hero_path
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, BlogHeroPluginManager $blog_hero_entity, BlogHeroPluginManager $blog_hero_path) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->blogHeroEntityManager = $blog_hero_entity;
    $this->blogHeroPathManager = $blog_hero_path;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('plugin.manager.blog_hero.entity'),
      $container->get('plugin.manager.blog_hero.path')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $entity_plugins = $this->blogHeroEntityManager->getSuitablePlugins();
    $path_plugins = $this->blogHeroPathManager->getSuitablePlugins();

    $plugins = $entity_plugins + $path_plugins;
    uasort($plugins, '\Drupal\Component\Utility\SortArray::sortByWeightElement');
    $plugin = end($plugins);

    if ($plugin['plugin_type'] == 'entity') {
      $instance = $this->blogHeroEntityManager->createInstance($plugin['id'], ['entity' => $plugin['entity']]);
    }

    if ($plugin['plugin_type'] == 'path') {
      $instance = $this->blogHeroPathManager->createInstance($plugin['id']);
    }

    $build['content'] = [
      '#theme' => 'blog_hero',
      '#title' => $instance->getHeroTitle(),
      '#subtitle' => $instance->getHeroSubtitle(),
      '#image' => $instance->getHeroImage(),
      '#video' => $instance->getHeroVideo(),
    ];
    return $build;
  }

  public function getCacheContext() {
    return [
      'url.path',
    ];
  }

}
