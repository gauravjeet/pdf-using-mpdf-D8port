<?php
/**
 * @file
 * Contains Drupal\pdf_using_mpdf\Form\AdminSettingsForm.
 */
namespace Drupal\pdf_using_mpdf\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class AdminSettingsForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'pdf_using_mpdf_config';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['pdf_using_mpdf.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
//TODO: fix error on password removal.
//TODO: default settings do not apply on module install.
    // Fetch settings for this form.
    $settings = $this->configFactory()
      ->getEditable('pdf_using_mypdf.settings')
      ->get('pdf_using_mpdf');

    $form['pdf'] = [
      '#type' => 'details',
      '#open' => TRUE,
      '#title' => $this->t('PDF Tool Option'),
    ];

    $filename = $settings['pdf_filename'];
    $form['pdf']['pdf_filename'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PDF Filename'),
      '#required' => TRUE,
      '#description' => $this->t('Default filename : @default_filename will be used.', ['@default_filename' => PDF_USING_MPDF_PDF_DEFAULT_FILENAME]),
      '#default_value' => isset($filename) && $filename != NULL ? $filename : PDF_USING_MPDF_PDF_DEFAULT_FILENAME,
    ];

    $form['pdf']['pdf_save_option'] = [
      '#type' => 'radios',
      '#title' => t('Open PDF File in'),
      '#options' => [$this->t('Web Browser'), $this->t('Save Dialog Box'), $this->t('Save to Server')],
      '#default_value' => $settings['pdf_save_option'],
      '#description' => $this->t('Defaults to Web Browser.'),
    ];

    // PDF document properties.
    $form['pdf']['property'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#title' => $this->t('Document Properties'),
      '#description' => $this->t('These properties can be seen when inspecting the document properties like in Adobe Reader.'),
    ];
    $form['pdf']['property']['pdf_set_title'] = [
      '#type' => 'textfield',
      '#size' => 35,
      '#title' => $this->t('Title'),
      '#default_value' => $settings['pdf_set_title'],
      '#description' => $this->t('Set the title for the document. If not required, leave blank.'),
    ];
    $form['pdf']['property']['pdf_set_author'] = [
      '#type' => 'textfield',
      '#size' => 35,
      '#title' => $this->t('Author'),
      '#default_value' => $settings['pdf_set_author'],
      '#description' => $this->t('Set the Author for the document. If not required, leave blank.'),
    ];
    $form['pdf']['property']['pdf_set_subject'] = [
      '#type' => 'textfield',
      '#size' => 35,
      '#title' => $this->t('Subject'),
      '#default_value' => $settings['pdf_set_subject'],
      '#description' => $this->t('Set Subject of PDF. If not required, leave blank.'),
    ];
    $form['pdf']['property']['pdf_set_creator'] = [
      '#type' => 'textfield',
      '#size' => 35,
      '#title' => $this->t('Creator'),
      '#default_value' => $settings['pdf_set_creator'],
      '#description' => $this->t('Set the document Creator. If not required, leave blank.'),
    ];

    // PDF page settings.
    $form['pdf']['page_setting'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#title' => $this->t('PDF Page Setting'),
      '#description' => $this->t('<p>All margin values should be specified as LENGTH in millimetres.</p>'),
    ];
    $form['pdf']['page_setting']['margin_top'] = [
      '#type' => 'textfield',
      '#size' => 5,
      '#title' => $this->t('Top Margin'),
      '#default_value' => $settings['margin_top'],
    ];
    $form['pdf']['page_setting']['margin_right'] = [
      '#type' => 'textfield',
      '#size' => 5,
      '#title' => $this->t('Right Margin'),
      '#default_value' => $settings['margin_right'],
    ];
    $form['pdf']['page_setting']['margin_bottom'] = [
      '#type' => 'textfield',
      '#size' => 5,
      '#title' => $this->t('Bottom Margin'),
      '#default_value' => $settings['margin_bottom'],
    ];
    $form['pdf']['page_setting']['margin_left'] = [
      '#type' => 'textfield',
      '#size' => 5,
      '#title' => $this->t('Left Margin'),
      '#default_value' => $settings['margin_left'],
    ];
    $form['pdf']['page_setting']['margin_header'] = [
      '#type' => 'textfield',
      '#size' => 5,
      '#title' => $this->t('Header Margin'),
      '#default_value' => $settings['margin_header'],
    ];
    $form['pdf']['page_setting']['margin_footer'] = [
      '#type' => 'textfield',
      '#size' => 5,
      '#title' => $this->t('Footer Margin'),
      '#default_value' => $settings['margin_footer'],
    ];
    $form['pdf']['page_setting']['pdf_font_size'] = [
      '#type' => 'textfield',
      '#size' => 5,
      '#title' => $this->t('Font Size'),
      '#default_value' => $settings['pdf_font_size'],
    ];
    $form['pdf']['page_setting']['pdf_default_font'] = [
      '#type' => 'select',
      '#title' => $this->t('Default Font Style'),
      '#options' => ['DejaVuSerif' => 'Serif', 'DejaVuSerifCondensed' => 'Serif Condensed', 'DejaVuSans' => 'Sans Serif', 'DejaVuSansCondensed' => 'Sans Serif Condensed', 'DejaVuSansMono' => 'Monospaced'],
      '#default_value' => $settings['pdf_default_font'],
      '#description' => $this->t('This style can be overridden in the stylesheet.'),
    ];
    $form['pdf']['page_setting']['pdf_page_size'] = [
      '#type' => 'select',
      '#title' => $this->t('Page Size'),
      '#options' => [
        '2A0' => '2A0', '4A0' => '4A0', 'A0' => 'A0', 'A1' => 'A1', 'A2' => 'A2', 'A3' => 'A3', 'A4' => 'A4',
        'A5' => 'A5', 'A6' => 'A6', 'A7' => 'A7', 'A8' => 'A8', 'A9' => 'A9', 'A10' => 'A10', 'B0' => 'B0', 'B1' => 'B1',
        'B2' => 'B2', 'B3' => 'B3', 'B4' => 'B4', 'B5' => 'B5', 'B6' => 'B6', 'B7' => 'B7', 'B8' => 'B8', 'B9' => 'B9',
        'B10' => 'B10', 'C0' => 'C0', 'C1' => 'C1', 'C2' => 'C2', 'C3' => 'C3', 'C4' => 'C4', 'C5' => 'C5', 'C6' => 'C6',
        'C7' => 'C7', 'C8' => 'C8', 'C9' => 'C9', 'C10' => 'C10', 'RA0' => 'RA0', 'RA1' => 'RA1', 'RA2' => 'RA2',
        'SRA0' => 'SRA0', 'SRA1' => 'SRA1', 'SRA2' => 'SRA2', 'Letter' => 'Letter', 'Legal' => 'Legal',
      ],
      '#default_value' => $settings['pdf_page_size'],
    ];
    $form['pdf']['page_setting']['dpi'] = [
      '#type' => 'textfield',
      '#size' => 5,
      '#title' => $this->t('Document DPI'),
      '#default_value' => $settings['dpi'],
    ];
    $form['pdf']['page_setting']['img_dpi'] = [
      '#type' => 'textfield',
      '#size' => 5,
      '#title' => $this->t('Image DPI'),
      '#default_value' => $settings['img_dpi'],
    ];

    // Watermark Text/ Image option.
    $form['pdf']['watermark'] = [
      '#type' => 'details',
      '#open' => TRUE,
      '#title' => $this->t('PDF Watermark Option'),
    ];
    $form['pdf']['watermark']['watermark_option'] = [
      '#type' => 'radios',
      '#title' => $this->t('Watermark Option'),
      '#options' => ['text' => $this->t('Watermark Text'), 'image' => $this->t('Watermark Image')],
      '#default_value' => $settings['watermark_option'],
    ];
    $form['pdf']['watermark']['watermark_opacity'] = [
      '#type' => 'select',
      '#title' => $this->t('Watermark Transparency'),
      '#options' => ['0.1' => '0.1', '0.2' => '0.2', '0.3' => '0.3', '0.4' => '0.4', '0.5' => '0.5', '0.6' => '0.6', '0.7' => '0.7', '0.8' => '0.8', '0.9' => '0.9', '1.0' => '1.0'],
      '#default_value' => $settings['watermark_opacity'],
    ];
    $form['pdf']['watermark']['pdf_watermark_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Watermark Text'),
      '#default_value' => $settings['pdf_watermark_text'],
      '#description' => $this->t('Display diagonal text on every page of PDF. If not required, leave it blank.'),
      '#states' => [
        'visible' => [
          ':input[name="watermark_option"]' => ['checked' => TRUE],
        ],
      ],
    ];

