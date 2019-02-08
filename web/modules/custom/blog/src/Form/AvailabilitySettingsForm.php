<?php

namespace Drupal\blog\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Blog settings for this site.
 */
class AvailabilitySettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'blog_availability_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['blog.availability.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['availability_status'] = [
      '#type' => 'textfield',
      '#required' => TRUE,
      '#title' => $this->t('Availability'),
      '#default_value' => $this->config('blog.availability.settings')->get('status'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('blog.availability.settings')
      ->set('status', $form_state->getValue('availability_status'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
