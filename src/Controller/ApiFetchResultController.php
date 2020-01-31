<?php

namespace Drupal\api_fetch\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ApiFetchResultController extends ControllerBase{

    public function __construct( $api_client, $parser, $ssave) {
        $this->api_fetch_client = $api_client;
        $this->parser = $parser;
        $this->ssave = $ssave;
      }
    
      /**
       * {@inheritdoc}
       */
      public static function create(ContainerInterface $container) {
        return new static(
          $container->get('ApiFetchClient'),
          $container->get('ApiFetchCsv'),
          $container->get('ApiFetchStudent'),
        );
      }
    public function content() {
        if(isset($_SESSION['ParsedData'])){

        $data = $_SESSION['ParsedData'];
        unset($_SESSION['ParsedData']);

        //Fetch students from API    
        foreach($data as $mail){
            $students [] = $this->api_fetch_client->getStudentByEmail($mail); 
        }



        //Add Students to Database
        foreach($students as $student){
          $this->ssave->addStudent($student);
        }
                //var_dump( $this->ssave->getStudentData(2));
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