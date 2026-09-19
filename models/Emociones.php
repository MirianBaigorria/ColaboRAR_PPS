<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "emociones".
 *
 * @property int $id
 * @property double $valencia
 * @property double $activacion
 * @property double $dominancia
 * @property int $chats_id
 * @property int $usuarios_id
 * @property string $time
 *
 * @property Sentencias $sentencias
 */
class Emociones extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'emociones';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['valencia', 'activacion', 'dominancia'], 'number'],
            [['chats_id'], 'required'],
            [['chats_id'], 'integer'],
            [['usuarios_id'], 'safe'],
            [['time'], 'safe'],            
            [['chats_id'], 'exist', 'skipOnError' => true, 'targetClass' => Chats::className(), 'targetAttribute' => ['chats_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'valencia' => 'Valencia',
            'activacion' => 'Activacion',
            'dominancia' => 'Dominancia',
            'chats_id' => 'Chat ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChats() {
        return $this->hasOne(Chats::className(), ['id' => 'chats_id']);
    }

}
