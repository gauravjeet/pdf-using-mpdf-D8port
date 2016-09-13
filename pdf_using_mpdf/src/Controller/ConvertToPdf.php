<?php
/**
 * @file
 * Contains Drupal\pdf_using_mpdf\Controller\ConvertToPdf.
 */
namespace Drupal\pdf_using_mpdf\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

class ConvertToPdf extends ControllerBase {

  /**
   * Function to convert an entity into a PDF document.
   */
  public function convert(Node $node) {
    return 'pdf doc here';
  }
}