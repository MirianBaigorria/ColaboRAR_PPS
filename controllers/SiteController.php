<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RecuperarPasswordForm;
use app\models\VerificacionPaso1Form;
use app\models\VerificacionPaso2Form;


class SiteController extends Controller {


    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            //access restringe el acceso a la acción logout solo a usuarios autenticados (@).
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            //error configura la acción error para manejar errores y mostrar la página de error correspondiente.
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            //captcha configura la acción captcha para generar imágenes CAPTCHA, útil para formularios de contacto o registro.
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->login()) {
                // Inicio de sesión exitoso, reiniciar el contador
                Yii::$app->session->remove('loginAttempts');
                return $this->goBack();
            } else {
                // Inicio de sesión fallido, inicia el contador
                $attempts = Yii::$app->session->get('loginAttempts', 0);
                $attempts++;
                Yii::$app->session->set('loginAttempts', $attempts);

                if ($attempts >= 3) {
                    //Mostrar el mensaje
                    Yii::$app->session->setFlash('error', 'Demasiados intentos de inicio de sesión fallidos. Por favor, recupere su usuario y/o contraseña.');
                    
                } else {
                    Yii::$app->session->setFlash('error', 'Usuario o contraseña incorrectos. Intentos restantes: ' . (3 - $attempts));
                }
            }
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

  
    public function actionInstalar() {
        $roles = $query = (new \yii\db\Query())
                        ->select(['name', 'type'])
                        ->from('auth_item')->all();

        if (count($roles) == 0) {
            $rbac = Yii::$app->authManager;

            $guest = $rbac->createRole("guest");
            $guest->description = "Usuario invitado";
            $rbac->add($guest);

            $administrador = $rbac->createRole("administrador");
            $administrador->description = "Administrador";
            $rbac->add($administrador);

            $profesor = $rbac->createRole("profesor");
            $profesor->description = "Profesor";
            $rbac->add($profesor);

            $estudiante = $rbac->createRole("estudiante");
            $estudiante->description = "Estudiante";
            $rbac->add($estudiante);

            $rbac->addChild($administrador, $profesor);
            $rbac->addChild($profesor, $estudiante);
            $rbac->addChild($estudiante, $guest);

            $usuario = new \app\models\Usuarios();
            $usuario->nombre = "Administrador";
            $usuario->apellido = "General";
            $usuario->username = "admin";
            $usuario->password = "123456";
            $usuario->tipo = 2;
            $usuario->save();

            $rbac->assign($administrador, $usuario->id);

            $mFormacionGrupos = new \app\models\MetodosFormacion();
            $mFormacionGrupos->descripcion = "Manual";
            $mFormacionGrupos->save();

            $mFormacionGrupos1 = new \app\models\MetodosFormacion();
            $mFormacionGrupos1->descripcion = "Algoritmo Genético";
            $mFormacionGrupos1->save();
        }

        return $this->render('instalar', [
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */



    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
                    'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout() {
        return $this->render('about');
    }


    public function actionRecuperarPassword($username, $dni, $key) {
        //Desencriptamos dni y username
        $dni=Yii::$app->security->decryptByKey($dni, $key);
        $username=Yii::$app->security->decryptByKey($username, $key);

        $model = new RecuperarPasswordForm();
        $mensajeError = "";
        
        if ($model->load(Yii::$app->request->post())) {            //&& $model->aceptaterminos == 1
            // Se debe verificar que exista el nombre de usuario
            // Si existe se actualiza la contraseña
            $objUsuario = \app\models\Usuarios::findOne(['dni' => $dni]);
            if (isset($objUsuario)) {
                $objUsuario->password = $model->password;
                $objUsuario->save();
                return $this->redirect(['restablecimiento-exitoso']);
            } else {
                // Caso contrario se notifica el error.
                $mensajeError = $model->username . " No figura como usuario del sistema.";
            }
        }

        return $this->render('recuperar-password', [
                    'model' => $model,
                    'mensajeError' => $mensajeError,
                    'username'=>$username,
        ]);
        
    }

    public function actionVerificarUno() {
        //Genero una clave para encriptar los datos
        $key = Yii::$app->security->generateRandomKey(32); // Genera una clave de 32 bytes
   
        $model = new VerificacionPaso1Form();
        $mensajeError = "";
        if ($model->load(Yii::$app->request->post())) {
            $objUsuario = \app\models\Usuarios::findOne(['dni' => $model->dni]);
            if ($objUsuario !== null) { // Verifica si $objUsuario no es null
                //Encriptamos dni y pregunta y enviamos el key
                $dni=Yii::$app->security->encryptByKey($objUsuario->dni, $key);
                $pregunta=Yii::$app->security->encryptByKey($objUsuario->pregunta, $key);
                return $this->redirect(['verificar-dos', 'dni' => $dni, 'pregunta' => $pregunta, 'key'=>$key]);
            } else {
                $mensajeError = "No existe ese DNI en el sistema.";
            }
        }
    
        return $this->render('verificar-uno', [
            'model' => $model,
            'mensajeError' => $mensajeError,
        ]);
    }

    public function actionVerificarDos($dni, $pregunta, $key) {
        //desencriptamos dni y respuesta
        $dni=Yii::$app->security->decryptByKey($dni, $key);
        $pregunta=Yii::$app->security->decryptByKey($pregunta, $key);

        $model = new VerificacionPaso2Form();
        $mensajeError = "";
        if ($model->load(Yii::$app->request->post())) {
            $objUsuario = \app\models\Usuarios::findOne(['dni' => $dni]);
            if ($objUsuario !== null) {
                // Comparacion correcta de la respuesta del modelo con la respuesta en la base de datos y que no diferencia mayusculas de minusculas
                if (strcasecmp($model->respuesta, $objUsuario->respuesta) == 0) {
                    //Volvemos a encriptar dni y el username y pasamos el key
                    $dni=Yii::$app->security->encryptByKey($objUsuario->dni, $key);
                    $username=Yii::$app->security->encryptByKey($objUsuario->username, $key);
                    return $this->redirect(['recuperar-password', 'username'=>$username, 'dni'=>$dni, 'key'=>$key]);
                } else {
                    $mensajeError = "Respuesta incorrecta.";
                }
            }
        }
    
        return $this->render('verificar-dos', [
            'model' => $model,
            'mensajeError' => $mensajeError,
            'pregunta' => $pregunta
        ]);
    }

    //Muestra un mensaje de éxito después de restablecer la contraseña (restablecimiento-exitoso).
    public function actionRestablecimientoExitoso() {
        return $this->render('restablecimiento-exitoso');
    }

}
