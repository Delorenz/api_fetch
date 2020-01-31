<?php


namespace Drupal\api_fetch\Services;

use Drupal\user\Entity\User;
use Drupal\Core\Entity;

class ApiFetchSave {


  public function addStudent($data){
 

    $account = User::load( $data['uid']);

    if($account == NULL){

      
      $user = User::create();


      //$user->setPassword('password');
      $user->enforceIsNew();
      $user->setEmail($data['emailStudent']);
      $user->setUsername($data['nomStudent']);
     // $user->setStatus(1);
      $user->set('uid', $data['uid']);
      $result = $user->save();

      if($result){
        drupal_set_message("l'utilisateur ".$data["nomStudent"]." a été crée");
        //add data to user_data fields
        $userData = \Drupal::service('user.data');
        $userData->set('api_fetch', $data['uid'], 'genderStudent', $data['genderStudent']);
        $userData->set('api_fetch', $data['uid'], 'prenomStudent', $data['prenomStudent']);
        $userData->set('api_fetch', $data['uid'], 'promoStudent', $data['promoStudent']);
        $userData->set('api_fetch', $data['uid'], 'anneeAcademique', $data['anneeAcademiqueStudent']);
        $userData->set('api_fetch', $data['uid'], 'campusStudent', $data['campusStudent']);
        $userData->set('api_fetch', $data['uid'], 'etatDossierStudent', $data['etatDossierStudent']);
        
      }else{
        drupal_set_message("Erreur lors de la sauvegarde de l'utilisateur ".$data["nomStudent"]);
      }


    }else{
      drupal_set_message("l'utilisateur ".$data["nomStudent"]." existe déja!");
    }

   
  }


/*


$user = User::create([
  'name' => 'foobar',
  'mail' => 'foobar@example.com',
  'status' => TRUE,
]);
$user->save();



*/
}