<?php

require("BD.php");
require("Helpers.php");

$conexion = mysqli_connect($host,$username,$password,$db_name);
mysqli_set_charset($conexion,"utf8");

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->deproyectoid) && !empty($data->proyectoid) && !empty($data->titulo) && !empty($data->fecha)){
    $deproyectoid = mysqli_real_escape_string($conexion, trim($data->deproyectoid));;
    $proyectoid = mysqli_real_escape_string($conexion, trim($data->proyectoid));;
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
    if(!$fecha = validafecha($conexion,trim($data->fecha))){
        return false;
    };
}
else if(!empty($data->deproyectoid) && !empty($data->titulo) && !empty($data->fecha)){
    $deproyectoid = mysqli_real_escape_string($conexion, trim($data->deproyectoid));;
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
    if(!$fecha = validafecha($conexion,trim($data->fecha))){
        return false;
    };
}
else if(empty($data->deproyectoid)){
    $projects[0]['success'] = 0;
    $projects[0]['mensaje'] = 'No se encontro id de la tarea';
    echo json_encode($projects);
    return false;
}
else if(empty($data->titulo)){
    $projects[0]['success'] = 0;
    $projects[0]['mensaje'] = 'El campo titulo esta vacio';
    echo json_encode($projects);
    return false;
}
else if(empty($data->fecha)){
    $projects[0]['success'] = 0;
    $projects[0]['mensaje'] = 'El campo fecha esta vacio';
    echo json_encode($projects);
    return false;
}

$consulta = "SELECT COUNT(deproyectoid) 
             FROM deproyecto 
             WHERE deproyectoid = $deproyectoid ";

$resultado = mysqli_query($conexion,$consulta);

$row=mysqli_fetch_row($resultado);
if($row[0] == 0){
    $projects[0]['success'] = 0;
    $projects[0]['mensaje'] = 'La tarea no existe';
    echo json_encode($projects);
    return false;
}

if(!empty($data->proyectoid)){

    $consulta = "SELECT usuid
                 FROM deproyecto 
                 WHERE deproyectoid = $deproyectoid ";
    $resultado = mysqli_query($conexion,$consulta);

    if(mysqli_num_rows($resultado) > 0){
        $row=mysqli_fetch_row($resultado);
        $usuid = $row[0];
    }

    $consulta = "SELECT COUNT(proyectoid) 
                 FROM proyecto 
                 WHERE proyectoid = $proyectoid AND usuid = $usuid ";
    $resultado = mysqli_query($conexion,$consulta);

    $row=mysqli_fetch_row($resultado);
    if($row[0] == 0){
        $projects[0]['success'] = 0;
        $projects[0]['mensaje'] = 'El proyecto no existe';
        echo json_encode($projects);
        return false;
    }

    $consulta = "UPDATE deproyecto 
                        SET proyectoid = '$proyectoid',
                            titulo = '{$titulo}', 
                            descripcion = '{$descripcion}', 
                            fecha = '{$fecha}'
                 WHERE deproyectoid = $deproyectoid ";
}
else{
    $consulta = "UPDATE deproyecto 
                        SET titulo = '{$titulo}',
			    proyectoid = null, 
                            descripcion = '{$descripcion}', 
                            fecha = '{$fecha}'
                 WHERE deproyectoid = $deproyectoid ";
}

if($resultado = mysqli_query($conexion,$consulta)){
    $projects[0]['success'] = 1;
    $projects[0]['mensaje'] = 'Se actualizo tarea correctamente';
    echo json_encode($projects);
}
else{
    $projects[0]['success'] = 0;
    $projects[0]['mensaje'] = 'No se actualizo tarea';
    echo json_encode($projects);
}

mysqli_close($conexion);

?>