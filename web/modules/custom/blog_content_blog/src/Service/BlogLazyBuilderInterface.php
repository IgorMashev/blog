<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.01.19
 * Time: 9:13
 */

namespace Drupal\blog_content_blog\Service;


use Drupal\node\NodeInterface;

interface BlogLazyBuilderInterface {

  /**
   * @return array
   */
  public static function randomBlogPosts();

}