<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace app\models;

use Yii;
use yii\base\Model;

class RecuperarPasswordForm extends Model{
    public $username;
    public $password;
    
    public function rules(){
        return [
            [['username'], 'string', 'max' => 45],
            [['password'], 'string', 'max' => 255],
            [['username', 'password'], 'required']
        ];
    }
}