<?php
    session_start();
    $hora = date('H:i');
    $session_id = session_id();
    $token = hash('sha256', $hora, $session_id);
    $_SESSION['token'] = $token;
    /*echo $token;
    echo $_SESSION['token'];*/
?>