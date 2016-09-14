<?php
/**
 * @file
 * Contains Service Drupal\pdf_using_mpdf\Conversion\ConvertToPdf
 */
namespace Drupal\pdf_using_mpdf\Conversion;


use Drupal\node\Entity\Node;

class ConvertToPdf {
  /**
   * @param Node $node
   *   The Node object to fetch html from.
   */
  public function convert(Node $node) {
    return 'node object here';
  }
}
