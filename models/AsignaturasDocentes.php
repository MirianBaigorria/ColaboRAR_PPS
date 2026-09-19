<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "asignaturas_docentes".
 *
 * @property int $id
 * @property int $usuarios_id
 * @property int $asignaturas_id
 *
 * @property Asignaturas $asignaturas
 * @property Usuarios $usuarios
 */
class AsignaturasDocentes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asignaturas_docentes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuarios_id', 'asignaturas_id'], 'required'],
            [['usuarios_id', 'asignaturas_id'], 'integer'],
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
            'usuarios_id' => 'Usuarios ID',
            'asignaturas_id' => 'Asignaturas ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignatura() {
        return $this->hasOne(Asignaturas::class, ['id' => 'asignaturas_id']);  // Ajusta 'asignaturas_id' según corresponda
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuarios_id']);
    }
}
