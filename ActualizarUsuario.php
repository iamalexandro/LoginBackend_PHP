<?php

require("BD.php");

$conexion = mysqli_connect($host,$username,$password,$db_name);
mysqli_set_charset($conexion,"utf8");

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->usuidsesion) && !empty($data->usuid) && !empty($data->codigo) && !empty($data->contrasena) && !empty($data->nombre) && !is_null($data->rol)){
    $usuidsesion = mysqli_real_escape_string($conexion, trim($data->usuidsesion));;
    $usuid = mysqli_real_escape_string($conexion, trim($data->usuid));;
    if(strlen(trim($data->codigo)) <= 50){
        $codigo = mysqli_real_escape_string($conexion, trim($data->codigo));;
    }
    else{
        $projects[0]['success'] = 0;
        $projects[0]['mensaje'] = 'El correo no debe tener mas de 50 caracteres, no se puede actualizar.';
        echo json_encode($projects);
        return false;
    }
    
    if(strlen(trim($data->contrasena)) <= 50){
        $contrasena = mysqli_real_escape_string($conexion, trim($data->contrasena));;
    }
    else{
        $projects[0]['success'] = 0;
        $projects[0]['mensaje'] = 'La contrasena no debe tener mas de 250 caracteres, no se puede actualizar.';
        echo json_encode($projects);
        return false;
    }

    if(strlen(trim($data->nombre)) <= 50){
        $nombre = mysqli_real_escape_string($conexion, trim($data->nombre));;
    }
    else{
        $projects[0]['success'] = 0;
        $projects[0]['mensaje'] = 'El nombre no debe tener mas de 250 caracteres, no se puede actualizar.';
        echo json_encode($projects);
        return false;
    }
    
    $rol = mysqli_real_escape_string($conexion, trim($data->rol));;
}
else if(empty($data->usuidsesion)){
    $projects[0]['success'] = 0;
    $projects[0]['mensaje'] = 'No se encontro id del usuario de la sesion';
    echo json_encode($projects);
    return false;
}
else if(empty($data->usuid)){
    $projects[0]['success'] = 0;
    $projects[0]['mensaje'] = 'No se encontro id del usuario a actualizar';
    echo json_encode($projects);
    return false;
}
else if(empty($data->codigo)){
    $projects[0]['success'] = 0;
    $projects[0]['mensaje'] = 'El campo codigo esta vacio';
    echo json_encode($projects);
    return false;
}
else if(empty($data->contrasena)){
    $projects[0]['success'] = 0;
    $projects[0]['mensaje'] = 'El campo contrasena esta vacio';
    echo json_encode($projects);
    return false;
}
else if(empty($data->nombre)){
    $projects[0]['success'] = 0;
    $projects[0]['mensaje'] = 'El campo nombre esta vacio';
    echo json_encode($projects);
    return false;
}
else if(is_null($data->rol)){
    $projects[0]['success'] = 0;
    $projects[0]['mensaje'] = 'El campo rol esta vacio';
    echo json_encode($projects);
    return false;
}

if(!checkdnsrr(array_pop(explode("@",$codigo)),"MX")){
    $projects[0]['success'] = 0;
    $projects[0]['mensaje'] = 'No es un dominio correcto de correo electronico';
    echo json_encode($projects);
    return false;
}

$consulta = "SELECT rol 
                FROM usuario 
                WHERE usuid = '$usuidsesion' ";
$resultado = mysqli_query($conexion,$consulta);

$row=mysqli_fetch_row($resultado);
if($row[0] == 0){
    $projects[0]['success'] = 0;
    $projects[0]['mensaje'] = 'El usuario no tiene rol de administrador, no puede actualizar.';
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

$consulta = "UPDATE usuario 
                         SET codigo = '{$codigo}', 
                             contrasena = '{$contrasena}', 
                             nombre = '{$nombre}', 
                             rol = '{$rol}' 
             WHERE usuid = $usuid ";

if($resultado = mysqli_query($conexion,$consulta)){
    $projects[0]['success'] = 1;
    $projects[0]['mensaje'] = 'Se actualizo usuario correctamente';
    echo json_encode($projects);
}
else{
    $projects[0]['success'] = 0;
    $projects[0]['mensaje'] = 'No se actualizo usuario';
    echo json_encode($projects);
}

mysqli_close($conexion);

?>