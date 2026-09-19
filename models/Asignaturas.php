<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "asignaturas".
 * @property int $id
 * @property string $nombre
 * @property int $year
 * @property int $carreras_id
 * @property int $estado
 * @property AsignaturasDocentes[] $asignaturasDocentes
 * @property Grupos[] $grupos
 */
class Asignaturas extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'asignaturas';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['nombre'], 'string', 'max' => 100], 
            [['carreras_id', 'year'], 'integer'], 
            [['nombre', 'year'], 'required'], 
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'carreras_id' => 'ID Carrera',
            'year' => 'Año'
        ];
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    
    public function getAsignaturasDocentes() {
        return $this->hasMany(AsignaturasDocentes::className(), ['asignaturas_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getGrupos() {
        return $this->hasMany(Grupos::className(), ['asignaturas_id' => 'id']);
    }


     public function getNombreCompleto() {
        $objCarrera = Carreras::findOne(['id' => $this->carreras_id]);
        return $this->nombre . ', ' . $objCarrera->nombre . ', ' . $objCarrera->universidad;
    }

    
    public static function getListaAsignaturas() {
        return yii\helpers\ArrayHelper::map(
            Asignaturas::find()
                ->orderBy(['nombre' => SORT_ASC]) // Agregamos la cláusula orderBy y ordena nombre de manera ascendente
                ->all(),
            'id',
            'nombrecompleto'
        );
    }


    public static function getNombrePorId($id) {
        // Obtener solo el campo nombre de la tabla Asignaturas
        $objAsignatura = static::find()->select('nombre, carreras_id')->where(['id' => $id])->one();
        // Si no se encuentra la asignatura, se devuelve un valor por defecto
        if ($objAsignatura === null) {
            return 'Asignatura no encontrada';
        }
        // Obtener el campo nombre directamente sin cargar toda la asignatura
        $objCarrera = Carreras::find()->select('nombre, universidad')->where(['id' => $objAsignatura->carreras_id])->one();
        // Si no se encuentra la carrera, se devuelve un valor por defecto
        if ($objCarrera === null) {
            return 'Carrera no encontrada';
        }
        // Concatenar el nombre de la asignatura con el nombre y la universidad de la carrera
        return $objAsignatura->nombre . ', ' . $objCarrera->nombre . ', ' . $objCarrera->universidad;
    }
    

    public static function getYearPorId($id) {
        $objAsignatura = static::find()->select('year')->where(['id' => $id])->one();
        return $objAsignatura->year;
    }


}
