<?php require_once("banco.php");?>
<?php 
    if(isset($_POST["usuario"])){
        $usuario = $_POST["usuario"];
        $senha = $_POST["senha"];

        //login usuarios
        $consulta = "SELECT usuario,senha FROM usuarios WHERE usuario = '{$usuario}' AND senha = '{$senha}'";
        $conexao = mysqli_query($conecta,$consulta);
        if(!$conexao) die("Erro");

        //login master
        $consultaMaster = "SELECT usuario,senha FROM adms WHERE usuario = '{$usuario}' AND senha = '{$senha}'";
        $conexaoMaster = mysqli_query($conecta,$consultaMaster);

        $conexaoMaster = mysqli_fetch_assoc($conexaoMaster);
        $conexao = mysqli_fetch_assoc($conexao);

        if(empty($conexao) && empty($conexaoMaster)){
            echo "Login sem sucesso";
        }else{
            echo "Sucesso";
        }
    }else{
        die("Erro de acesso!.");
    }
    mysqli_close($conecta);
?>