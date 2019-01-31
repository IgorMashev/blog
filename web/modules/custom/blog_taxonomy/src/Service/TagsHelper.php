<?php

namespace Drupal\blog_taxonomy\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\NodeInterface;
use Drupal\taxonomy\TermInterface;

class TagsHelper implements TagsHelperInterface {

  protected $termStorage;

  protected $nodeStorage;

  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->termStorage = $entity_type_manager->getStorage('taxonomy_term');
    $this->nodeStorage = $entity_type_manager->getStorage('node');
  }

  public function getPromoUri($tid) {
    $term = $this->termStorage->load($tid);

    if ($term instanceof TermInterface && $term->bundle() == 'tags') {
      if (!$term->get('field_promo_image')->isEmpty()) {
        /** @var \Drupal\media\MediaInterface $media */
        $media = $term->get('field_promo_image')->entity;
        /** @var \Drupal\file\FileInterface $file */
        $file = $media->get('field_media_image')->entity;

        return $file->getFileUri();
      }
      else {
        $last_blog_article_result = $this->nodeStorage->getQuery()
          ->condition('status', NodeInterface::PUBLISHED)
          ->condition('type', 'blog')
          ->condition('field_tags', $tid, 'IN')
          ->sort('created', 'DESC')
          ->range(0, 1)
          ->execute();

        if (!empty($last_blog_article_result)) {
          /** @var \Drupal\node\NodeInterface $last_blog_article */
          $last_blog_article = $this->nodeStorage
            ->load(array_shift($last_blog_article_result));

          if ($last_blog_article->hasField('field_promo_image') && !$last_blog_article->get('field_promo_image')->isEmpty()) {

            /** @var \Drupal\media\MediaInterface $media */
            $media = $last_blog_article->get('field_promo_image')->entity;
            /** @var \Drupal\file\FileInterface $file */
            $file = $media->get('field_media_image')->entity;

            return $file->getFileUri();
          }
        }
      }
    }
  }
}