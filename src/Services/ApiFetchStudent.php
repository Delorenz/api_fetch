<?php


namespace Drupal\api_fetch\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\user\Entity\User;
use Drupal\Core\Entity;


class ApiFetchStudent {

  public function addStudent($data){

    
    //Check if user already exist in DB
    $account = User::load( $data['uid']);

    if($account == NULL){

      
      $user = User::create();

      //create and hydrate new user entity
      //$user->setPassword('password');
      $user->enforceIsNew();
      $user->setEmail($data['emailStudent']);
      $user->setUsername($data['nomStudent']);
      $user->set('uid', $data['uid']);
      $user->addRole('Student');
      $result = $user->save();

      if($result){
        drupal_set_message("l'utilisateur ".$data["nomStudent"]." a été créé");
        //add data to user_data fields
        $student = array("prenomStudent"=>$data['genderStudent'] ,
        'genderStudent'=> $data['genderStudent'], 
        'promoStudent'=> $data['promoStudent'],
        'anneeAcademiqueStudent' =>$data['anneeAcademiqueStudent'],
        'campusStudent'=>$data['campusStudent'],
        'etatDossierStudent'=>$data['etatDossierStudent']);

        $userData = \Drupal::service('user.data');
        $userData->set('api_fetch', $data['uid'], 'student_data', $student);
        
        
      }else{
        drupal_set_message("Erreur lors de la sauvegarde de l'utilisateur ".$data["nomStudent"]);
      }


    }else{
      drupal_set_message("l'utilisateur ".$data["nomStudent"]." existe déja!");
    }

   
  }


  public function getStudentData($uid){
    $userData = \Drupal::service('user.data');
    return $userData->get('api_fetch', $uid, 'student_data');
  }

  public function setStudentData($data){
    $userData = \Drupal::service('user.data');
    $userData->set('api_fetch', $data['uid'], 'student_data', $student);

  }


  public function getPrenomStudent($uid){
    $data = $this->getStudentData($uid);
    return $data['prenomStudent'];

  }

  public function setPrenomStudent($uid, $prenom){
    $data = $this->getStudentData($uid);
    $data['prenomStudent'] = $prenom;
    $this->setStudentData($data);

  }

  public function getGenreStudent($uid){
    $data = $this->getStudentData($uid);
    return $data['genreStudent'];

  }

  public function setGenreStudent($uid, $genre){
    $data = $this->getStudentData($uid);
    $data['genreStudent'] = $genre;
    $this->setStudentData($data);

  }

  public function getPromoStudent($uid){
    $data = $this->getStudentData($uid);
    return $data['promoStudent'];

  }

  public function setPromoStudent($uid, $promo){
    $data = $this->getStudentData($uid);
    $data['promoStudent'] = $promo;
    $this->setStudentData($data);

  }

  public function getAnneeAcademiquetudent($uid){
    $data = $this->getStudentData($uid);
    return $data['anneeAcademiqueStudent'];

  }

  public function setAnneeAcademiqueStudent($uid, $aa){
    $data = $this->getStudentData($uid);
    $data['anneeAcademiqueStudent'] = $aa;
    $this->setStudentData($data);

  }

  public function getCampusStudent($uid){
    $data = $this->getStudentData($uid);
    return $data['campusStudent'];
  }

  public function setCampusStudent($uid, $campus){
    $data = $this->getStudentData($uid);
    $data['campusStudent'] = $campus;
    $this->setStudentData($data);

  }

  public function getEtatDossierStudent($uid){
    $data = $this->getStudentData($uid);
    return $data['etatDossierStudent'];

  }

  public function setEtatDossierStudent($uid, $ed){
    $data = $this->getStudentData($uid);
    $data['etatDossierStudent'] = $ed;
    $this->setStudentData($data);

  }

}