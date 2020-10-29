<?php
//encerra sessao de login
    session_start();
    unset($_SESSION["user"]);
    header("location:login.php");
?>