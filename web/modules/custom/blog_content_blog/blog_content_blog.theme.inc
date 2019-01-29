<?php

use \Drupal\node\NodeInterface;

function template_preprocess_blog_content_blog_related_posts(array &$variables) {
  $max_related_posts = 4;
  $max_same_tags_posts = 2;
  $counter = 0;
  $items = [];
  /** @var \Drupal\node\NodeInterface $node */
  $node = \Drupal::routeMatch()->getParameter('node');
  if ($node instanceof NodeInterface) {

    $node_storage = \Drupal::entityTypeManager()->getStorage('node');

    $node_view_builder = \Drupal::entityTypeManager()->getViewBuilder('node');

    if ($node->hasField('field_tags') && !$node->get('field_tags')->isEmpty()) {
      $same_tags_post_query = \Drupal::entityQuery('node')
        ->condition('status', NodeInterface::PUBLISHED)
        ->condition('nid', $node->id(), '<>')
        ->range(0, $max_same_tags_posts);
      $same_tags_post_query->addTag('entity_query_random');

      $field_tags_ids = [];
      foreach ($node->get('field_tags')->getValue() as $field_tag) {
        $and = $same_tags_post_query->andConditionGroup();
        $and->condition('field_tags', $field_tag['target_id']);
        $same_tags_post_query->condition($and);
        $field_tags_ids[] = $field_tag['target_id'];
      }

      $same_tags_post_ids = $same_tags_post_query->execute();
      foreach ($same_tags_post_ids as $id) {
        $related_post = $node_storage->load($id);
        $items[] = $node_view_builder->view($related_post, 'teaser');
        $counter++;
      }

      $any_tags_post_query = \Drupal::entityQuery('node')
        ->condition('status', NodeInterface::PUBLISHED)
        ->condition('nid', $node->id(), '<>')
        ->condition('field_tags', $field_tags_ids, 'IN')
        ->range(0, ($max_related_posts - $counter));
      $any_tags_post_query->addTag('entity_query_random');

      foreach ($same_tags_post_ids as $id) {
        $any_tags_post_query->condition('nid', $id, '<>');
      }

      $any_tags_post_ids = $any_tags_post_query->execute();
      foreach ($any_tags_post_ids as $id) {
        $related_post = $node_storage->load($id);
        $items[] = $node_view_builder->view($related_post, 'teaser');
        $counter++;
      }
    }

    if ($max_related_posts - $counter > 0) {
      $related_post_query = \Drupal::entityQuery('node')
        ->condition('status', NodeInterface::PUBLISHED)
        ->condition('nid', $node->id(), '<>')
        ->range(0, ($max_related_posts - $counter));
      $related_post_query->addTag('entity_query_random');


      foreach ($same_tags_post_ids as $id) {
        $related_post_query->condition('nid', $id, '<>');
      }

      foreach ($any_tags_post_ids as $id) {
        $related_post_query->condition('nid', $id, '<>');
      }

      $related_post_ids = $related_post_query->execute();

      foreach ($related_post_ids as $id) {
        $related_post = $node_storage->load($id);
        $items[] = $node_view_builder->view($related_post, 'teaser');
        $counter++;
      }
    }
  }

  $variables['items'] = $items;
}