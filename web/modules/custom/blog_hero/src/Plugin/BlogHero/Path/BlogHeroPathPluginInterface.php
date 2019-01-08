<?php

namespace Drupal\blog_hero\Plugin\BlogHero\Path;

use Drupal\blog_hero\Plugin\BlogHero\BlogHeroPluginInterface;

/**
 * Interface for BlogHero path plugin type.
 */
interface BlogHeroPathPluginInterface extends BlogHeroPluginInterface {

  /**
   * Gets match paths.
   *
   * @return array
   *    An array with paths.
   */
  public function getMatchPath();
}