<?php

namespace Portfolio\Model;
    
class LoginManager extends Database {

    public function getUsers() {
       $users = $this->query('select * from user');

       $list = [];
       foreach ($users as $key => $user) {
           $model = new User();
           $model->hydrate($user);
           $list[] = $model;
       }

       return $list;
    }

}