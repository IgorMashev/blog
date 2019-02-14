<?php

namespace Drupal\blog_hero\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;


class BlogHeroForm extends ConfigFormBase {

  public function getFormId() {
    return 'blog_hero-settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function getEditableConfigNames() {
    return [
      'blog_hero.settings'
    ];
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $front_image = $this->config('blog_hero.settings')->get('front_image');
    if (!empty($front_image)) {
      $front_image = \Drupal\media\Entity\Media::load($front_image);
    }
    $form['front_image'] = [
      '#type' => 'entity_autocomplete',
      '#target_type' => 'media',
      '#title' => t('Image to front pages.'),
      '#default_value' => $front_image,
    ];

    $front_video = $this->config('blog_hero.settings')->get('front_video');
    if (!empty($front_video)) {
      $front_video = \Drupal\media\Entity\Media::load($front_video);
    }
    $form['front_video'] = [
      '#type' => 'entity_autocomplete',
      '#target_type' => 'media',
      '#title' => t('Video to front pages.'),
      '#default_value' => $front_video,
    ];

    $front_background_image = $this->config('blog_hero.settings')->get('front_background_image');
    if (!empty($front_background_image)) {
      $front_background_image = \Drupal\media\Entity\Media::load($front_background_image);
    }
    $form['front_background_image'] = [
      '#type' => 'entity_autocomplete',
      '#target_type' => 'media',
      '#title' => t('Background image to front pages.'),
      '#default_value' => $front_background_image,
    ];

    $front_avatar = $this->config('blog_hero.settings')->get('front_avatar');
    if (!empty($front_image)) {
      $front_avatar = \Drupal\media\Entity\Media::load($front_avatar);
    }
    $form['front_avatar'] = [
      '#type' => 'entity_autocomplete',
      '#target_type' => 'media',
      '#title' => t('Avatar to front pages.'),
      '#default_value' => $front_avatar,
    ];

    $blog_image = $this->config('blog_hero.settings')->get('blog_image');
    if (!empty($blog_image)) {
      $blog_image = \Drupal\media\Entity\Media::load($blog_image);
    }
    $form['blog_image'] = [
      '#type' => 'entity_autocomplete',
      '#target_type' => 'media',
      '#title' => t('Image to blog pages.'),
      '#default_value' => $blog_image,
    ];

    $blog_video = $this->config('blog_hero.settings')->get('blog_video');
    if (!empty($blog_video)) {
      $blog_video = \Drupal\media\Entity\Media::load($blog_video);
    }
    $form['blog_video'] = [
      '#type' => 'entity_autocomplete',
      '#target_type' => 'media',
      '#title' => t('Video to blog pages.'),
      '#default_value' => $blog_video,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {


    $hero_blog_config = $this->config('blog_hero.settings');
    $front_image = $form_state->getValue('front_image');
    $front_video = $form_state->getValue('front_video');
    $front_background_image = $form_state->getValue('front_background_image');
    $front_avatar = $form_state->getValue('front_avatar');
    $blog_image = $form_state->getValue('blog_image');
    $blog_video = $form_state->getValue('blog_video');

    if (!empty($front_image)) {
      $hero_blog_config->set('front_image', $front_image)->save();
    }

    if (!empty($front_video)) {
      $hero_blog_config->set('front_video', $front_video)->save();
    }

    if (!empty($front_background_image)) {
      $hero_blog_config->set('front_background_image', $front_background_image)->save();
    }

    if (!empty($front_avatar)) {
      $hero_blog_config->set('front_avatar', $front_avatar)->save();
    }

    if (!empty($blog_image)) {
      $hero_blog_config->set('blog_image', $blog_image)->save();
    }

    if (!empty($blog_video)) {
      $hero_blog_config->set('blog_video', $blog_video)->save();
    }

    parent::submitForm($form, $form_state);
  }
}