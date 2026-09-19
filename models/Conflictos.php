<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "conflictos".
 *
 * @property int $id
 * @property string $time
 * @property int $chats_id
 * @property int $usuarios_id
 *
 * @property Chats $chats
 */
class Conflictos extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'conflictos';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['time'], 'safe'],
            [['chats_id'], 'required'],
            [['chats_id'], 'integer'],
            [['usuarios_id'], 'safe'],
            [['chats_id'], 'exist', 'skipOnError' => true, 'targetClass' => Chats::className(), 'targetAttribute' => ['chats_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'time' => 'Time',
            'chats_id' => 'Chats ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChats() {
        return $this->hasOne(Chats::className(), ['id' => 'chats_id']);
    }

}
