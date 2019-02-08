<?php

namespace Drupal\blog\Service;

use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Twig extension.
 */
class BlogTwigExtension extends \Twig_Extension {

  /**
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $configFactory;

  /**
   * Constructs a new BlogTwigExtension instance.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public function getFunctions() {
    return [
      new \Twig_SimpleFunction('blog_availability_status', function () {
        $availability_settings = $this->configFactory->get('blog.availability.settings');

        return $availability_settings->get('status');
      }),
    ];
  }

}
