<?php

namespace Drupal\blog_hero\Annotation;

use drupal\Component\Annotation\Plugin;

/**
 * @BlogHeroPath annotation.
 *
 * @Annotation
 */
class BlogHeroPath extends Plugin {
  /**
   *The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   *
   * The plugin status.
   *
   * By default all plugins are enabled and this value set in TRUE. You can set
   * it to FALSE, to temporary disable plugin.
   *
   * @var bool
   */
  public $enabled;

  /**
   * The path to match.
   *
   * An array with paths to limit which plugin execution. Can contain wildcard
   * (*) and Drupal placeholder such as <front>.
   *
   * @var array
   */
  public $match_path;

  /**
   * The type of match_path.
   *
   * Value can be:
   *  - listed: (default) Shows only at paths from match_path.
   *  - unlisted: Shows at all path, except those listed in match_path.
   *
   * @var string
   */
  public $match_type;

  /**
   * The weight of plugin.
   *
   * Plugin with higher weight, will be used.
   *
   * @var int
   */
  public $weight;
}