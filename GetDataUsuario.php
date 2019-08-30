<?php

require("BD.php");

$conexion = mysqli_connect($host,$username,$password,$db_name);
mysqli_set_charset($conexion,"utf8");

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->usuidsesion) && !empty($data->usuid)){
    $usuidsesion = mysqli_real_escape_string($conexion, trim($data->usuidsesion));;
    $usuid = mysqli_real_escape_string($conexion, trim($data->usuid));;
}
else if(empty($data->usuidsesion)){
    $projects[0]['success'] = 0;
    $projects[0]['mensaje'] = 'El id del usuario de la sesion esta vacio';
    echo json_encode($projects);
    return false;
}
else if(empty($data->usuid)){
    $projects[0]['success'] = 0;
    $projects[0]['mensaje'] = 'El id del usuario a observar esta vacio';
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
    $projects[0]['mensaje'] = 'El usuario no tiene rol de administrador, no puede ver detalles.';
    echo json_encode($projects);
    return false;
}

$consulta = "SELECT *
                FROM usuario 
                WHERE usuid = $usuid ";
$resultado = mysqli_query($conexion,$consulta);

if(mysqli_num_rows($resultado) > 0){
    $i = 0;
    while($row = mysqli_fetch_assoc($resultado)){
        $projects[$i]['usuid'] = $row ['usuid'];
	$projects[$i]['codigo'] = $row ['codigo'];
        $projects[$i]['contrasena'] = $row ['contrasena'];
        $projects[$i]['nombre'] = $row ['nombre'];
        $projects[$i]['rol'] = $row ['rol'];
        $i++;
    }
    echo json_encode($projects);
}else{
    $projects[0]['success'] = 0;
    $projects[0]['mensaje'] = 'No se encontro informacion';
    echo json_encode($projects);
}
mysqli_close($conexion);

?>