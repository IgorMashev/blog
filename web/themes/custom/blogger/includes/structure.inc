<?php

/**
 * @file
 * Theme and preprocess functions for breadcrumbs, messages, tabs..etc
 */

use \Drupal\Core\Template\Attribute;
use \Drupal\media\MediaInterface;
use \Drupal\node\NodeInterface;

/**
 * Implements hook_preprocess_HOOK() for page.html.twig
 */
function blogger_preprocess_page(array &$variables) {
  $main_layout_attributes = new Attribute();

  //Set default class
  $main_layout_attributes->addClass('main-layout');

  //Handle sidebar modifiers.
  if (!empty($variables['page']['sidebar_first'])) {
    $main_layout_attributes->addClass('main-layout--sidebar-first');
  }
  else {
    $main_layout_attributes->addClass('main-layout--no-sidebars');
  }

  $variables['main_layout_attributes'] = $main_layout_attributes;
}

function blogger_preprocess_page__front(array &$variables) {
  $media_storege = \Drupal::entityTypeManager()->getStorage('media');
  $media_image = $media_storege->load('15');
  $media_video = $media_storege->load('14');
  $media_background = $media_storege->load('22');
  $media_avatar = $media_storege->load('21');

  if ($media_image instanceof MediaInterface) {
    $variables['search_image_uri'] = $media_image->get('field_media_image')
      ->entity->getFileUri();
  }


  if ($media_video instanceof MediaInterface) {
    $variables['search_video_uri'] = $media_video->get('field_media_video_file')
      ->entity->getFileUri();
  }


  if ($media_background instanceof MediaInterface) {
    $variables['author_background'] = $media_background->get('field_media_image')
      ->entity->getFileUri();
  }

  if ($media_avatar instanceof MediaInterface) {
    $variables['author_avatar'] = $media_avatar->get('field_media_image')
      ->entity->getFileUri();
  }

}

/**
 * Implements hook_preprocess_HOOK() for page--contact.html.twig.
 */
function blogger_preprocess_page__contact(array &$variables) {
  /** @var \Drupal\media\MediaStorage $media_storage */
  $media_storage = \Drupal::entityTypeManager()->getStorage('media');

  /** @var \Drupal\media\MediaInterface $media_image */
  $media_image = $media_storage->load(15);
  if ($media_image instanceof MediaInterface) {
    $variables['contact_image_uri'] = $media_image->get('field_media_image')
      ->entity
      ->getFileUri();
  }

  /** @var \Drupal\media\MediaInterface $media_video */
  $media_video = $media_storage->load(14);
  if ($media_video instanceof MediaInterface) {
    $variables['contact_video_uri'] = $media_video->get('field_media_video_file')
      ->entity
      ->getFileUri();
  }

  $entity = \Drupal::entityTypeManager()->getStorage('contact_form')->load('feedback');

  $view_builder = \Drupal::entityTypeManager()->getViewBuilder('contact_form');
  $full_output = $view_builder->view($entity);

  $variables['contact_form'] = $full_output;
}

/**
 * Implements hook_theme_suggestions_HOOK_alter() for page.html.twig.
 */
function blogger_theme_suggestions_page_alter(array &$suggestions, array $variables) {
  $node = \Drupal::routeMatch()->getParameter('node');
  if ($node instanceof NodeInterface) {
    if ($node->id() == 7) {
      $suggestions[] = 'page__about';
    }
  }
}

/**
 * Implements hook_preprocess_HOOK() for page--about.html.twig.
 */
function blogger_preprocess_page__about(array &$variables) {
  /** @var \Drupal\media\MediaStorage $media_storage */
  $media_storage = \Drupal::entityTypeManager()->getStorage('media');

  /** @var \Drupal\media\MediaInterface $media_image */
  $media_image = $media_storage->load(15);
  if ($media_image instanceof MediaInterface) {
    $variables['about_image_uri'] = $media_image->get('field_media_image')
      ->entity
      ->getFileUri();
  }
}
