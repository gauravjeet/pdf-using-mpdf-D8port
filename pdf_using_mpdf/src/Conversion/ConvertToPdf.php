<?php
/**
 * @file
 * Contains Service Drupal\pdf_using_mpdf\Conversion\ConvertToPdf
 */
namespace Drupal\pdf_using_mpdf\Conversion;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\Core\Utility\Token;
use Drupal\node\Entity\Node;

class ConvertToPdf {
  protected $renderer;
  protected $mpdf;
  protected $configFactory;
  protected $token;

  /**
   * ConvertToPdf constructor.
   * @param RendererInterface $renderer
   */
  public function __construct(RendererInterface $renderer, ConfigFactoryInterface $config_factory, Token $token) {
    $this->renderer = $renderer;
    $this->configFactory = $config_factory;
    $this->token = $token;
  }

  /**
   * Check if mPDF library exists and is autoloaded.
   * @return bool
   */
  public function mpdfExists() {
    if (class_exists('mPDF')) {
      return TRUE;
    }
    else {

//TODO: t() used here.
      drupal_set_message(t('mPDF library is not included. Please run "composer install" in the root directory of your project to download and include the mPDF library.', [
        '@default_module_path' => drupal_get_path('module', 'pdf_using_mpdf'),
      ]), 'warning');
      return FALSE;
    }
  }

  /**
   * Get configuration values of this module.
   * @return array
   */
  public function getConfigValues() {
    return $this->configFactory
      ->getEditable('pdf_using_mypdf.settings')
      ->get('pdf_using_mpdf');
  }

  /**
   * Instantiate the mPDF object with required default values.
   */
  public function getMpdf() {
    $config = $this->getConfigValues();
    $paper_size = $this->getPaperSizes();

    // Get the default values here.
    $page = $config['pdf_page_size'];
    $font_size = $config['pdf_font_size'];
    $font_style = $config['pdf_default_font'];
    $margin_left = $config['margin_left'];
    $margin_right = $config['margin_right'];
    $margin_top = $config['margin_top'];
    $margin_bottom = $config['margin_bottom'];
    $margin_header = $config['margin_header'];
    $margin_footer = $config['margin_footer'];

    $this->mpdf = new \mPDF(
      '',
      [$paper_size[$page]['w'], $paper_size[$page]['h']],
      $font_size,
      $font_style,
      $margin_left,
      $margin_right,
      $margin_top,
      $margin_bottom,
      $margin_header,
      $margin_footer
    );
  }
  
  /**
   * @param Node $node
   *   The Node object to fetch html from.
   */
  public function convert(Node $node) {
    $config = $this->getConfigValues();
//    if (variable_get('pdf_using_mpdf_type_' . $node->type) == 0 ) {
//      drupal_goto(urlencode('node') . '/' . $node->nid);
//      return;
//    }

//    if (!node_access('view', $node)) {
//      drupal_set_message(t('You are not authorized to generate PDF for this page.'), 'warning');
//      drupal_goto(urlencode('node') . '/' . $node->nid);
//      return;
//    }

    if (empty($node)) {
      drupal_get_messages('error');
      drupal_set_message(t('PDF cannot be generated for this path.'), 'error');
      return;
    }

    // Checking mPDF library existence.
    if ($this->mpdfExists()) {
      $filename = $config['pdf_filename'];
      $filename = $this->token->replace($filename, ['node' => $node]);

      // Create render array for a node.
      $view = node_view($node);
      if ($this->renderer->hasRenderContext()) {
        $html = $this->renderer->renderRoot($view);
        $this->pdf_using_mpdf_generator($html, $filename);
      }
    }
  }

  /**
   * Generate the PDF file using the mPDF library.
   *
   * @param string $html
   *   contents of the template already with the node data.
   * @param string $filename
   *   name of the PDF file to be generated.
   */
  protected function pdf_using_mpdf_generator($html, $filename) {

    // Instantiate mPDF library for further use.
    $this->getMpdf();
    $this->mpdf->WriteHTML($html);
    $this->mpdf->Output($filename . '.pdf', 'D');
  }

  /**
   * International Paper Sizes ( width x height).
   * @return array
   */
  public function getPaperSizes() {
    return [
      '4A0' => ['w' => 1682, 'h' => 2378],
      '2A0' => ['w' => 1189, 'h' => 1682],
      'A0' => ['w' => 841, 'h' => 1189],
      'A1' => ['w' => 594, 'h' => 841],
      'A2' => ['w' => 420, 'h' => 594],
      'A3' => ['w' => 297, 'h' => 420],
      'A4' => ['w' => 210, 'h' => 297],
      'A5' => ['w' => 148, 'h' => 210],
      'A6' => ['w' => 105, 'h' => 148],
      'A7' => ['w' => 74, 'h' => 105],
      'A8' => ['w' => 52, 'h' => 74],
      'A9' => ['w' => 37, 'h' => 52],
      'A10' => ['w' => 26, 'h' => 37],
      'B0' => ['w' => 1000, 'h' => 1414],
      'B1' => ['w' => 707, 'h' => 1000],
      'B2' => ['w' => 500, 'h' => 707],
      'B3' => ['w' => 353, 'h' => 500],
      'B4' => ['w' => 250, 'h' => 353],
      'B5' => ['w' => 176, 'h' => 250],
      'B6' => ['w' => 125, 'h' => 176],
      'B7' => ['w' => 88, 'h' => 125],
      'B8' => ['w' => 62, 'h' => 88],
      'B9' => ['w' => 44, 'h' => 62],
      'B10' => ['w' => 31, 'h' => 44],
      'C0' => ['w' => 917, 'h' => 1297],
      'C1' => ['w' => 648, 'h' => 917],
      'C2' => ['w' => 458, 'h' => 648],
      'C3' => ['w' => 324, 'h' => 458],
      'C4' => ['w' => 229, 'h' => 324],
      'C5' => ['w' => 162, 'h' => 229],
      'C6' => ['w' => 114, 'h' => 162],
      'C7' => ['w' => 81, 'h' => 114],
      'C8' => ['w' => 57, 'h' => 81],
      'C9' => ['w' => 40, 'h' => 57],
      'C10' => ['w' => 28, 'h' => 40],
      'RA0' => ['w' => 860, 'h' => 1220],
      'RA1' => ['w' => 610, 'h' => 860],
      'RA2' => ['w' => 430, 'h' => 610],
      'SRA0' => ['w' => 900, 'h' => 1280],
      'SRA1' => ['w' => 640, 'h' => 900],
      'SRA2' => ['w' => 450, 'h' => 640],
      'Letter' => ['w' => 215.9, 'h' => 279.4],
      'Legal' => ['w' => 215.9, 'h' => 355.6],
      'Ledger' => ['w' => 279.4, 'h' => 431.8],
    ];
  }
}
