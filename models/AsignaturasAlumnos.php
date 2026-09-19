<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "asignaturas_alumnos".
 *
 * @property int $id
 * @property int $year
 * @property int $asignaturas_id
 * @property int $usuarios_id
 *
 * @property Asignaturas $asignaturas
 * @property Usuarios $usuarios
 */
class AsignaturasAlumnos extends \yii\db\ActiveRecord
{
    public $estiloaprendizaje;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asignaturas_alumnos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year', 'asignaturas_id', 'usuarios_id'], 'integer'],
            [['asignaturas_id', 'usuarios_id'], 'required'],
            [['asignaturas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Asignaturas::className(), 'targetAttribute' => ['asignaturas_id' => 'id']],
            [['usuarios_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuarios_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'year' => 'Año',
            'asignaturas_id' => 'Asignaturas ID',
            'usuarios_id' => 'Usuarios ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignaturas()
    {
        return $this->hasOne(Asignaturas::className(), ['id' => 'asignaturas_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuarios_id']);
    }
    
    public static function getListaAlumnosPorYear($year, $asigid) {
        $query = $query = (new \yii\db\Query())
                ->select(['aa.id', 'aa.year', 'aa.asignaturas_id', 'aa.usuarios_id', 'u.estiloaprendizaje', 'u.nombre', 'u.apellido', 'u.id as idUsuario'])
                
                ->from('asignaturas_alumnos as aa')
                ->innerJoin('usuarios as u', 'aa.usuarios_id = u.id')
                ->where(['year' => $year, 'asignaturas_id' => $asigid, 'u.tipo' => 0]);
        //echo $query->createCommand()->sql; die();
        return $query->all();
    }
}
