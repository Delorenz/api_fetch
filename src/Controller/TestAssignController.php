<?php

namespace Drupal\api_fetch\Controller;

use Drupal\group\Entity\Group;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity;


class TestAssignController extends ControllerBase{


   

    public function content() {

        $user = \Drupal\user\Entity\User::load(55);
        $data =[];
        $learning_path = \Drupal::entityTypeManager()->getStorage('group')->load(10);
        $learning_path->addMember($usr, $data);


        //$course->addMemver($usr, $data);
        //$grp = \Drupal\group\Entity\Group::addMember($usr,$data);
     //   var_dump($usr);
        //$ent=\Drupal::entityManager()->getDefinitions();

        /*
        foreach($ent as $item){
            echo '****';
            var_dump($item->getLabel());
            echo '****';
        }
        */
        die;
        //$this->grp::addMember($usr);
        return;
    }
}