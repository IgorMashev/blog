<?php

/**
 * @file
 * Theme and preprocess functions for blocks.
 */
function blogger_preprocess_paragraph_code(array &$variables) {
  $variables['#attached']['library'][] = 'blogger/paragraph.code';
}