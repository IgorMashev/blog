<?php

/**
 * Implements hook_theme().
 */
function blog_hero_theme($existing, $type, $theme, $path) {
  return [
    'blog_hero' => [
      'variables' => [
        'title' => NULL,
        'subtitle' => NULL,
        'image' => NULL,
        'video' => [],
      ],
      'file' => 'blog_hero.theme.inc',
      'pattern' => 'blog_hero__',
    ]
  ];
}

/**
 * Implements hook_theme_suggestions_HOOK() for blog-hero.html.twig.
 */
function blog_hero_theme_suggestions_blog_hero(array $variables) {
  $suggestions = [];

  if (!empty($variables['image'])) {
    $suggestions[] = 'blog_hero__image';
  }

  if (!empty($variables['video']) && !empty($variables['image'])) {
    $suggestions[] = 'blog_hero__video';
  }

  return $suggestions;
}