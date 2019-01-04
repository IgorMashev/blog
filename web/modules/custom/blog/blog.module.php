<?php
/**
 * @file
 * Main file for custom hooks and functions.
 */

/**
 * Implements hook_theme().
 */
function blog_theme($existing, $type, $theme, $path) {
  return [
    'blog_previous_next' => [
      'variables' => [
        'entity' => NULL,
      ],
      'file' => 'blog.theme.inc',
    ],
  ];
}