<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace app\models;

use Yii;
use yii\base\Model;

class VerificacionPaso2Form extends Model{
    public $respuesta;
    
    public function rules(){
        return [
            [['respuesta'], 'string', 'max' => 100],
            [['respuesta'], 'required']
        ];
    }
}