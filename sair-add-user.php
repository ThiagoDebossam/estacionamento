<?php
//encerra sessao como administrador
    session_start();
    unset($_SESSION["master"]);
    header("location:login-add-user.php");
?>