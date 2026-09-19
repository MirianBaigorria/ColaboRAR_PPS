<?php
$sentenciasApertura = array();
foreach($sentencias as $id => $sentencia){
    $sentenciasApertura[] = array('id' => $id, 'sentencia' => $sentencia);
}

echo json_encode($sentenciasApertura);