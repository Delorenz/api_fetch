<?php

namespace Drupal\api_fetch\Controller;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
class ApiFetchResultController extends ControllerBase{

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
    public function content() {
        if(isset($_SESSION['ParsedData'])){

        $data = $_SESSION['ParsedData'];
        unset($_SESSION['ParsedData']);


        foreach($data as $uid){
            $students [] = $this->api_fetch_client->getStudent($uid);
        }
            
               // var_dump($students);
            
               
               return array(
                '#theme' => 'api-fetch-result',
            
                '#students' => $students,
                
    
                );      
                    
            
        


        }else{
            drupal_set_message('ParsedData not set');
            
            return $this->redirect('api.form');

        }

        
    }
    
}