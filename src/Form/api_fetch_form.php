<?php



namespace Drupal\api_fetch\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class api_fetch_form extends FormBase {

  protected $api_fetch_client;


  
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

 

    
    $form['ids'] = [ 
        '#type' => 'number',
        '#title' => $this->t('Student(s) unique id(s)'),
        '#description' => $this->t('Ids'),
        '#required' => TRUE,
        ];

  



    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;

  }



  public function __construct( $api_client) {
    $this->api_fetch_client = $api_client;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      //Getting api client from dependencies container
      $container->get('ApiFetchClient')
    );
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

    $ids [] = $form_state->getValue('ids');
   /*
    if ($ids) {
      // Set an error for the form element with a key of "title".
      $form_state->setErrorByName('title', $this->t('Type at least one id'));
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

    // Display the results.
    // Call the Static Service Container wrapper
    // We should inject the messenger service, but its beyond the scope of this example.
    $messenger = \Drupal::messenger();
    
    $messenger->addMessage('IDs: '.$form_state->getValue('ids'));

    $_SESSION['std'] = $this->api_fetch_client->getStudent($form_state->getValue('ids'));
    $messenger->addMessage($_SESSION['std']['username'] );
 





    // Redirect to result page.
    //  $form_state->setRedirect('<front>');

  } 

}