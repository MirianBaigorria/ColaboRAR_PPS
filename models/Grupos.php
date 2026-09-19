<?php

namespace app\models;

define("_TAMPOB_", 5);

use Yii;

/**
 * This is the model class for table "grupos".
 * @property int $id
 * @property string $codigo
 * @property int $year
 * @property int $cantidadintegrantes
 * @property int $asignaturas_id
 * @property int $metodos_formacion_id
 * @property Chats[] $chats
 * @property Asignaturas $asignaturas
 * @property MetodosFormacion $metodosFormacion
 * @property GruposAlumnos[] $gruposAlumnos
 */
class Grupos extends \yii\db\ActiveRecord {

    public $alumnosPorGrupo;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'grupos';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['alumnosPorGrupo'], 'safe'], 
            [['asignaturas_id', 'metodos_formacion_id', 'codigo', 'cantidadintegrantes'], 'required'], 
            ['codigo', 'unique', 'targetClass' => '\app\models\Grupos', 'message' => 'Este codigo de grupo, ya existe.'], 
            [['asignaturas_id', 'metodos_formacion_id', 'cantidadintegrantes'], 'integer'],
            [['year'], 'string', 'max' => 4], 
            [['cantidadintegrantes'], 'number', 'min' => 2, 'message' => 'La cantidad de integrantes no debe ser menor a 2'], //Agregado
            [['asignaturas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Asignaturas::className(), 'targetAttribute' => ['asignaturas_id' => 'id']],
            [['metodos_formacion_id'], 'exist', 'skipOnError' => true, 'targetClass' => MetodosFormacion::className(), 'targetAttribute' => ['metodos_formacion_id' => 'id']],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'year' => 'Año',
            'codigo' => ' Codigo de grupo (Tener en cuenta para asociar actividades)',
            'cantidadintegrantes' => 'Cantidad de Integrantes',
            'asignaturas_id' => 'Asignaturas ID',
            'metodos_formacion_id' => 'Método de Formación',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */

    public function getChats() {
        return $this->hasMany(Chats::className(), ['grupos_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getAsignaturas() {
        return $this->hasOne(Asignaturas::className(), ['id' => 'asignaturas_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMetodosFormacion() {
        return $this->hasOne(MetodosFormacion::className(), ['id' => 'metodos_formacion_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGruposAlumnos() {
        return $this->hasMany(GruposAlumnos::className(), ['grupos_id' => 'id']);
    }




    private static function cmp($a, $b) {
        if ($a["fitness"] == $b["fitness"]) {
            return 0;
        }
        return ($a["fitness"] < $b["fitness"]) ? 1 : -1;
    }


    function random() {
        return mt_rand() / mt_getrandmax();
    }

    function contabilizarProporciones($grupo, $alumnos) {
        $cantidadMiembros = count($grupo);
        $item = array(
            "intuitivo" => 0,
            "sensitivo" => 0,
            "neutral-is" => 0,
            "reflexivo" => 0,
            "activo" => 0,
            "neutral-ar" => 0,
            "global" => 0,
            "secuencial" => 0,
            "neutral-sg" => 0,
            "visual" => 0,
            "verbal" => 0,
            "neutral-vv" => 0
        );
    
        foreach ($grupo as $miembro) {
            // Se extrae los parentesis que abren y cierran
            $estilos = explode(",", $alumnos[$miembro]["ea"]);
            while (count($estilos) < 4) {
                $estilos[] = 'neutral-sg'; // valor predeterminado
            }
            list($ar, $is, $vv, $sg) = $estilos;
    
            // Verificar si los estilos existen en el array antes de incrementarlos
            if (isset($item[$ar])) $item[$ar] += 1;
            if (isset($item[$is])) $item[$is] += 1;
            if (isset($item[$vv])) $item[$vv] += 1;
            if (isset($item[$sg])) $item[$sg] += 1;
        }
    
        // Calculo las proporciones
        $item["intuitivo"] /= $cantidadMiembros;
        $item["sensitivo"] /= $cantidadMiembros;
        $item["neutral-is"] /= $cantidadMiembros;
        $item["reflexivo"] /= $cantidadMiembros;
        $item["activo"] /= $cantidadMiembros;
        $item["neutral-ar"] /= $cantidadMiembros;
        $item["global"] /= $cantidadMiembros;
        $item["secuencial"] /= $cantidadMiembros;
        $item["neutral-sg"] /= $cantidadMiembros;
        $item["visual"] /= $cantidadMiembros;
        $item["verbal"] /= $cantidadMiembros;
        $item["neutral-vv"] /= $cantidadMiembros;
    
        $item["intuitivo"] = $this->DevolverClase($item["intuitivo"]);
        $item["sensitivo"] = $this->DevolverClase($item["sensitivo"]);
        $item["neutral-is"] = $this->DevolverClase($item["neutral-is"]);
        $item["reflexivo"] = $this->DevolverClase($item["reflexivo"]);
        $item["activo"] = $this->DevolverClase($item["activo"]);
        $item["neutral-ar"] = $this->DevolverClase($item["neutral-ar"]);
        $item["global"] = $this->DevolverClase($item["global"]);
        $item["secuencial"] = $this->DevolverClase($item["secuencial"]);
        $item["neutral-sg"] = $this->DevolverClase($item["neutral-sg"]);
        $item["visual"] = $this->DevolverClase($item["visual"]);
        $item["verbal"] = $this->DevolverClase($item["verbal"]);
        $item["neutral-vv"] = $this->DevolverClase($item["neutral-vv"]);
    
        return $item;
    }
    

    function DevolverClase($porcentaje) {
        if (($porcentaje >= 0) && ($porcentaje <= 0.445)) {
            return "pocos";
        } else if (($porcentaje > 0.455) && ($porcentaje <= 0.66)) {
            return "regular";
        } else {
            return "muchos";
        }
    }

    function predecirRendimiento($grupo, $alumnos) {
        $estilos = $this->contabilizarProporciones($grupo, $alumnos);
        $rendimiento = ["bueno", "malo"];
        return $rendimiento[rand(0, 1)];
    }

    function determinarFitness($propuesta, $alumnos) {
        $cantidadPositivos = 0;
        foreach ($propuesta as $grupo) {
            $rendimiento = $this->predecirRendimiento($grupo, $alumnos);
            if ($rendimiento == "bueno") {
                $cantidadPositivos += 1;
            }
        }
    
        $totalGrupos = count($propuesta);
        if ($totalGrupos === 0) {
            return 0; // O cualquier valor que tenga sentido en tu lógica
        }
    
        return $cantidadPositivos / $totalGrupos;
    }

    function formarGruposAzar($alumnos, $cantidadIntegrantes, $cantidadAlternativas) {
        $poblacion = [];
        $totalAlumnos = count($alumnos);
    
        if ($cantidadIntegrantes == 0 || $totalAlumnos == 0) {
            // Evitar división por cero y agregar manejo de errores
            return $poblacion;
        }
    
        for ($k = 1; $k <= $cantidadAlternativas; $k++) {
            $alumnosSeleccionados = [];
            $grupos = [];
    
            for ($i = 0; $i <= floor($totalAlumnos / $cantidadIntegrantes) - 1; $i++) {
                for ($j = 1; ($j <= $cantidadIntegrantes) && (count($alumnosSeleccionados) != $totalAlumnos); $j++) {
                    do {
                        $miembro = rand(0, $totalAlumnos - 1);
                    } while (in_array($miembro, $alumnosSeleccionados));
                    $alumnosSeleccionados[] = $miembro;
                    $grupos[$i][] = $miembro;
                }
            }
    
            if (empty($grupos)) {
                // Evitar la adición de una propuesta vacía
                continue;
            }
    
            $poblacion[] = ["grupos" => $grupos, "fitness" => $this->determinarFitness($grupos, $alumnos)];
        }
    
        return $poblacion;
    }
    

    function controlarRepetidos($gruposFormados, $funcion) {
        $miembrosEnGrupos = array();
        foreach ($gruposFormados as $indice => $grupo) {
            foreach ($grupo as $miembro) {
                if (in_array($miembro, $miembrosEnGrupos)) {
                    echo "Miembro repetido en otro grupo. Error ocasionado en la función: $funcion<br/>";
                    die();
                } else {
                    $miembrosEnGrupos[] = $miembro;
                }
            }
        }
    }

    function imprimirGrupo($grupos, $alumnos) {
        foreach ($grupos["grupos"] as $grupo) {
            foreach ($grupo as $miembro) {
                echo $alumnos[$miembro]["nombre"] . "<br/>";
            }
            echo "<br/>";
        }

        echo "Fitness: " . $grupos["fitness"];
    }

    function elegirPadreTorneo($poblacion, $k) {
        $seleccionados = [];
        $elegido = NULL;
        $mayor = -PHP_INT_MAX;
        for ($i = 1; $i <= $k; $i++) {
            do {
                $candidato = rand(0, _TAMPOB_ - 1);
            } while (in_array($candidato, $seleccionados));

            $seleccionados[] = $candidato;
            if ($poblacion[$candidato]["fitness"] > $mayor) {
                $mayor = $poblacion[$candidato]["fitness"];
                $elegido = $poblacion[$candidato];
            }
        }

        return $elegido;
    }

    function obtenerParametroC($maxRango) {
        $acumulado = 0;
        for ($i = 1; $i <= $maxRango; $i++) {
            $acumulado += (1 - exp(-$i));
        }
        return $acumulado;
    }

    function acumuladoExponencial($i, $c) {
        $acumulado = 0;
        for ($j = 0; $j <= $i; $j++) {
            $acumulado += ((1 - exp(-$j)) / $c);
        }
        return $acumulado;
    }

    function elegirPadrePorRanking($poblacion, $c) {

        $b = false;
        $i = 1;
        $n = $this->random();
        while (!$b) {
            if (($n > $this->acumuladoExponencial($i - 1, $c)) && ($n <= $this->acumuladoExponencial($i, $c))) {
                $b = true;
            } else {
                $i += 1;
            }
        }

        return $poblacion[$i - 1];
    }

    function generarMatingPool($poblacion) {
        // Ordenar la población en caso de elegir padres por rating
        usort($poblacion, array($this, "cmp"));
        // Obtener parámetro c
        $c = $this->obtenerParametroC(count($poblacion));

        $matingPool = [];
        for ($i = 1; $i <= _TAMPOB_; $i++) {
            //$matingPool[] = elegirPadreTorneo($poblacion, 5);

            $matingPool[] = $this->elegirPadrePorRanking($poblacion, $c);
        }
        return $matingPool;
    }

    function realizarCruzamiento($padre1, $padre2, $cantidadIntegrantes) {
        $v1 = [];
        $v2 = [];
        foreach($padre1 as $i => $grupos){
            foreach ($grupos as $j => $miembro){
                $v1[] = $miembro;
            }
        }
        foreach($padre2 as $i => $grupos){
            foreach ($grupos as $j => $miembro){
                $v2[] = $miembro;
            }
        }

        //var_dump($v1);
        //echo "<br/>";
        //var_dump($v2);
        //echo "<br/><br/>";
        //var_dump($padre2);
        //$this->controlarRepetidos($padre1, "realizarCruzamiento - Padre 1");
        //$this->controlarRepetidos($padre2, "realizarCruzamiento - Padre 2");

        if ($this->random() < 0.5) {
            $puntoCruce = rand(0, min(count($v1), count($v2)) - 1);
            //echo "Punto de cruce : $puntoCruce <br/>";
            $hijo1 = [];
            $hijo2 = [];
            
            $h1 = [];
            $h2 = [];

            for ($i = 0; $i <= $puntoCruce; $i++) {
                $h1[] = $v1[$i];
                $h2[] = $v2[$i];
            }

            for ($i = $puntoCruce + 1; $i < count($v2); $i++) {
                if (!in_array($v2[$i], $h1)){
                    $h1[] = $v2[$i];
                }                    
            }
            
            // Deja los elementos del padre que no existen en el hijo
            for ($i = $puntoCruce + 1; $i < count($v1); $i++) {
                if (!in_array($v1[$i], $h1)){
                    $h1[] = $v1[$i];
                }                    
            }

            for ($i = $puntoCruce + 1; $i < count($v1); $i++) {
                if (!in_array($v1[$i], $h2)){
                    $h2[] = $v1[$i];
                }                    
            }
            
            // Deja los elementos del padre que no existen en el hijo
            for ($i = $puntoCruce + 1; $i < count($v2); $i++) {
                if (!in_array($v2[$i], $h2)){
                    $h2[] = $v2[$i];
                }                    
            }

            // 
            //var_dump($h1);
            //echo "<br/><br/>";
            $k = 0;
            for ($i = 0; $i <= floor(count($h1) / $cantidadIntegrantes) - 1; $i++) {
                for ($j = 1; $j <= $cantidadIntegrantes; $j++) {                    
                    $hijo1[$i][] = $h1[$k];
                    $hijo2[$i][] = $h2[$k];
                    $k = $k + 1;
                }
            }
        } else {
            $hijo1 = $padre1;
            $hijo2 = $padre2;
        }

        //var_dump($hijo1); echo "<br/><br/>";
        
        $this->controlarRepetidos($hijo1, "realizarCruzamiento - Hijo 1");
        $this->controlarRepetidos($hijo2, "realizarCruzamiento - Hijo 2");
        //die();
        return [$hijo1, $hijo2];
    }

    function realizarCruzamientoUniforme($padre1, $padre2) {
        if ($this->random() < 0.5) {
            $i = 0;
            $hijo1 = [];
            $hijo2 = [];
            while (($i < count($padre1)) && ($i < count($padre2))) {
                if ($this->random() < 0.5) {
                    $hijo1[] = $padre1[$i];
                    $hijo2[] = $padre2[$i];
                } else {
                    $hijo1[] = $padre2[$i];
                    $hijo2[] = $padre1[$i];
                }
                $i = $i + 1;
            }

            for ($j = $i; $j < count($padre1); $j++) {
                $hijo1[] = $padre1[$i];
            }

            for ($j = $i; $j < count($padre2); $j++) {
                $hijo2[] = $padre2[$i];
            }
        } else {
            $hijo1 = $padre1;
            $hijo2 = $padre2;
        }

        $this->controlarRepetidos($hijo1, "realizarCruzamientoUniforme - Hijo 1");
        $this->controlarRepetidos($hijo2, "realizarCruzamientoUniforme - Hijo 2");

        return [$hijo1, $hijo2];
    }

    function realizarMutacion($hijo) {
        //echo "<br/>";
        //var_dump($hijo);
        if ($this->random() < 0.03) {
            //Elije al azar dos grupos
            $grupo1 = rand(0, count($hijo) - 1);
            $grupo2 = rand(0, count($hijo) - 1);

            //echo "Grupo 1: $grupo1 , Grupo 2: $grupo2 <br/>";
            //Elije los miembros a intercambiar
            $miembro1 = rand(0, count($hijo[$grupo1]) - 1);
            $miembro2 = rand(0, count($hijo[$grupo2]) - 1);

            //echo "Miembro 1: $miembro1 , Miembro 2: $miembro2 <br/>";

            $aux = $hijo[$grupo1][$miembro1];
            $hijo[$grupo1][$miembro1] = $hijo[$grupo2][$miembro2];
            $hijo[$grupo2][$miembro2] = $aux;
        }

        //var_dump($hijo);
        //echo "<hr/>";

        return $hijo;
    }

    function realizarMutacionMezcla($hijo, $cantidadIntegrantes) {
        //var_dump($hijo); die();
        if ($this->random() < 0.03) {
            // Selecciona los grupos al azar
            $gruposSeleccionados = [];
            while (count($gruposSeleccionados) < count($hijo) - 2) {
                do {
                    $seleccionado = rand(0, count($hijo) - 1);
                } while (in_array($seleccionado, $gruposSeleccionados));
                $gruposSeleccionados[] = $seleccionado;
            }

            // Selecciona los miembros al azar
            $miembrosSeleccionados = [];
            foreach ($gruposSeleccionados as $nroGrupo) {
                $miembros = [];
                while (count($miembros) < count($hijo[$nroGrupo]) - 2) {
                    do {
                        $seleccionado = rand(0, count($hijo[$nroGrupo]) - 1);
                    } while (in_array($seleccionado, $miembros));
                    $miembros[] = $seleccionado;
                }
                $miembrosSeleccionados[$nroGrupo] = $miembros;
            }

            // Copia los integrantes no seleccionados de los grupos elegidos
            $grupos = [];
            foreach ($gruposSeleccionados as $nroGrupo) {
                foreach ($hijo[$nroGrupo] as $posicion => $integrante) {
                    if (!in_array($posicion, $miembrosSeleccionados[$nroGrupo])) {
                        $grupos[$nroGrupo][] = $integrante;
                    }
                }
            }

            // Mezcla los miembros seleccionados
            foreach ($miembrosSeleccionados as $nroGrupo => $miembros) {
                foreach ($miembros as $posMiembro) {
                    do {
                        $grupoRecibeIntegrante = rand(0, count($gruposSeleccionados) - 1);
                    } while (!(count($grupos[$gruposSeleccionados[$grupoRecibeIntegrante]]) < $cantidadIntegrantes)); // Hace mientras el grupo no tenga el total de integrantes requeridos
                    $grupos[$gruposSeleccionados[$grupoRecibeIntegrante]][] = $hijo[$nroGrupo][$posMiembro];
                }
            }

            // Reemplaza los genes alterados
            foreach ($grupos as $nroGrupo => $integrantes) {
                $hijo[$nroGrupo] = $integrantes;
            }
        }

        return $hijo;
    }

    function reemplazoGeneracional(&$poblacion, $offspiring) {
        $poblacion = null;
        usort($offspiring, "cmp");
        for ($i = 0; $i < _TAMPOB_; $i++) {
            $poblacion[$i] = $offspiring[$i];
        }
    }

    function reemplazoElitismo(&$poblacion, $offspiring) {
        usort($poblacion, array($this, "cmp"));
        usort($offspiring, array($this, "cmp"));
        for ($i = 1; $i < _TAMPOB_; $i++) {
            $poblacion[$i] = $offspiring[$i - 1];
        }
    }

    public function optimizarAG($alumnos, $cantidadMiembros) {
        $poblacion = $this->formarGruposAzar($alumnos, $cantidadMiembros, _TAMPOB_);
        if (empty($poblacion)) {
            // Manejar el caso en que no se pudo formar una población
            return null;
        }
    
        usort($poblacion, array($this, "cmp"));
        $fitnessPrevio = 0;
    
        $iteraciones = 1;
        while ($iteraciones <= 70) {
            $fitnessPrevio = $poblacion[0]["fitness"];
    
            // Despues probar sin reposicion a la elección de padres
            $offspiring = [];
            $matingPool = $this->generarMatingPool($poblacion);
            for ($i = 0; $i < count($matingPool) - 1; $i++) {
                $hijos = $this->realizarCruzamiento($matingPool[$i]["grupos"], $matingPool[$i + 1]["grupos"], $cantidadMiembros);
                $hijos[0] = $this->realizarMutacion($hijos[0]);
                $hijos[1] = $this->realizarMutacion($hijos[1]);
                $offspiring[] = $hijos[0];
                $offspiring[] = $hijos[1];
            }
    
            $aux = [];
            foreach ($offspiring as $grupos) {
                $aux[] = ["grupos" => $grupos, "fitness" => $this->determinarFitness($grupos, $alumnos)];
            }
    
            // Reemplazo generacional
            $this->reemplazoElitismo($poblacion, $aux);
    
            $iteraciones += 1;
        }
    
        $mayorFitness = -1;
        $indiceMayor = -1;
        foreach ($poblacion as $indice => $grupos) {
            if ($grupos["fitness"] > $mayorFitness) {
                $mayorFitness = $grupos["fitness"];
                $indiceMayor = $indice;
            }
        }
    
        return $poblacion[$indiceMayor];
    }
    
   
   public static function getListaGrupos($idAsignatura) {
    return yii\helpers\ArrayHelper::map(
        Grupos::find()
            ->where(['asignaturas_id' => $idAsignatura]) // Agregamos la condición where para filtrar por idasignatura
            ->orderBy(['codigo' => SORT_ASC])
            ->all(),
        'id',
        'codigo'
    );
}
    

}
