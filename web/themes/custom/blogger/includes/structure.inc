<?php

/**
 * @file
 * Theme and preprocess functions for breadcrumbs, messages, tabs..etc
 */


/**
 * Implements hook_preprocess_HOOK() for page.html.twig
 */
function blogger_preprocess_page(array &$variables) {
  $main_layout_attributes = new Attribute();

  //Set default class
  $main_layout_attributes->addClass('main-layout');

  $variables['main_layout_attributes'] = $main_layout_attributes;
}
