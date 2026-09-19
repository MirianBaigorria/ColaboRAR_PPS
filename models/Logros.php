<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "logros".
 *
 * @property int $id
 * @property string $titulo
 * @property string $descripcion
 * @property int $contador
 * @property int $puntaje
 *
 * @property LogrosUsuario[] $logrosUsuarios
 */
class Logros extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'logros';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'descripcion', 'puntaje'], 'required'],
            [['descripcion'], 'string'],
            [['contador', 'puntaje'], 'integer'],
            [['titulo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'descripcion' => 'Descripcion',
            'contador' => 'Contador',
            'puntaje' => 'Puntaje',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogrosUsuarios()
    {
        return $this->hasMany(LogrosUsuario::className(), ['logros_id' => 'id']);
    }
}
