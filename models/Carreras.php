<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "carreras".
 *
 * @property int $id
 * @property string $nombre
 * @property string $universidad
 */
class Carreras extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carreras';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['universidad'], 'required'],
            [['nombre', 'universidad'], 'string', 'max' => 255],
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
            'universidad' => 'Universidad',
        ];
    }
}
