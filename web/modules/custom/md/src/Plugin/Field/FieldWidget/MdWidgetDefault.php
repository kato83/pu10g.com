<?php

/**
 * @file
 * Contains \Drupal\md\Plugin\Field\FieldWidget\MdDefaultWidget.
 */

namespace Drupal\md\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'md_widget_default' widget.
 *
 * @FieldWidget(
 *   id = "md_widget_default",
 *   label = @Translation("Markdown default"),
 *   field_types = {
 *     "md_type"
 *   }
 * )
 */
class MdWidgetDefault extends WidgetBase
{

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state)
  {

    $element['markdown'] = [
      '#title' => $this->t('Markdown'),
      '#type' => 'textarea',
      '#default_value' => isset($items[$delta]->markdown) ? $items[$delta]->markdown : NULL,
    ];

    return $element;
  }
}
