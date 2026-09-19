<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sentencias_apertura".
 *
 * @property int $id
 * @property string $sentencia
 * @property int $atributo
 * @property int $habilidad
 * @property int $subhabilidad
 *
 * @property SentenciasConSentenciasApertura[] $sentenciasConSentenciasAperturas
 */
class SentenciasApertura extends \yii\db\ActiveRecord {

    public $a_atributos = [
        1 => 'Medicación Docente',
        2 => 'Conciliar',
        3 => 'Concertar',
        4 => 'Discrepar',
        5 => 'Ofrecer Alternativa',
        6 => 'Inferir',
        7 => 'Suponer',
        8 => 'Proponer Excepciones',
        9 => 'Dudar',
        10 => 'Animar',
        11 => 'Reforzar',
        12 => 'Parafrasear',
        13 => 'Guiar',
        14 => 'Sugerir',
        15 => 'Elaborar',
        16 => 'Explicar/Clarificar',
        17 => 'Justificar',
        18 => 'Afirmar',
        19 => 'Información',
        20 => 'Elaboración',
        21 => 'Clarificación',
        22 => 'Justificación',
        23 => 'Opinión',
        24 => 'Ilustración',
        25 => 'Apreciación'];
    public $a_subhabilidad = [
        1 => 'Mediación',
        2 => 'Argumentación',
        3 => 'Motivar',
        4 => 'Informar',
        5 => 'Requerir',
        6 => 'Reconocimiento',
        7 => 'Mantenimiento',
        8 => 'Tarea'
    ];
    public $a_habilidad = [
        1 => 'Conflicto Creativo',
        2 => 'Aprendizaje Activo',
        3 => 'Conversación'
    ];
    

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'sentencias_apertura';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['sentencia'], 'string', 'max' => 255],
            [['atributo', 'habilidad', 'subhabilidad'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'sentencia' => 'Sentencia',
            'atributo' => 'Atributo',
            'habilidad' => 'Habilidad',
            'subhabilidad' => 'Subhabilidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSentenciasConSentenciasAperturas() {
        return $this->hasMany(SentenciasConSentenciasApertura::className(), ['sentencias_apertura_id' => 'id']);
    }
    
    public static function getSentenciasAperturaPorSubhabilidad($idsubhab) {
        return yii\helpers\ArrayHelper::map(SentenciasApertura::find()->where(['subhabilidad' => $idsubhab])->all(), 'id', 'sentencia');
    }


}
