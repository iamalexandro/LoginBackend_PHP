<?php

require("BD.php");
require("Helpers.php");

$conexion = mysqli_connect($host,$username,$password,$db_name);
mysqli_set_charset($conexion,"utf8");

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->titulo) && ($data->fecestimada) && ($data->fecentrega) && ($data->horas) && ($data->usuid)){
    if(strlen(trim($data->titulo)) <= 50){
        $titulo = mysqli_real_escape_string($conexion, trim($data->titulo));;
    }
    else{
        $projects[0]['success'] = 0;
        $projects[0]['mensaje'] = 'El titulo no debe tener mas de 50 caracteres, no se puede insertar.';
        echo json_encode($projects);
        return false;
    }
    $descripcion = mysqli_real_escape_string($conexion, trim($data->descripcion));;
    #$fecestimada = mysqli_real_escape_string($conexion, trim($data->fecestimada));;
    if(!$fecestimada = validafecha($conexion,trim($data-> fecestimada))){
        return false;
    };
    #$fecentrega = mysqli_real_escape_string($conexion, trim($data->fecentrega));;
    if(!$fecentrega = validafecha($conexion,trim($data-> fecentrega))){
        return false;
    };
    if(strlen(trim($data-> horas)) <= 3){
        $horas = mysqli_real_escape_string($conexion, trim($data-> horas));;
    }
    else{
        $projects[0]['success'] = 0;
        $projects[0]['mensaje'] = 'El campo horas tiene mas de 3 caracteres, no se puede insertar.';
        echo json_encode($projects);
        return false;
    }     
    $usuid = mysqli_real_escape_string($conexion, trim($data->usuid));;
}
else if(empty($data->titulo)){
    $projects[0]['success'] = 0;
    $projects[0]['mensaje'] = 'El campo titulo esta vacio';
    echo json_encode($projects);
    return false;
}
else if(empty($data->fecestimada)){
    $projects[0]['success'] = 0;
    $projects[0]['mensaje'] = 'El campo fecha estimada esta vacio';
    echo json_encode($projects);
    return false;
}
else if(empty($data->fecentrega)){
    $projects[0]['success'] = 0;
    $projects[0]['mensaje'] = 'El campo fecha de entrega esta vacio';
    echo json_encode($projects);
    return false;
}
else if(empty($data->horas)){
    $projects[0]['success'] = 0;
    $projects[0]['mensaje'] = 'El campo horas esta vacio';
    echo json_encode($projects);
    return false;
}
else if(empty($data->usuid)){
    $projects[0]['success'] = 0;
    $projects[0]['mensaje'] = 'No se encontro id del usuario';
    echo json_encode($projects);
    return false;
}

$consulta = "SELECT COUNT(usuid) 
                FROM usuario 
                WHERE usuid = $usuid ";

$resultado = mysqli_query($conexion,$consulta);

$row=mysqli_fetch_row($resultado);
if($row[0] == 0){
    $projects[0]['success'] = 0;
    $projects[0]['mensaje'] = 'El usuario no existe';
    echo json_encode($projects);
    return false;
}

$consulta = "INSERT INTO proyecto (titulo, descripcion, fecestimada, fecentrega, horas, usuid) 
                           VALUES ('{$titulo}', '{$descripcion}', '{$fecestimada}', '{$fecentrega}', '{$horas}', $usuid)";

if($resultado = mysqli_query($conexion,$consulta)){
    $projects[0]['success'] = 1;
    $projects[0]['mensaje'] = 'Se inserto correctamente';
    echo json_encode($projects);
}
else{
    $projects[0]['success'] = 0;
    $projects[0]['mensaje'] = 'No se inserto proyecto';
    echo json_encode($projects);
}

mysqli_close($conexion);

?>