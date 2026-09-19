<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grupos_formados".
 *
 * @property int $id
 * @property string $nombre
 * $grupos_id
 *
 * @property GruposAlumnos[] $gruposAlumnos
 * @property Grupos $grupos
 * @property int puntaje
 */
class GruposFormados extends \yii\db\ActiveRecord {

    public $nombreAlumno;
    public $apellidoAlumno;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'grupos_formados';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['grupos_id'], 'required'],
            [['grupos_id'], 'integer'],
            [['nombre'], 'string', 'max' => 45],
            [['puntaje'], 'integer'],
            [['grupos_id'], 'exist', 'skipOnError' => true, 'targetClass' => Grupos::className(), 'targetAttribute' => ['grupos_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'grupos_id' => 'Grupos ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGruposAlumnos() {
        return $this->hasMany(GruposAlumnos::className(), ['grupos_formados_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrupos() {
        return $this->hasOne(Grupos::className(), ['id' => 'grupos_id']);
    }
    //un solo grupo
    public static function getDetalleGrupo($grupos_formados_id)
    {
        $query = (new \yii\db\Query())
            ->select(['gf.id', 'gf.nombre', 'g.codigo', 'u.nombre as nombreAlumno', 'u.apellido as apellidoAlumno'])
            ->from('grupos_formados as gf')
            ->innerJoin('grupos as g', 'gf.grupos_id = g.id')
            ->innerJoin('grupos_alumnos as ga', 'gf.id = ga.grupos_formados_id')
            ->innerJoin('usuarios as u', 'ga.usuarios_id = u.id')
            ->where(['gf.id' => $grupos_formados_id]) //esta es la diferencia, aqui traeos 1 solo grupo
            ->orderBy('gf.nombre');

        return $query->all();
    }
    public static function getDetalleGrupos($grupos_id) {

        $query = (new \yii\db\Query())
                ->select(['gf.id','gf.nombre', 'g.codigo', 'u.nombre as nombreAlumno', 'u.apellido as apellidoAlumno', 'u.id AS alumnoId'])
                ->from('grupos_formados as gf')
                ->innerJoin('grupos as g', 'gf.grupos_id = g.id')
                ->innerJoin('grupos_alumnos as ga', 'gf.id = ga.grupos_formados_id')
                ->innerJoin('usuarios as u', 'ga.usuarios_id = u.id')
                ->where(['gf.grupos_id' => $grupos_id])
                ->orderBy('gf.nombre');

        //echo $query->createCommand()->sql; die();
        return $query->all();
        ;
    }

    public static function getListaGrupos($grupos_id) {
    return \yii\helpers\ArrayHelper::map(
        GruposFormados::find()
            ->where(['grupos_id' => $grupos_id])
            ->all(),
        'id',
        'nombre'
    );
    }

}
