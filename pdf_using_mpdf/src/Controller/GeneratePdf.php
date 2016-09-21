<?php
/**
 * @file
 * Contains Drupal\pdf_using_mpdf\Controller\GeneratePdf.
 */
namespace Drupal\pdf_using_mpdf\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\pdf_using_mpdf\Conversion\ConvertToPdf;
use Symfony\Component\DependencyInjection\ContainerInterface;

class GeneratePdf extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('pdf_using_mpdf.conversion')
    );
  }

  /**
   * Inject ConvertToPdf service.
   */
  public function __construct(ConvertToPdf $convert) {
    $this->convert = $convert;
  }

  /**
   * Generate a PDF file from an entity.
   */
  public function generate($node) {
    $this->convert->convert(Node::load($node));
    return [];
  }
}
