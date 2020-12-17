<?php require_once("banco.php");?>
<?php
    date_default_timezone_set('America/Sao_Paulo');

    if(isset($_POST["usuario"])){
        $usuario = $_POST["usuario"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        $ID = $_POST["ID"];

        $verifica_usuario = " SELECT * FROM usuarios WHERE usuario = '{$usuario}' OR email = '{$email}' ";
        $conexao = mysqli_query($conecta,$verifica_usuario);
        $conexao = mysqli_fetch_assoc($conexao);


        if(empty($conexao)){
            $inserir = "INSERT INTO usuarios ";
            $inserir .= "(usuario,email,senha,ID) ";
            $inserir .= "VALUES ";
            $inserir .= "('$usuario','$email','$senha','$ID')";

            $operacao = mysqli_query($conecta, $inserir);                   

        }else{
            echo "Usuário e/ou email já cadastrado.";
        }
    }else{
        die("Erro de acesso!.");
    }
    //fecha conexao
    mysqli_close($conecta);
?>