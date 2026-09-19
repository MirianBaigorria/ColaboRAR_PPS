<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cuestionariosconflicto".
 *
 * @property int $id
 * @property double $nc1
 * @property double $nc2
 * @property double $nc3
 * @property double $nc4
 * @property double $nc5
 * @property double $nc6
 * @property double $nc7
 * @property double $nc8
 * @property double $cc1
 * @property double $cc2
 * @property double $cc3
 * @property double $cc4
 * @property double $cc5
 * @property double $cc6
 * @property double $cc7
 * @property double $cc8
 * @property double $cc9
 * @property double $cc10
 * @property double $cc11
 * @property double $cc12
 * @property double $cc13
 * @property double $cc14
 * @property double $cc15
 * @property double $cc16
 * @property double $cc17
 * @property double $cc18
 * @property double $cc19
 * @property double $cc20
 * @property int $sentencias_id
 *
 * @property Sentencias $sentencias
 */
class Cuestionariosconflicto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cuestionariosconflicto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nc1', 'nc2', 'nc3', 'nc4', 'nc5', 'nc6', 'nc7', 'nc8', 'cc1', 'cc2', 'cc3', 'cc4', 'cc5', 'cc6', 'cc7', 'cc8', 'cc9', 'cc10', 'cc11', 'cc12', 'cc13', 'cc14', 'cc15', 'cc16', 'cc17', 'cc18', 'cc19', 'cc20'], 'number'],
            [['sentencias_id'], 'required'],
            [['sentencias_id'], 'integer'],
            [['sentencias_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sentencias::className(), 'targetAttribute' => ['sentencias_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nc1' => 'Nc1',
            'nc2' => 'Nc2',
            'nc3' => 'Nc3',
            'nc4' => 'Nc4',
            'nc5' => 'Nc5',
            'nc6' => 'Nc6',
            'nc7' => 'Nc7',
            'nc8' => 'Nc8',
            'cc1' => 'Cc1',
            'cc2' => 'Cc2',
            'cc3' => 'Cc3',
            'cc4' => 'Cc4',
            'cc5' => 'Cc5',
            'cc6' => 'Cc6',
            'cc7' => 'Cc7',
            'cc8' => 'Cc8',
            'cc9' => 'Cc9',
            'cc10' => 'Cc10',
            'cc11' => 'Cc11',
            'cc12' => 'Cc12',
            'cc13' => 'Cc13',
            'cc14' => 'Cc14',
            'cc15' => 'Cc15',
            'cc16' => 'Cc16',
            'cc17' => 'Cc17',
            'cc18' => 'Cc18',
            'cc19' => 'Cc19',
            'cc20' => 'Cc20',
            'sentencias_id' => 'Sentencias ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSentencias()
    {
        return $this->hasOne(Sentencias::className(), ['id' => 'sentencias_id']);
    }
}
