<?php

namespace Drupal\api_fetch\Controller;
use Drupal\Core\Controller\ControllerBase;

class ApiFetchResultController extends ControllerBase{


    public function content() {
        
    
      
        return array(
            '#theme' => 'api-fetch-result',
        
            '#students' => "test",
    
 
            );
            
            
    
    }
}