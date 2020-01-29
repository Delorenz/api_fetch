<?php



namespace Drupal\api_fetch\Services;

use Drupal\Component\Serialization\Json;

class ApiFetchClient {

  /*
  * TODO:
  *   -Add getStudentByEmail
  *   -Add getStudentsByPromo
  *   -Add getStudentsByAnneeAcademique
  *   -Handle 404 response from API
  *   -Set base uri in config ?
  */  

  /**
   * @var \GuzzleHttp\Client
   */
  protected $client;

  /**
   * ApiFetchClient constructor.
   *
   * @param $http_client_factory \Drupal\Core\Http\ClientFactory
   */
  public function __construct($http_client_factory) {
    $this->client = $http_client_factory->fromOptions([
      'base_uri' => 'http://localhost/api.test/public/', //API uri
    ]);
  }

  /**
   * Get student by id
   *
   * @param int $id
   *
   * @return array
   */
  public function getStudent($id) {
   $url = 'student/'.$id;
  
   
    $response = $this->client->get($url);

    return Json::decode($response->getBody());
  }


  /**
   * Get all students
   *
   * 
   *
   * @return array
   */
  public function getStudents() {
     $url = 'students';
   
     
     $response = $this->client->get($url);
 
     return Json::decode($response->getBody());
   }

}

