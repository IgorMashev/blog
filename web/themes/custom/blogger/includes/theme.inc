<?php

/**
 * @file
 * Custom theme hooks.
 */

use \Drupal\node\NodeInterface;
/**
 * Implements hook_preprocess_HOOK() for blog-previous-next__blog-article.html.twig
 */
function blogger_preprocess_blog_previous_next__blog_article(array &$variables) {
  /** @var \Drupal\node\NodeInterface $node */
  $next_entity = !empty($variables['next']) ? $variables['next']['entity'] : NULL;
  $prev_entity = !empty($variables['previous']) ? $variables['previous']['entity'] : NULL;

  if($next_entity) {
    $promo_media = $next_entity->get('field_promo_image')->entity;
    $variables['next']['promo_uri'] = $promo_media->get('field_media_image')->entity->getFileUri();

    $tags =[];
    foreach ($next_entity->get('field_tags')->referencedEntities() as $tag_term) {
      $tags[] = [
        'label' => $tag_term->label(),
      ];
    }
    $variables['next']['tags'] = $tags;
  }

  if($prev_entity) {
    $promo_media = $prev_entity->get('field_promo_image')->entity;
    $variables['previous']['promo_uri'] = $promo_media->get('field_media_image')->entity->getFileUri();

    $tags =[];
    foreach ($prev_entity->get('field_tags')->referencedEntities() as $tag_term) {
      $tags[] = [
        'label' => $tag_term->label(),
      ];
    }
    $variables['previous']['tags'] = $tags;
  }
}

/**
 * Implements hook
 */
function blogger_preprocess_blog_hero__blog_node_blog(array &$variables) {
  $node = \Drupal::routeMatch()->getParameter('node');
  $tags = [];
  if ($node instanceof NodeInterface) {
    /** @var \Drupal\taxonomy\TermInterface $tag_term */
    foreach ($node->get('field_tags')->referencedEntities() as $tag_term) {
      $tags[] = [
        'label' => $tag_term->label(),
        'path' => $tag_term->toUrl()->toString(),
      ];
    }
  }
  $variables['tags'] = $tags;
}