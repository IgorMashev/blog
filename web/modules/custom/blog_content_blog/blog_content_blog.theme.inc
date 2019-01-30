<?php

use \Drupal\node\NodeInterface;

function template_preprocess_blog_content_blog_related_posts(array &$variables) {
  $items = [];
  /** @var \Drupal\node\NodeInterface $node */
  $node = \Drupal::routeMatch()->getParameter('node');
  if ($node instanceof NodeInterface) {

    $node_storage = \Drupal::entityTypeManager()->getStorage('node');

    $node_view_builder = \Drupal::entityTypeManager()->getViewBuilder('node');

    /** @var \Drupal\blog_content_blog\Service\BlogManagerInterface $blog_manager */
    $blog_manager = \Drupal::service('blog_content_blog.manager');

    $related_post_ids = $blog_manager->getRelatedPosts($node, $variables['max'], $variables['max_exact_same_tags']);
    foreach ($related_post_ids as $id) {
      $related_post = $node_storage->load($id);
      $items[] = $node_view_builder->view($related_post, 'teaser');
    }
  }

  $variables['items'] = $items;
}

function template_preprocess_blog_content_blog_random_posts(array &$variables) {
  $items = [];
  /** @var \Drupal\node\NodeInterface $node */
  $node = \Drupal::routeMatch()->getParameter('node');
  if ($node instanceof NodeInterface) {

    $node_storage = \Drupal::entityTypeManager()->getStorage('node');

    $node_view_builder = \Drupal::entityTypeManager()->getViewBuilder('node');

    /** @var \Drupal\blog_content_blog\Service\BlogManagerInterface $blog_manager */
    $blog_manager = \Drupal::service('blog_content_blog.manager');

    $related_post_ids = $blog_manager->getRandomPosts($variables['limit'], [$node->id()]);
    foreach ($related_post_ids as $id) {
      $related_post = $node_storage->load($id);
      $items[] = $node_view_builder->view($related_post, 'teaser');
    }
  }

  $variables['items'] = $items;
}