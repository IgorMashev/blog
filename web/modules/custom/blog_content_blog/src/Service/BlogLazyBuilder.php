<?php

namespace Drupal\blog_content_blog\Service;

/**
 * Class BlogLazyBuilder
 *
 * @package Drupal\blog_content_blog\Service
 */
class BlogLazyBuilder implements BlogLazyBuilderInterface {

  /**
   * {@inheritdoc}
   */
  public static function randomBlogPosts() {
    return [
      '#theme' => 'blog_content_blog_random_posts',
    ];
  }

}