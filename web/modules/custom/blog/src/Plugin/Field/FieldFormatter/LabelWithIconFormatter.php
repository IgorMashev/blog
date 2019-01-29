<?php

namespace Drupal\blog\Plugin\Field\FieldFormatter;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceFormatterBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\media\MediaInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'Label with icon' formatter.
 *
 * @FieldFormatter(
 *   id = "blog_label_with_icon",
 *   label = @Translation("Label with icon"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class LabelWithIconFormatter extends EntityReferenceFormatterBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * LabelWithIconFormatter constructor.
   *
   * @param string $plugin_id
   * @param \Drupal\blog\Plugin\Field\FieldFormatter\mixed $plugin_definition
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   * @param array $settings
   * @param string $label
   * @param string $view_mode
   * @param array $third_party_settings
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   */
  public function __construct(string $plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);

    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function isApplicable(FieldDefinitionInterface $field_definition) {
    return ($field_definition->getFieldStorageDefinition()
        ->getSetting('target_type') == 'media');
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

    foreach ($items as $delta => $item) {
      /** @var \Drupal\media\MediaInterface $entity */
      $entity = $this->entityTypeManager->getStorage('media')->load($item->target_id);
      $element[$delta] = [
        '#theme' => 'blog_label_with_icon_media_formatter',
        '#url' => $this->getMediaUrl($entity),
        '#label' => $entity->label(),
        '#filesize' => $this->getMediaFileSize($entity),
        '#media_type' => $entity->bundle(),
        '#mime_type' => $this->getMediaMimeType($entity),
      ];
    }

    return $element;
  }

  /**
   * Gets media URL
   *
   * @param \Drupal\media\MediaInterface $entity
   *  The entity where to look for url.
   *
   * @return string|null
   */
  protected function getMediaUrl(MediaInterface $entity) {
    switch ($entity->bundle()) {
      case 'audio':
        return $this->getFileUrlFromField($entity, 'field_media_audio_file');

      case 'file':
        return $this->getFileUrlFromField($entity, 'field_media_file');

      case 'image':
        return $this->getFileUrlFromField($entity, 'field_media_image');

      case 'remote_video':
        return $entity->get('field_media_oembed_video')->value;

      case 'video':
        return $this->getFileUrlFromField($entity, 'field_media_video_file');
    }
    return;
  }

  /**
   * @param \Drupal\media\MediaInterface $entity
   */
  protected function getMediaFileSize(MediaInterface $entity) {
    switch ($entity->bundle()) {
      case 'audio':
        return $this->getFileSizeFromField($entity, 'field_media_audio_file');

      case 'file':
        return $this->getFileSizeFromField($entity, 'field_media_file');

      case 'image':
        return $this->getFileSizeFromField($entity, 'field_media_image');

      case 'video':
        return $this->getFileSizeFromField($entity, 'field_media_video_file');
    }
    return;
  }

  /**
   * @param \Drupal\media\MediaInterface $entity
   */
  protected function getMediaMimeType(MediaInterface $entity) {
    switch ($entity->bundle()) {
      case 'audio':
        return $this->getFileMimeFromField($entity, 'field_media_audio_file');

      case 'file':
        return $this->getFileMimeFromField($entity, 'field_media_file');

      case 'image':
        return $this->getFileMimeFromField($entity, 'field_media_image');

      case 'remote_video':
        return 'video/x-wmv';

      case 'video':
        return $this->getFileMimeFromField($entity, 'field_media_video_file');

      default:
        return 'application/octet-stream';
    }
  }

  /**
   * @param \Drupal\media\MediaInterface $entity
   * @param $field_name
   *
   * @return string
   */
  public function getFileUrlFromField(MediaInterface $entity, $field_name) {
    $file_entity = $entity->get($field_name)->entity;
    $file_uri = $file_entity->getFileUri();
    return file_create_url($file_uri);
  }

  /**
   * @param \Drupal\media\MediaInterface $entity
   * @param $field_name
   *
   * @return string
   */
  public function getFileSizeFromField(MediaInterface $entity, $field_name) {
    /** @var \Drupal\file\FileInterface $file_entity */
    $file_entity = $entity->get($field_name)->entity;
    return format_size($file_entity->getSize());
  }

  public function getFileMimeFromField(MediaInterface $entity, $field_name) {
    /** @var \Drupal\file\FileInterface $file_entity */
    $file_entity = $entity->get($field_name)->entity;
    return $file_entity->getMimeType();
  }
}
