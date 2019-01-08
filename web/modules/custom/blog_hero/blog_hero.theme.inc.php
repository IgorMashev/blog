<?php

/**
 * @file
 * Main file for all custom theme hooks preprocess.
 */

function template_preprocess_blog_hero(&$variables) {
  // Image is requires for video. It will be used for poster.
  if (!empty($varibles['video'])) {
    if (!$variables['image']) {
      $variables['video'] = [];
    }
  }
}