<?php

/**
 * @file
 * Contains \Drupal\md\Plugin\Field\FieldType\MdType.
 */

namespace Drupal\md\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'markdown' field type.
 *
 * @FieldType(
 *   id = "md_type",
 *   label = @Translation("Markdown"),
 *   description = @Translation("Markdown field."),
 *   default_widget = "md_widget_default",
 *   default_formatter = "md_formatter_default"
 * )
 */
class MdType extends FieldItemBase
{

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field)
  {
    return [
      'columns' => [
        'markdown' => [
          'description' => 'markdown text',
          'type' => 'text',
          'size' => 'big',
          'not null' => FALSE,
        ],
      ],
      'indexes' => [
        'markdown' => ['markdown'],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition)
  {
    $properties['markdown'] = DataDefinition::create('string')
      ->setLabel(t('Markdown text'));

    return $properties;
  }


  /**
   * {@inheritdoc}
   */
  public function isEmpty()
  {
    $value = $this->get('markdown')->getValue();
    return $value === NULL || $value === '';
  }
}
