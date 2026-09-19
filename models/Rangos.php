<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rangos".
 *
 * @property int $id
 * @property string $nombre
 * @property int $nivel
 * @property string $descripcion
 * @property string $imagen
 *
 * @property Desafios[] $desafios
 * @property RangosUsuarios[] $rangosUsuarios
 */
class Rangos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rangos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'nivel'], 'required'],
            [['nivel'], 'integer'],
            [['nombre'], 'string', 'max' => 155],
            [['descripcion', 'imagen'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'nivel' => 'Nivel',
            'descripcion' => 'Descripcion',
            'imagen' => 'Imagen',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDesafios()
    {
        return $this->hasMany(Desafios::className(), ['rangos_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRangosUsuarios()
    {
        return $this->hasMany(RangosUsuarios::className(), ['rangos_id' => 'id']);
    }
}
