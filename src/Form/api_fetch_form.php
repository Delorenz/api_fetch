<?php



namespace Drupal\api_fetch\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\file\Entity;

use Drupal\Component\Utility\Environment;
use Drupal\Core\File\FileSystemInterface;

class api_fetch_form extends FormBase {

  protected $api_fetch_client;
  protected  $parser;

  
  /**
   * Returns a unique string identifying the form.
   *
   * The returned ID should be a unique string that can be a valid PHP function
   * name, since it's used in hook implementation names such as
   * hook_form_FORM_ID_alter().
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'api_form';
  }


   /**
   * Form constructor.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form structure.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

 
    $form_state->disableCache(); 

      
    $form['#attributes'] = [
      'enctype' => 'multipart/form-data',
    ];


    
    $form['csvfile'] = [
      '#title'            => $this->t('CSV File'),
      '#type'             => 'file',
      '#description'      => ($max_size = Environment::getUploadMaxSize()) ? $this->t('Due to server restrictions, the <strong>maximum upload file size is @max_size</strong>. Files that exceed this size will be disregarded.', ['@max_size' => format_size($max_size)]) : '',
      '#element_validate' => ['::validateFileupload'],
    ];

   
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;

  }



  public function __construct( $api_client, $parser) {
    $this->api_fetch_client = $api_client;
    $this->parser = $parser;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('ApiFetchClient'),
      $container->get('ApiFetchCsv'),
    );
  }


  public /* static <- default */function validateFileupload(&$element, FormStateInterface $form_state, &$complete_form) {
   
   $this->parser->parserValidateUpload($form_state); 
   //vvv Old way vvv
    /*
      $validators = [
        'file_validate_extensions' => ['csv CSV'],
      ];

      // @TODO: File_save_upload will probably be deprecated soon as well.
      // @see https://www.drupal.org/node/2244513.
      if ($file = file_save_upload('csvfile', $validators, FALSE, 0, FILE_EXISTS_REPLACE)) {

        // The file was saved using file_save_upload() and was added to the
        // files table as a temporary file. We'll make a copy and let the
        // garbage collector delete the original upload.
        $csv_dir = 'public://uploads';
        $directory_exists = \Drupal::service('file_system')
          ->prepareDirectory($csv_dir, FileSystemInterface::CREATE_DIRECTORY);

        if ($directory_exists) {
          $destination = $csv_dir . '/' . $file->getFilename();
          if (file_copy($file, $destination, FileSystemInterface::EXISTS_REPLACE)) {
            $form_state->setValue('csvupload', $destination);
          }
          else {
            $form_state->setErrorByName('csvimport', t('Unable to copy upload file to @dest', ['@dest' => $destination]));
          }
        }
      }
    */
  }



  /**
   * Validate the title and the checkbox of the form
   * 
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   * 
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    $this->parser->parserValidateForm($form_state);

    //vvv Old way vvv
/*
    if ($csvupload = $form_state->getValue('csvupload')) {

      if ($handle = fopen($csvupload, 'r')) {

        if ($line = fgetcsv($handle, 4096)) {

         

          // Validate the uploaded CSV here.
          // // if ( $line[0] == 'id' || $line[1] != 'email' )
        }
        fclose($handle);
      }
      else {
        $form_state->setErrorByName('csvfile', $this->t('Unable to read uploaded file @filepath', ['@filepath' => $csvupload]));
      }
    }

*/
  }


    /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $ids = $this->parser->getIds($form_state);
    $_SESSION['ParsedData'] = $ids;
    $form_state->setRedirect('api.result');
    return;
  } 

}