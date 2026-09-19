<?php
$aAlumnos = array();
foreach($alumnos as $id => $alumno){
    $aAlumnos[] = array('id' => $id, 'alumno' => $alumno);
}

echo json_encode($aAlumnos);

