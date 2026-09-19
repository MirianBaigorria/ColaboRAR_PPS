<?php

namespace app\controllers;

use Yii;
use app\models\Usuarios;
use app\models\UsuariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UsuariosController implements the CRUD actions for Usuarios model.
 */
class UsuariosController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'update', 'delete', 'create', 'test-felder-silverman'],
                'rules' => [ 
                    [
                        'actions' => ['index', 'view', 'actualizar-perfil', 'test-felder-silverman'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['administrador', 'profesor'],
                    ],
                    [
                        'actions' => ['create', 'update'],
                        'allow' => true,
                        'roles' => ['?', 'administrador', 'profesor'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Usuarios models.
     * @return mixed
     */
    public function actionIndex($t) {
        // Se controla si el usuario alumno intenta ingresar a esta acción
        if (isset(Yii::$app->user->identity->id)) {
            $rolesUsuario = Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id);
        } else {
            $rolesUsuario = [];
        }

        if (array_key_exists('estudiante', $rolesUsuario) && !array_key_exists('profesor', $rolesUsuario)) {
            return $this->redirect(['site/index']);
        }

        $searchModel = new UsuariosSearch();
        if ($t == 'a') {
            $searchModel->tipo = 0;
        } elseif ($t == 'd') {
            $searchModel->tipo = 1;
        } elseif ($t == 'm') {
            $searchModel->tipo = 2;
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'tipo' => $t,
        ]);
    }

    /**
     * Displays a single Usuarios model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }


    public function actionFicha($id) {
        $usuario = Yii::$app->user->identity->id;
        $oUser = \app\models\Usuarios::findOne(['id' => $usuario]);
        $idUsuario = Yii::$app->security->decryptByPassword($id, $oUser->password);

        return $this->render('ficha', [
                    'model' => $this->findModel($idUsuario),
        ]);
    }

    /**
     * Creates a new Usuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($t) {
        $model = new Usuarios();
        if ($t == 'a') {
            $model->tipo = 0;
        } elseif ($t == 'd') {
            $model->tipo = 1;
        } else {
            $model->tipo = 2;
        }
    
        if ($model->load(Yii::$app->request->post())) {
            // Subida de la imagen de perfil
            $file = \yii\web\UploadedFile::getInstance($model, 'foto_perfil');
            if ($file) {
                $filePath = 'uploads/' . $file->baseName . '.' . $file->extension;
                if ($file->saveAs($filePath)) {
                    $model->foto_perfil = $filePath; // Guardar la ruta del archivo en la BD
                }
            }
    
            if ($model->save()) {
                // Asignación de roles
                $rbac = Yii::$app->authManager;
                if ($t == 'a') {
                    $estudiante = $rbac->getRole('estudiante');
                    $rbac->assign($estudiante, $model->id);
                } elseif ($t == 'd') {
                    $profesor = $rbac->getRole('profesor');
                    $rbac->assign($profesor, $model->id);
                } else {
                    $administrador = $rbac->getRole('administrador');
                    $rbac->assign($administrador, $model->id);
                }
    
                if (!isset(Yii::$app->user->identity->id)) {
                    return $this->redirect(['alta-exitosa']);
                } else {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }
    
        return $this->render('create', [
            'model' => $model,
            'tipo' => $t,
        ]);
    }
    

    public function actionPromoverDocente($id) {
        $usuario = Yii::$app->user->identity->id;
        $oUser = \app\models\Usuarios::findOne(['id' => $usuario]);
        $idUsuario = Yii::$app->security->decryptByPassword($id, $oUser->password);

        $rbac = Yii::$app->authManager;
        $profesor = $rbac->getRole('profesor');
        $rbac->assign($profesor, $idUsuario);
        $usuarioActualizar = \app\models\Usuarios::findOne(['id' => $idUsuario]);
        $usuarioActualizar->tipo = 1;
        $usuarioActualizar->save();
        return $this->render('promover-docente');
    }




    public function actionAltaExitosa() {
        return $this->render('alta-exitosa');
    }

    /**
     * Updates an existing Usuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
    
        if ($model->load(Yii::$app->request->post())) {
            // Subida de la imagen de perfil
            $file = \yii\web\UploadedFile::getInstance($model, 'foto_perfil');
            if ($file) {
                $filePath = 'uploads/' . $file->baseName . '.' . $file->extension;
                if ($file->saveAs($filePath)) {
                    $model->foto_perfil = $filePath; // Guardar la ruta del archivo en la BD
                }
            }
    
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
    
        return $this->render('update', [
            'model' => $model,
        ]);
    }


    public function actionActualizarPerfil($id) {
        // Obtener el usuario actual logueado
        $usuario = Yii::$app->user->identity->id;
        $oUser = \app\models\Usuarios::findOne(['id' => $usuario]);
        $idUsuario = Yii::$app->security->decryptByPassword($id, $oUser->password);
    
        // Buscar el modelo del usuario a actualizar
        $model = $this->findModel($idUsuario);
    
        // Guardar la imagen antigua antes de cargar nuevos datos
        $oldFotoPerfil = $model->foto_perfil;
    
        // Cargar los datos del formulario, incluido el archivo de imagen
        if ($model->load(Yii::$app->request->post())) {
            // Obtener la imagen de perfil desde el formulario
            $file = \yii\web\UploadedFile::getInstance($model, 'foto_perfil');
    
            // Si hay una nueva imagen, guardarla
            if ($file) {
                // Definir la ruta de la imagen en @webroot (directorio raíz del servidor)
                $filePath = Yii::getAlias('@webroot') . '/uploads/' . $file->baseName . '.' . $file->extension;
                $webFilePath = 'uploads/' . $file->baseName . '.' . $file->extension;
    
                if ($file->saveAs($filePath)) {
                    // Llamada a la acción para verificar perfil completado
                    Yii::$app->runAction('desafios/verificar-completar-perfil', ['usuario_id' => $idUsuario]);
    
                    // Guardar la nueva ruta web de la imagen en la base de datos
                    $model->foto_perfil = $webFilePath;
                } else {
                    Yii::$app->session->setFlash('error', 'No se pudo guardar la imagen.');
                }
            } else {
                // Si no se ha subido una nueva imagen, mantener la imagen anterior
                $model->foto_perfil = $oldFotoPerfil;
            }
    
            // Intentar guardar el modelo
            if ($model->save()) {
                Yii::$app->runAction('desafios/verificar-completar-perfil', ['usuario_id' => $idUsuario]);
                Yii::$app->session->setFlash('success', 'Perfil actualizado correctamente.');
                return $this->redirect(['ficha', 'id' => Yii::$app->security->encryptByPassword($model->id, $oUser->password)]);
            } else {
                // Recopilar los errores del modelo y mostrar en el mensaje flash
                $errors = $model->errors;
                $errorMessage = '';
                foreach ($errors as $field => $messages) {
                    $errorMessage .= "$field: " . implode(', ', $messages) . "<br>";
                }
    
                // Mostrar los errores en un mensaje flash
                Yii::$app->session->setFlash('error', 'No se pudo actualizar el perfil. Errores: <br>' . $errorMessage);
            }
        }
    
        // Renderizar la vista si no se han enviado datos por POST
        return $this->render('actualizar-perfil', [
            'model' => $model,
        ]);
    }
    
    

    /**
     * Deletes an existing Usuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $t) {
        $this->findModel($id)->delete();

        return $this->redirect(['index', 't'=>$t]);
    }


    public function actionTestFelderSilverman() {

        $model = $this->findModel(Yii::$app->user->identity->id);

        if ($model->load(Yii::$app->request->post())) {
            $activo = 0;
            $reflexivo = 0;
            $sensitivo = 0;
            $intuitivo = 0;
            $visual = 0;
            $verbal = 0;
            $secuencial = 0;
            $global = 0;
            $b = true;
            $estiloAprendizaje = '';

            for ($i = 1; $i <= 44; $i++) {
                $respuesta = "preg" . $i;
                if (isset($model->$respuesta)) {
                    switch ($i) {
                        case 1:
                        case 5:
                        case 9:
                        case 13:
                        case 17:
                        case 21:
                        case 25:
                        case 29:
                        case 33:
                        case 37:
                        case 41:
                            if ($model->$respuesta == 'a') {
                                $activo += 1;
                            } else {
                                $reflexivo += 1;
                            }
                            break;
                        case 2:
                        case 6:
                        case 10:
                        case 14:
                        case 18:
                        case 22:
                        case 26:
                        case 30:
                        case 34:
                        case 38:
                        case 42:
                            if ($model->$respuesta == 'a') {
                                $sensitivo += 1;
                            } else {
                                $intuitivo += 1;
                            }
                            break;
                        case 3:
                        case 7:
                        case 11:
                        case 15:
                        case 19:
                        case 23:
                        case 27:
                        case 31:
                        case 35:
                        case 39:
                        case 43:
                            if ($model->$respuesta == 'a') {
                                $visual += 1;
                            } else {
                                $verbal += 1;
                            }
                            break;
                        case 4:
                        case 8:
                        case 12:
                        case 16:
                        case 20:
                        case 24:
                        case 28:
                        case 32:
                        case 36:
                        case 40:
                        case 44:
                            if ($model->$respuesta == 'a') {
                                $secuencial += 1;
                            } else {
                                $global += 1;
                            }
                            break;
                    }
                } else {
                    $b = false;
                    break;
                }
            }

            if ($b) {
                if ($activo > $reflexivo) {
                    $estiloAprendizaje = "ACT" . $activo . " - ";
                } elseif ($activo < $reflexivo) {
                    $estiloAprendizaje = "REF" . $reflexivo . " - ";
                } else {
                    $estiloAprendizaje = "NAR" . " - ";
                }

                if ($sensitivo > $intuitivo) {
                    $estiloAprendizaje .= "SEN" . $sensitivo . " - ";
                } elseif ($sensitivo < $intuitivo) {
                    $estiloAprendizaje .= "INT" . $intuitivo . " - ";
                } else {
                    $estiloAprendizaje .= "NSI" . " - ";
                }

                if ($visual > $verbal) {
                    $estiloAprendizaje .= "VIS" . $visual . " - ";
                } elseif ($visual < $verbal) {
                    $estiloAprendizaje .= "VER" . $verbal . " - ";
                } else {
                    $estiloAprendizaje .= "NVV" . " - ";
                }

                if ($secuencial > $global) {
                    $estiloAprendizaje .= "SEC" . $secuencial;
                } elseif ($secuencial < $global) {
                    $estiloAprendizaje .= "GLO" . $global;
                } else {
                    $estiloAprendizaje .= "NSG";
                }

                $model->estiloaprendizaje = $estiloAprendizaje;

                if ($model->save()) {
                    Yii::$app->runAction('desafios/verificar-primer-test-aprendizaje', ['usuario_id' => $model->id]);
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    echo strlen($model->estiloaprendizaje);
                    var_dump($model->errors);
                    echo "estamos en problema...";
                }
            } else {
                echo "Hay preguntas a las que no respondio. No se puede determinar el estilo de aprendizaje.";
            }
        } else {

            return $this->render('test-felder-silverman', [
                        'model' => $model,
            ]);
        }
    }


    public function actionTestBigFive() {

        $model = $this->findModel(Yii::$app->user->identity->id);

        if ($model->load(Yii::$app->request->post())) {
            $b = true;
            for ($i = 1; $i <= 44; $i++) {
                $respuesta = "preg" . $i . '_bf';
                if (!isset($model->$respuesta)) {
                    $b = false;
                    break;
                }
            }

            if ($b) {
                $rv6 = 6 - (int) $model->preg6_bf;
                $rv27 = 6 - (int) $model->preg27_bf;
                $rv16 = 6 - (int) $model->preg16_bf;
                $rv2 = 6 - (int) $model->preg2_bf;
                $rv13 = 6 - (int) $model->preg13_bf;
                $rv33 = 6 - (int) $model->preg33_bf;
                $rv22 = 6 - (int) $model->preg22_bf;
                $rv42 = 6 - (int) $model->preg42_bf;
                $rv8 = 6 - (int) $model->preg8_bf;
                $rv25 = 6 - (int) $model->preg25_bf;
                $rv18 = 6 - (int) $model->preg18_bf;
                $rv35 = 6 - (int) $model->preg35_bf;
                $rv19 = 6 - (int) $model->preg19_bf;
                $rv9 = 6 - (int) $model->preg9_bf;
                $rv44 = 6 - (int) $model->preg44_bf;
                $rv12 = 6 - (int) $model->preg12_bf;

                $extra = ((int) $model->preg43_bf + (int) $model->preg1_bf + (int) $model->preg40_bf + (int) $model->preg32_bf + (int) $model->preg11_bf + $rv6 + $rv27 + $rv16) / 8;
                $agrea = ((int) $model->preg37_bf + (int) $model->preg41_bf + (int) $model->preg7_bf + (int) $model->preg28_bf + (int) $model->preg24_bf + $rv2 + $rv13 + $rv33 + $rv22) / 9;
                $consc = ((int) $model->preg3_bf + (int) $model->preg29_bf + (int) $model->preg34_bf + (int) $model->preg14_bf + (int) $model->preg21_bf + $rv42 + $rv8 + $rv25 + $rv18) / 9;
                $neuro = ((int) $model->preg26_bf + (int) $model->preg15_bf + (int) $model->preg38_bf + (int) $model->preg30_bf + (int) $model->preg4_bf + $rv35 + $rv19 + $rv9) / 8;
                $openn = ((int) $model->preg5_bf + (int) $model->preg23_bf + (int) $model->preg20_bf + (int) $model->preg36_bf + (int) $model->preg17_bf + (int) $model->preg31_bf + (int) $model->preg10_bf + (int) $model->preg39_bf + $rv44 + $rv12) / 10;


                $model->personalidad = 'extra:' . number_format($extra, 2) . ',agrea:' . number_format($agrea, 2) . ',consc:' . number_format($consc, 2) . ',neuro:' . number_format($neuro, 2) . ',openn:' . number_format($openn, 2);

                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    echo strlen($model->personalidad);
                    var_dump($model->errors);
                    echo "estamos en problema...";
                }
            } else {
                echo "Hay preguntas a las que no respondio. No se puede determinar su personalidad.";
            }
        } else {
            return $this->render('test-big-five', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Finds the Usuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
