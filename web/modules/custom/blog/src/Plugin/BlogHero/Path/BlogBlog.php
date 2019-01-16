<?php

namespace Drupal\blog\Plugin\BlogHero\Path;

use Drupal\blog_hero\Plugin\BlogHero\Path\BlogHeroPathPluginBase;
use Drupal\media\MediaInterface;

/**
 * Hero block for path.
 *
 * @BlogHeroPath(
 *   id = "blog_blog",
 *   match_type = "listed",
 *   match_path = {"<front>", "/blog"}
 *  )
 */
class BlogBlog extends BlogHeroPathPluginBase {


    /**
    * {@inheritdoc}
    */
    public function getHeroSubtitle() {
      return 'Vivamus suscipit fermentum ipsum, consectetur pretium arcu ornare dictum. Aenean et sem mi. Sed vel est dolor. Sed vel sagittis ligula, ut scelerisque nunc. Sed eu vehicula ex. Donec aliquet tortor at eros porttitor consequat. Nullam aliquam mi nec orci ornare ullamcorper. Aliquam auctor pharetra laoreet. In ex felis, viverra a varius at, iaculis ac metus.';
    }

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