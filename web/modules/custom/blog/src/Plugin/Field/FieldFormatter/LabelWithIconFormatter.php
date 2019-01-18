<?php

namespace Drupal\blog\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

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
class LabelWithIconFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

    foreach ($items as $delta => $item) {
      $element[$delta] = [
        '#type' => 'item',
        '#markup' => $item->target_id,
      ];
    }

    return $element;
  }

}