//TODO: Apply a check for file_validate_size here.
    $form['pdf']['watermark']['watermark_image'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Watermark Image'),
      '#default_value' => $settings['watermark_image'],
      '#upload_location' => 'public://',
      '#upload_validators' => [
        'file_validate_extensions' => ['gif png jpg jpeg'],
//        'file_validate_size' => array(MAX_FILE_SIZE * 1024 * 1024),
      ],
      '#states' => [
        'visible' => [
          ':input[name="pdf_using_mpdf_watermark_option"]' => ['checked' => FALSE],
        ],
      ],
    ];

    // Setting for PDF header.
    $form['pdf']['head_foot'] = [
      '#type' => 'details',
      '#open' => TRUE,
      '#title' => $this->t('PDF Header & Footer Option'),
      '#description' => $this->t('use {PAGENO} for page numbering or {DATE j-m-Y} for current date.'),
    ];
    $form['pdf']['head_foot']['pdf_header'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Header content'),
      '#description' => $this->t('Use a valid HTML code to write a custom header content. Example:') . ' &#60;div&#62;&#60;img src="http://www.example.com/sites/default/files/company_logo.png" width="300px" height="50px" &#62;&#60;/div&#62; &#60;hr /&#62;',
      '#default_value' => $settings['pdf_header'],
    ];

    // Setting for PDF footer.
    $form['pdf']['head_foot']['pdf_footer'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Footer content'),
      '#description' => $this->t('Use a valid HTML code to write a custom footer content. Example:') . ' &#60;hr /&#62; &#60;div style="color:#f00; text-align:center;" &#62; &#60;strong&#62;Your Company&#60;/strong&#62;, web: &#60;a href="http://example.com"&#62;www.example.com&#60;/a&#62;, email : contact@example.com&#60;/div&#62;',
      '#default_value' => $settings['pdf_footer'],
    ];

    // Setting password to PDF, if entered.
    $form['pdf']['permission'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#title' => $this->t('PDF Password Protection'),
    ];

    $pwd = $settings['pdf_password'];
    if (isset($pwd) && $pwd != NULL) {
      $form['pdf']['permission']['msg'] = [
        '#type' => 'markup',
        '#markup' => $this->t('<p>Password : ******** is already set.</p>'),
      ];
      $form['pdf']['permission']['remove_pwd'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Remove Password'),
      ];
    }
    else {
      $form['pdf']['permission']['pdf_password'] = [
        '#type' => 'password_confirm',
        '#description' => $this->t('If password is not required, leave blank. Do not use space in starting and ending of password.'),
      ];
    }

    // Setting Style Sheets to PDF.
    $form['pdf']['style'] = [
      '#type' => 'details',
      '#title' => $this->t('Custom Style Sheet for PDF'),
      '#open' => FALSE,
      '#description' => $this->t('If not required, leave blank.'),
    ];
    $form['pdf']['style']['pdf_css_file'] = [
      '#type' => 'textfield',
      '#description' => $this->t('Enter your name of css file, Example: style.css. Place all stylesheets either in the same module directory, i.e. "@module_path/" or current theme folder. If the file is in a folder in module or theme directory, enter the name with  path to that folder, for example : "css_folder/custom_style.css".', array('@module_path' => drupal_get_path('module', 'pdf_using_mpdf'))),
      '#default_value' => $settings['pdf_css_file'],
    ];

    // Setting PDF permissions.
    $form['pdf']['permissions'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#title' => $this->t('Content Type Permissions'),
    ];

    //TODO: make this $type_name working here.
