<?php

/**
 * @file
 * Contains \Drupal\md\Plugin\field\formatter\MdFormatterDefault.
 */

namespace Drupal\md\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\md\Md;
use \cebe\markdown\GithubMarkdown;


/**
 * Plugin implementation of the 'md_formatter_default' formatter.
 *
 * @FieldFormatter(
 *   id = "md_formatter_default",
 *   label = @Translation("Markdown default"),
 *   field_types = {
 *     "md_type"
 *   }
 * )
 */
class MdFormatterDefault extends FormatterBase
{
  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode)
  {
    $elements = [];
    $parser = new Md();

    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#theme' => 'makdown_default',
        '#value' => $parser->parse($item->markdown)
      ];
    }

    return $elements;
  }
}
