<?php

namespace Drupal\blog_hero\Plugin\BlogHero;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Common interface for all BlogHero plugin types.
 */
interface BlogHeroPluginInterface extends PluginInspectionInterface {

  /**
   * Get plugin status.
   *
   * @return bool
   *    The plugin status.
   */
  public function getEnabled();

  /**
   * Gets  plugin weight.
   *
   * @return int
   *    The plugin weight.
   */
  public function getWeight();

  /**
   * Gets hero title.
   *
   * @return string
   *    The title.
   */
  public function getHeroTitle();

  /**
   * Gets hero subtitle.
   *
   * @return string
   *    The subtitle.
   */
  public function getHeroSubtitle();

  /**
   * Gets hero image.
   *
   * @return string
   *    The URI of image.
   */
  public function getHeroImage();

  /**
   * Gets hero video URI.
   *
   * An array with link to the same video in different types.
   *
   * Keys of array is represents their type and value is file URI.
   *
   * @return array
   *    An array with video URI's.
   */
  public function getHeroVideo();

}