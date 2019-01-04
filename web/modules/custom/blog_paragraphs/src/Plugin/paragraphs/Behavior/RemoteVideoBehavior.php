<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.01.19
 * Time: 14:41
 */

namespace Drupal\blog_paragraphs\Plugin\paragraphs\Behavior;

use Drupal\Component\Utility\Html;
use Drupal\Core\Annotation\Translation;
use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\paragraphs\Annotation\ParagraphsBehavior;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\paragraphs\Entity\ParagraphsType;
use Drupal\paragraphs\ParagraphInterface;
use Drupal\paragraphs\ParagraphsBehaviorBase;

/**
 * @ParagraphsBehavior(
 *   id = "blog_paragraphs_remote_video",
 *   label = @Translation("Remote video settings."),
 *   description = @Translation("Additional settings for remote video paragraph."),
 *   weight = 0,
 *   )
 */

class RemoteVideoBehavior extends ParagraphsBehaviorBase{
  /**
   * {@inheritdoc}
   */
  public static function isApplicable(ParagraphsType $paragraphs_type) {
    return $paragraphs_type->id() == 'remote_video';
  }

  /**
   * Extends the paragraph render array with behavior.
   */
  public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode) {
    $bem_block = 'paragraph-' . $paragraph->bundle() . ($view_mode == 'default' ? '' : '-' . $view_mode);
    $maximum_video_width = $paragraph->getBehaviorSetting($this->getPluginId(), 'video_width', 'full');

    $build['#attributes']['class'][] = Html::getClass($bem_block . '--video-width-' . $maximum_video_width);
  }

  /**
   * {@inheritdoc}
   */
  public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state) {


    $form['video_width'] = [
      '#type' => 'select',
      '#title' => $this->t('Video width'),
      '#description' => $this->t('Maximum width for video'),
      '#options' => [
        'full' => '100%',
        '720p' => '720p',
      ],
      '#default_value' => $paragraph->getBehaviorSetting($this->getPluginId(), 'video_width', 'full'),
      '#weight' => 80,
      ];

    return $form;
  }
}