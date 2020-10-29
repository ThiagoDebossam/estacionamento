<?php 
    //conexao com o banco de dados
    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "estacionamento";
    $conecta = mysqli_connect($servidor, $usuario, $senha, $banco);

    if ( mysqli_connect_errno()){
        die ("Conexão falhou : " . mysqli_connect_errno());
    }
?>