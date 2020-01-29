<?php

namespace Drupal\api_fetch\Services;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\file\Entity;
use Drupal\Component\Utility\Environment;
use Drupal\Core\File\FileSystemInterface;

    //TODO : Handle 404 and Exceptions
 
  
                

class ApiFetchCsv{

    /**
   * ApiFetchCsv parserValidateUpload.
   * Validate upload form
   * @param $form_state \Drupal\Core\Form\FormStateInterface
   */
    public function parserValidateForm(FormStateInterface $form_state){

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
      
    }

    /**
   * ApiFetchCsv parserValidateUpload.
   * Validate uploaded csv file
   * @param $form_state \Drupal\Core\Form\FormStateInterface
   */
    public function parserValidateUpload(FormStateInterface $form_state){
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
      

    }

   
     /**
   * ApiFetchCsv getIds.
   * Parse csv file and return an array of ids
   * @param $form_state \Drupal\Core\Form\FormStateInterface
   * @return array
   */   
    public function getIds(FormStateInterface $form_state){
   
        if ($csvupload = $form_state->getValue('csvupload')) { 
           
            if ($handle = fopen($csvupload, 'r')) {
              
            $i =0;
            while ($line = fgetcsv($handle, 4096)) { 
                
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

     /**
   * ApiFetchCsv getEmails.
   * Parse csv file and return an array of emails
   * @param $form_state \Drupal\Core\Form\FormStateInterface
   * @return array
   */  
    public function getEmails(FormStateInterface $form_state){

        if ($csvupload = $form_state->getValue('csvupload')) { 
        
            if ($handle = fopen($csvupload, 'r')) {
        
            $i =0;
            while ($line = fgetcsv($handle, 4096)) {
        
    
            
                if($i>0){
                    $std[] = $line[1];
                }
                $i++;
                
                }
                fclose($handle);
            }
        }

        return $std;

    }


}