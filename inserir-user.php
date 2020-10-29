<?php require_once("banco.php"); ?>
<?php
    //inicia sessao
    session_start();

    //recebe os dados do formulario
    if(isset($_GET["usuario"])){
        $usuario = $_GET["usuario"];
        $email = $_GET["email"];
        $senha = $_GET["senha"];

        //verifica preenchimento dos campos
        if(empty($usuario) || empty($email) || empty($senha)){
            header("location:add-user.php?erro=erro");
            return;
        }

        //realiza a insercao no banco de dados
        $insert = " INSERT INTO  usuarios ";
        $insert .= " (usuario,email,senha)";
        $insert .= " VALUES";
        $insert .= "('$usuario','$email','$senha')";

        //conexao ao banco de dados
        $qinserir = mysqli_query($conecta, $insert);

        //testanto conexao
        if(!$qinserir){
            die("Erro na inserção");
        }
        header("location:add-user.php");
    }else{
        //verificacao de seguranca
        header("location:login.php");
    }
?>
<?php mysqli_close($conecta);?>