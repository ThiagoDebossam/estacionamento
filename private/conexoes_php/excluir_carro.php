<?php require_once("banco.php");?>
<?php 
    if(isset($_GET["carroID"])){
        $carroID = $_GET["carroID"];
        $consulta = "DELETE FROM carros WHERE carroID = '{$carroID}' ";
        $conexao = mysqli_query($conecta,$consulta);
        if(!$conexao) die("ERRO");
        echo "Excluindo...";
    }else{
        die("Erro de acesso!.");
    }

    mysqli_close($conecta);
?>