//    $form['pdf']['permissions']['pdf_using_mpdf_type_' . $type_name] = array(
//      '#markup' => '<strong>' . t('Enable PDF generation for the following node types') . '</strong>',
//    );
//    $node_types = node_type_get_names();
//    foreach ($node_types as $type_name => $node_type_name ) {
//      $form['pdf']['permissions']['pdf_using_mpdf_type_' . $type_name] = array(
//        '#type' => 'checkbox',
//        '#title' => $node_type_name,
////        '#default_value' => variable_get('pdf_using_mpdf_type_' . $type_name) != NULL ? 1 : 0,
//      );
//    }
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $settings = [
      'pdf_filename' => $values['pdf_filename'],
      'pdf_save_option' => $values['pdf_save_option'],
      'pdf_set_title' => $values['pdf_set_title'],
      'pdf_set_author' => $values['pdf_set_author'],
      'pdf_set_subject' => $values['pdf_set_subject'],
      'pdf_set_creator' => $values['pdf_set_creator'],
      'margin_top' => $values['margin_top'],
      'margin_right' => $values['margin_right'],
      'margin_bottom' => $values['margin_bottom'],
      'margin_left' => $values['margin_left'],
      'margin_header' => $values['margin_header'],
      'margin_footer' => $values['margin_footer'],
      'pdf_font_size' => $values['pdf_font_size'],
      'pdf_default_font' => $values['pdf_default_font'],
      'pdf_page_size' => $values['pdf_page_size'],
      'dpi' => $values['dpi'],
      'img_dpi' => $values['img_dpi'],
      'watermark_option' => $values['watermark_option'],
      'watermark_opacity' => $values['watermark_opacity'],
      'pdf_watermark_text' => $values['pdf_watermark_text'],
      'watermark_image' => $values['watermark_image'],
      'pdf_header' => $values['pdf_header'],
      'pdf_footer' => $values['pdf_footer'],
      'pdf_password' => $values['pdf_password'],
      'pdf_css_file' => $values['pdf_css_file'],
    ];

    // Save the configuration into database.
    $this->configFactory()
      ->getEditable('pdf_using_mypdf.settings')
      ->set('pdf_using_mpdf', $settings)
      ->save();

    parent::submitForm($form, $form_state);
  }
}
