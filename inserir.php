<?php require_once("banco.php"); ?>
<?php
    //inicia sessao
    session_start();

    //determina a referencia horaria do site
    date_default_timezone_set('America/Sao_Paulo');

    //validando formulario antes de adicionar
    $erro_modelo = $_GET["modelo_carro"];
    $erro_placa = $_GET["placa_carro"];

    //verifica se tem algum erro
    if(empty($erro_modelo) || empty($erro_placa)){
        //envia erro para pagina principal
        header("location:index.php?erroCarro");
        return;
    }

    //pega os dados enviados
    if(isset($_GET["modelo_carro"])){
        $modelo = $_GET["modelo_carro"];
        $placa = $_GET["placa_carro"];
        $hora = new DateTime();
        $hora = $hora->format("H:i:s");

        //inserçao no banco de dados
        $insert = " INSERT INTO  carros ";
        $insert .= " (modelo,placa,hora)";
        $insert .= " VALUES";
        $insert .= "('$modelo','$placa','$hora')";

        //conexao ao banco de dados
        $qinserir = mysqli_query($conecta, $insert);

        //testando conexao
        if(!$qinserir){
            die("Erro na inserção");
        }
        header("location:index.php");
    }else{
        //se nao houver nenhum dado redireciona para o login
        header("location:login.php");
    }
?>
<?php mysqli_close($conecta);?>