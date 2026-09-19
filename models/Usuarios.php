<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios".
 * @property int $id
 * @property int $pais_idpais
 * @property string $username
 * @property string $password
 * @property string $nombre
 * @property string $apellido
 * @property integer $tipo
 * @property string $estiloaprendizaje
 * @property string $personalidad
 * @property string $auth_key
 * @property string $fechanacimiento
 * @property string $email
 * @property string $foto_perfil
 * @property string $dni
 * @property string $pregunta
 * @property string $respuesta
 * @property string $institucion
 * @property AsignaturasDocentes[] $asignaturasDocentes
 * @property GruposAlumnos[] $gruposAlumnos
 * @property Sentencias[] $sentencias
 * @property integer $cont_actividades_individuales 
 * @property integer $cont_actividades_grupales 
 *
 */
class Usuarios extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {

    //public $aceptaterminos;
    //Variables para mantener las respuestas al test de Felder-Silverman
    public $preg1;
    public $preg2;
    public $preg3;
    public $preg4;
    public $preg5;
    public $preg6;
    public $preg7;
    public $preg8;
    public $preg9;
    public $preg10;
    public $preg11;
    public $preg12;
    public $preg13;
    public $preg14;
    public $preg15;
    public $preg16;
    public $preg17;
    public $preg18;
    public $preg19;
    public $preg20;
    public $preg21;
    public $preg22;
    public $preg23;
    public $preg24;
    public $preg25;
    public $preg26;
    public $preg27;
    public $preg28;
    public $preg29;
    public $preg30;
    public $preg31;
    public $preg32;
    public $preg33;
    public $preg34;
    public $preg35;
    public $preg36;
    public $preg37;
    public $preg38;
    public $preg39;
    public $preg40;
    public $preg41;
    public $preg42;
    public $preg43;
    public $preg44;
    // Test Big Five
    public $preg1_bf;
    public $preg2_bf;
    public $preg3_bf;
    public $preg4_bf;
    public $preg5_bf;
    public $preg6_bf;
    public $preg7_bf;
    public $preg8_bf;
    public $preg9_bf;
    public $preg10_bf;
    public $preg11_bf;
    public $preg12_bf;
    public $preg13_bf;
    public $preg14_bf;
    public $preg15_bf;
    public $preg16_bf;
    public $preg17_bf;
    public $preg18_bf;
    public $preg19_bf;
    public $preg20_bf;
    public $preg21_bf;
    public $preg22_bf;
    public $preg23_bf;
    public $preg24_bf;
    public $preg25_bf;
    public $preg26_bf;
    public $preg27_bf;
    public $preg28_bf;
    public $preg29_bf;
    public $preg30_bf;
    public $preg31_bf;
    public $preg32_bf;
    public $preg33_bf;
    public $preg34_bf;
    public $preg35_bf;
    public $preg36_bf;
    public $preg37_bf;
    public $preg38_bf;
    public $preg39_bf;
    public $preg40_bf;
    public $preg41_bf;
    public $preg42_bf;
    public $preg43_bf;
    public $preg44_bf;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'usuarios';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['username', 'password','pais_idpais','fechanacimiento', 'email', 'nombre', 'apellido', 'dni', 'pregunta', 'respuesta', 'institucion'], 'required'],
            [['tipo'], 'integer'],
            [['username'], 'string', 'max' => 45], 
            ['username', 'unique', 'targetClass' => '\app\models\Usuarios', 'message' => 'Este nombre de usuario, ya existe.'],
            [['password'], 'string', 'max' => 255], 
            [['nombre', 'apellido'], 'string', 'max' => 150], 
            [['estiloaprendizaje'], 'string', 'max' => 30],
            [['personalidad'], 'string', 'max' => 100], 
            [['fechanacimiento'], 'string', 'max' => 30], 
            [['fechanacimiento'], 'default', 'value' => null],
            [['email'], 'string', 'max' => 100],
            [['pais_idpais'], 'integer'], 
            [['foto_perfil'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 1024 * 2],
            [['cont_actividades_individuales'], 'integer'],
            [['cont_actividades_grupales'], 'integer'],
            [['dni'], 'string', 'max' => 15], //Dni debe ser un string de maximo 15 caracteres
            [['dni'], 'unique', 'targetClass' => '\app\models\Usuarios', 'message' => 'DNI/CI ya registrado.'], //Dni debe ser unico
            [['email'], 'email'], //email debe ser de tipo email
            [['pregunta'], 'string', 'max' => 100],
            [['respuesta'], 'string', 'max' => 100],
            [['institucion'], 'string', 'max' => 255],//Institucion debe ser un string de maximo 255 caracteres,

            

            //[['aceptaterminos'], 'compare', 'compareValue' => 1, 'message' => 'Tienes que leer y aceptar nuestra política de datos'],            
            [['preg1', 'preg2', 'preg3', 'preg4', 'preg5', 'preg6', 'preg7', 'preg8', 'preg9', 'preg10',
            'preg11', 'preg12', 'preg13', 'preg14', 'preg15', 'preg16', 'preg17', 'preg18', 'preg19', 'preg20',
            'preg21', 'preg22', 'preg23', 'preg24', 'preg25', 'preg26', 'preg27', 'preg28', 'preg29', 'preg30',
            'preg31', 'preg32', 'preg33', 'preg34', 'preg35', 'preg36', 'preg37', 'preg38', 'preg39', 'preg40',
            'preg41', 'preg42', 'preg43', 'preg44', 'fecha'], 'safe'],
            [['preg1_bf', 'preg2_bf', 'preg3_bf', 'preg4_bf', 'preg5_bf', 'preg6_bf', 'preg7_bf', 'preg8_bf', 'preg9_bf', 'preg10_bf',
            'preg11_bf', 'preg12_bf', 'preg13_bf', 'preg14_bf', 'preg15_bf', 'preg16_bf', 'preg17_bf', 'preg18_bf', 'preg19_bf', 'preg20_bf',
            'preg21_bf', 'preg22_bf', 'preg23_bf', 'preg24_bf', 'preg25_bf', 'preg26_bf', 'preg27_bf', 'preg28_bf', 'preg29_bf', 'preg30_bf',
            'preg31_bf', 'preg32_bf', 'preg33_bf', 'preg34_bf', 'preg35_bf', 'preg36_bf', 'preg37_bf', 'preg38_bf', 'preg39_bf', 'preg40_bf',
            'preg41_bf', 'preg42_bf', 'preg43_bf', 'preg44_bf', 'fecha'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'tipo' => 'Tipo',
            'estiloaprendizaje' => 'Estilo de Aprendizaje',
            'personalidad' => 'Personalidad',
            'fechanacimiento' => 'Fecha de Nacimiento',
            'email' => 'E-mail',
            'pais_idpais' => 'País',
            'dni' => 'DNI/CI',
            'pregunta' =>'Pregunta de seguridad',
            'respuesta' =>'Respuesta a pregunta de seguridad',
            'institucion' => 'Institución Educativa',
            //'aceptaterminos' => 'Acepto que mis datos sean utilizados con fines académicos y de investigación. Se resalta que estos datos personales no serán divulgados.'
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignaturasDocentes() {
        return $this->hasMany(AsignaturasDocentes::className(), ['usuarios_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGruposAlumnos() {
        return $this->hasMany(GruposAlumnos::className(), ['usuarios_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSentencias() {
        return $this->hasMany(Sentencias::className(), ['usuarios_id' => 'id']);
    }

    public function getNombreCompleto() {
        return $this->apellido . ', ' . $this->nombre;
    }

    public static function getListaDocentes() {
        //Se agrega el orderby a la consulta, para ordenar los docentes alfabeticamente ascendente por apellido
        return yii\helpers\ArrayHelper::map(Usuarios::find()->where(['tipo' => 1])->orderBy(['apellido' => SORT_ASC])->all(),'id','nombrecompleto');
    }
    
    public static function getListaAlumnos() {
        return yii\helpers\ArrayHelper::map(Usuarios::find()->where(['tipo' => 0])->orderBy(['apellido'=>SORT_ASC])->all(), 'id', 'nombrecompleto');
    }      

    public static function getNombrePorId($id) {
        $objUsuario = static::findOne(['id' => $id]);
        return $objUsuario->apellido . ', ' . $objUsuario->nombre;
    }

    public function getAuthKey(): string {
        return $this->auth_key;
    }

    public function getId() {
        return $this->id;
    }

    public function validateAuthKey($authKey): bool {
        return $this->getAuthKey() === $authKey;
    }


    public static function findIdentity($id) {
        $objUsuario = new Usuarios();
        return $objUsuario->findOne($id);
    }

    
    public static function findIdentityByAccessToken($token, $type = null): \yii\web\IdentityInterface {
        throw new \yii\base\NotSupportedException("Sólo se permite logueo por"
        . " nombre de usuario y contraseÃ±a");
    }


    public function beforeSave($insert) {
        $return = parent::beforeSave($insert);
        if ($this->isNewRecord) {
            $this->auth_key = Yii::$app->security->generateRandomString(255);
        }
        if ($this->isAttributeChanged("password")) {
            $this->password = Yii::$app->security->
                    generatePasswordHash($this->password);
        }
        if ($this->isAttributeChanged("fechanacimiento")) {
            list($dia, $mes, $year) = explode("/", $this->fechanacimiento);
            $this->fechanacimiento = "$year-$mes-$dia 00:00:00"; 
            
        }
        return $return;
    }

}
