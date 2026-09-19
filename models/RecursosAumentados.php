<?php

namespace app\models;
use yii\helpers\FileHelper;
use yii\db\Query;

use Yii;

/**
 * This is the model class for table "recursos_aumentados".
 *
 * @property int $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $tipoar
 * @property string $marker
 * @property string $pattern
 * @property string $r_archivo1
 * @property string $r_archivo2
 * @property string $r_musica
 * @property int $id_asignatura
 *
 * @property Asignaturas $asignatura
 */
class RecursosAumentados extends \yii\db\ActiveRecord
{
    public $nomb; //Nombre
    public $desc; //Descripcion
    public $tipoarchivo; //Tipo de archivo
    public $archivo1; //Archivo principal 1: .glb, .gltf, .obj, .jpg, .png y .mp4
    public $archivo2; //Archivo principal 2: .bin y  .mtl
    public $textures; //Texturas de gltf y obj
    public $musica; //Musica de t1: .mp3

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recursos_aumentados';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
        
        // id_asignatura
        //[['id_asignatura'], 'required'],
        //[['id_asignatura'], 'integer'],
        // nomb
        [['nomb'], 'required', 'message' => 'Nombre no puede estar vacío.'],
        [['nomb'], 'string', 'max' => 300],
        // desc
        [['desc'], 'required', 'message' => 'Descripción no puede estar vacío.'],
        [['desc', 'marker', 'pattern', 'r_archivo1', 'r_archivo2', 'r_musica'], 'string', 'max' => 1000],
        // tipoarchivo
        [['tipoarchivo'], 'required', 'message' => 'Por favor, selecciona un tipo de archivo.'],
        [['tipoarchivo'], 'string', 'max' => 4],
        // musica (considerando que es opcional debido a 'skipOnEmpty' => true)
        [['musica'], 'file', 'skipOnEmpty' => true, 'extensions' => 'mp3', 'maxFiles' => 1, 'uploadRequired' => 'Por favor, sube un archivo.'],

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
            'tipoar' => 'Tipo de archivo',
            'marker' => 'Marker',
            'pattern' => 'Pattern',
            'r_archivo1' => 'Ruta de Archivo1',
            'r_archivo2' => 'Ruta de Archivo2',
            'r_musica' => 'Ruta de Musica',
            'id_asignatura' => 'Id Asignatura',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignatura()
    {
        return $this->hasOne(Asignaturas::className(), ['id' => 'id_asignatura']);
    }

    public function upload() {
    $filePaths = [];

    // Obtenemos el último id de la tabla recursos_aumentados en la BD
    $lastInsertedId = (new Query())
        ->from('recursos_aumentados')
        ->max('id');

    // Si no hay un último id insertado, el valor de lastInserted es 1
    if ($lastInsertedId === null) {
        $lastInsertedId = 1;
    } else {
        // Si hay un último id insertado, el valor lastInserted es lastInserted+1.
        // Esto es porque para crear las carpetas de los recursos necesito la numeración previa a guardarlas en la BD
        $lastInsertedId = $lastInsertedId + 1;
    }

    // Se construye la carpeta con el valor de lastInserted para su nombre
    $carpeta = 'recurso' . $lastInsertedId;

    $rutaBase = 'uploads/recursos/' . $carpeta . '/'; // Ruta base dentro de la carpeta web

    // Creamos la carpeta si no existe
    $rutaCompleta = Yii::getAlias('@webroot') . '/' . $rutaBase;

    FileHelper::createDirectory($rutaCompleta);
    if (FileHelper::createDirectory($rutaCompleta)) {

    // Archivo 1
    if ($this->{"archivo1"}) {
        $nombreArchivo = $this->{"archivo1"}->baseName . '.' . $this->{"archivo1"}->extension;
        $rutaRelativa = $rutaBase . $nombreArchivo;
        if ($this->{"archivo1"}->saveAs(Yii::getAlias('@webroot') . '/' . $rutaRelativa)) {
            $filePaths["archivo1"] = $rutaRelativa;
        } else {
            Yii::error("No se pudo guardar el archivo: " . $rutaRelativa);
        }
    }

    // Archivo 2
    if ($this->{"archivo2"}) {
        $nombreArchivo = $this->{"archivo2"}->baseName . '.' . $this->{"archivo2"}->extension;
        $rutaRelativa = $rutaBase . $nombreArchivo;
        if ($this->{"archivo2"}->saveAs(Yii::getAlias('@webroot') . '/' . $rutaRelativa)) {
            $filePaths["archivo2"] = $rutaRelativa;
        } else {
            Yii::error("No se pudo guardar el archivo: " . $rutaRelativa);
        }
    }

    // Archivos de texturas obj (múltiples)
    if ($this->{"tipoarchivo"} == "obj" && $this->{"textures"}) {
        $texturePaths = [];
        foreach ($this->{"textures"} as $file) {
            $nombreArchivo = $file->baseName . '.' . $file->extension;
            $rutaRelativa = $rutaBase . $nombreArchivo;
            if ($file->saveAs(Yii::getAlias('@webroot') . '/' . $rutaRelativa)) {
                $texturePaths[] = $rutaRelativa;
            } else {
                Yii::error("No se pudo guardar el archivo: " . $rutaRelativa);
            }
        }
        $filePaths["textures"] = $texturePaths;
    }



    // Archivos de texturas gltf (múltiples) 
    if ($this->{"tipoarchivo"} == "gltf" && $this->{"textures"}) {
        $texturePaths = [];
        $rutaTextures = $rutaBase . 'textures/';

        FileHelper::createDirectory($rutaTextures);
        if (FileHelper::createDirectory($rutaTextures)) {
        foreach ($this->{"textures"} as $file) {
            $nombreArchivo = $file->baseName . '.' . $file->extension;
            $rutaRelativa = $rutaTextures . $nombreArchivo;
            if ($file->saveAs(Yii::getAlias('@webroot') . '/' . $rutaRelativa)) {
                $texturePaths[] = $rutaRelativa;
            } else {
                Yii::error("No se pudo guardar el archivo: " . $rutaRelativa);
            }
        }
        $filePaths["textures"] = $texturePaths;
        }else{
            Yii::error("No se pudo crear la carpeta: $rutaTextures");
        }
    }

    // Archivo de música
    if ($this->{"musica"}) {
        $nombreArchivo = $this->{"musica"}->baseName . '.' . $this->{"musica"}->extension;
        $rutaRelativa = $rutaBase . $nombreArchivo;
        if ($this->{"musica"}->saveAs(Yii::getAlias('@webroot') . '/' . $rutaRelativa)) {
            $filePaths["musica"] = $rutaRelativa;
        } else {
            Yii::error("No se pudo guardar el archivo: " . $rutaRelativa);
        }
    }
}else{
    Yii::error("No se pudo crear la carpeta: $rutaCompleta");
}
    return $filePaths;
}


   public static function getListaRecursos($idAsignatura) {
    return yii\helpers\ArrayHelper::map(
        RecursosAumentados::find()
            ->where(['id_asignatura' => $idAsignatura]) // Agregamos la condición where para filtrar por idasignatura
            ->all(),
        'id',
        'nombre'
    );
}



}
