<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "desafios".
 *
 * @property int $id
 * @property string $nombre
 * @property string $descripcion
 * @property int $rangos_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Rangos $rangos
 * @property DesafiosUsuarios[] $desafiosUsuarios
 */
class Desafios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'desafios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'descripcion', 'rangos_id'], 'required'],
            [['descripcion'], 'string'],
            [['rangos_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['nombre'], 'string', 'max' => 255],
            [['rangos_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rangos::className(), 'targetAttribute' => ['rangos_id' => 'id']],
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
            'descripcion' => 'Descripcion',
            'rangos_id' => 'Rangos ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRangos()
    {
        return $this->hasOne(Rangos::className(), ['id' => 'rangos_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDesafiosUsuarios()
    {
        return $this->hasMany(DesafiosUsuarios::className(), ['desafios_id' => 'id']);
    }
}
