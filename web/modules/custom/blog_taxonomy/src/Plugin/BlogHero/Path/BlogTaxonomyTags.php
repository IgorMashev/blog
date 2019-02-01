<?php

namespace Drupal\blog_taxonomy\Plugin\BlogHero\Path;

use Drupal\blog_hero\Plugin\BlogHero\Path\BlogHeroPathPluginBase;
use Drupal\media\MediaInterface;

/**
 * Hero block for path.
 *
 * @BlogHeroPath(
 *   id = "blog_taxonomy_tags",
 *   match_type = "listed",
 *   match_path = {"/tags"}
 *  )
 */
class BlogTaxonomyTags extends BlogHeroPathPluginBase {



    /**
    * {@inheritdoc}
    */
    public function getHeroImage() {
      /** @var \Drupal\media\MediaStorage $media_storege */
      $media_storage = $this->getEntityTypeManager()->getStorage('media');
      $media_image = $media_storage->load(15);
      if ($media_image instanceof MediaInterface) {
        return $media_image->get('field_media_image')->entity->get('uri')->value;
      }
    }

    /**
    * {@inheritdoc}
    */
    public function getHeroVideo() {
      /** @var \Drupal\media\MediaStorage $media_storege */
      $media_storage = $this->getEntityTypeManager()->getStorage('media');
      $media_video = $media_storage->load(14);
      if ($media_video instanceof MediaInterface) {
        return [
          'video/mp4' => $media_video->get('field_media_video_file')->entity->get('uri')->value,
        ];
      }
    }
}