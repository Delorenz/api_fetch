<?php

namespace Drupal\api_fetch\Services;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\file\Entity;
use Drupal\Component\Utility\Environment;
use Drupal\Core\File\FileSystemInterface;

    //TODO : Handle 404 and Exceptions
        // Add fetch by email
        // Check attr
                

class ApiFetchCsv{




        //Try with form_id then getform ?
    public function getIds(FormStateInterface $form_state){
   
        if ($csvupload = $form_state->getValue('csvupload')) { 
           
            if ($handle = fopen($csvupload, 'r')) {
              
            $i =0;
            while ($line = fgetcsv($handle, 4096)) { //stuck here
                
                if($i>0){
                    $std[] = $line[0];
                   
                    
                }
                $i++;
                
                }
                fclose($handle);
            }
        }
      
        return $std;

    }

    public function getEmails(FormStateInterface $form_state){

        if ($csvupload = $form_state->getValue('csvupload')) { 
        
            if ($handle = fopen($csvupload, 'r')) {
        
            $i =0;
            while ($line = fgetcsv($handle, 4096)) {
        
    
            
                if($i>0){
                    $std[] = $line[1];
                    $i++;
                }
                
                fclose($handle);
                }
            }
        }

        return $std;

    }


}