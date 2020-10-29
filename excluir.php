<?php require_once("banco.php"); ?>
<?php
    //inicia sessao
    session_start();

    //verifica se recebeu a id do carro
    if(isset($_GET["carroID"])){
        $id = $_GET["carroID"];

        //exclusao no banco de dados
        $consulta = "DELETE FROM carros ";
        $consulta .= " WHERE carroID = {$id}";

        //conexao ao banco de dados
        $resultado = mysqli_query($conecta,$consulta);

        //testanto conexao
        if(!$consulta){
            die("Erro na exclusão!");
        }else{
            //sucesso na exlcusao redireciona para pagina princiapal
            header("location:index.php");
        }
    }else{
        //redirecionamento de seguranca
        header("location:login.php");
    }
?>
<?php mysqli_close($conecta);?>