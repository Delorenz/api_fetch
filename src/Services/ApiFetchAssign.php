<?php



namespace Drupal\api_fetch\Services;

use Drupal\user\Entity\User;

class ApiFetchAssign {

    public function AssignStudent(UserInterface $std,int $group_id){

        $target = \Drupal::entityTypeManager()->getStorage('group')->load($group_id);
        $data = [];
        $target->addMember($std, $data);

    }

    public function AssignStudents(Array $stds, int $group_id){

    }


}
