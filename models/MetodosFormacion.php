<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "metodos_formacion".
 *
 * @property int $id
 * @property string $descripcion
 *
 * @property Grupos[] $grupos
 */
class MetodosFormacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'metodos_formacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrupos()
    {
        return $this->hasMany(Grupos::className(), ['metodos_formacion_id' => 'id']);
    }
    
    public static function getListaMetodosFormacion() {
        return yii\helpers\ArrayHelper::map(MetodosFormacion::find()->all(), 'id', 'descripcion');
    }
    
    public static function getNombrePorId($id) {
        $objMetodoFormacion = static::findOne(['id' => $id]);
        return $objMetodoFormacion->descripcion;
    }
}
