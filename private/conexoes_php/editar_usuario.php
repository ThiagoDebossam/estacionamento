<?php require_once("banco.php");?>
<?php 
    if(isset($_POST["edicao_nome"])){

        $usuario = $_POST["edicao_nome"];
        $email = $_POST["edicao_email"];
        $email_ref = $_POST["edicao_email_ref"];
        $ID = $_POST["ID"];
        $senha = $_POST["edicao_senha"];

        if(!($email == $email_ref)){
            //verifica se não tem usuarios com os mesmos dados
            $verifica = "SELECT * FROM usuarios WHERE email = '{$email}' ";
            $conexao = mysqli_query($conecta,$verifica);
            $conexao = mysqli_fetch_assoc($conexao);
            if(!empty($conexao)){
                echo "Email já existente.";
                return;
            }

        }
        $alteracao = "UPDATE usuarios SET ";
        $alteracao .= " usuario = '{$usuario}',";
        $alteracao .= " email = '{$email}', ";
        $alteracao .= " senha = '{$senha}' ";
        $alteracao .= " WHERE ID = '{$ID}'";

        $operacao = mysqli_query($conecta,$alteracao);

        if(!$operacao){
            die("Erro");
        }

    }else{
        die("Erro de acesso!.");
    }
    mysqli_close($conecta);
?>