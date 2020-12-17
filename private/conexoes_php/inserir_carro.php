<?php require_once("banco.php");?>
<?php
    date_default_timezone_set('America/Sao_Paulo');
    if(isset($_POST["modelo_carro"])){
        $modelo = $_POST["modelo_carro"];
        $placa = $_POST["placa_carro"];
        $carroID = $_POST["carroID"];
        $hora = new DateTime();
        $hora = $hora->format("H:i");

        $verifica_placa = " SELECT placa FROM carros WHERE placa = '{$placa}' ";
        $conexao = mysqli_query($conecta,$verifica_placa);
        $conexao = mysqli_fetch_assoc($conexao);
        
        if(empty($conexao)){
            $inserir = "INSERT INTO carros ";
            $inserir .= "(modelo,placa,hora,carroID) ";
            $inserir .= "VALUES ";
            $inserir .= "('$modelo','$placa','$hora','$carroID')";

            $operacao = mysqli_query($conecta, $inserir);  

        }else{
            echo "Placa já existente!";
        }

    }else{
        die("Erro de acesso!");
    }
    //fecha conexao
    mysqli_close($conecta);
?>
