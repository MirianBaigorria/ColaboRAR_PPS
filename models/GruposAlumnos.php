<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grupos_alumnos".
 *
 * @property int $id
 * @property int $usuarios_id
 * @property int $grupos_formados_id
 *
 * @property GruposFormados $gruposFormados
 * @property Usuarios $usuarios
 */
class GruposAlumnos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grupos_alumnos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuarios_id', 'grupos_formados_id'], 'required'],
            [['usuarios_id', 'grupos_formados_id'], 'integer'],
            [['grupos_formados_id'], 'exist', 'skipOnError' => true, 'targetClass' => GruposFormados::className(), 'targetAttribute' => ['grupos_formados_id' => 'id']],
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
            'grupos_formados_id' => 'Grupos Formados ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGruposFormados()
    {
        return $this->hasOne(GruposFormados::className(), ['id' => 'grupos_formados_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuarios_id']);
    }
}
