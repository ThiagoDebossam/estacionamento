<?php require_once("banco.php");?>
<?php 
    //inicia sessão
    session_start();

    //verifica se o usuario tem acesso
    if(isset($_POST["usuario"])){
        $usuario = $_POST["usuario"];
        $senha = $_POST["senha"];
        $email = $_POST["email"];

        //consulta para usuarios
        $consulta = "SELECT * ";
        $consulta .= " FROM usuarios ";
        $consulta .= " WHERE usuario = '{$usuario}' AND senha = '{$senha}' AND email = '{$email}'";

        //conexao ao banco de dados
        $resultado = mysqli_query($conecta, $consulta);

        //testando conexao
        if(!$resultado){
            die("Falha na consulta ao banco");
        }

        //consulta para adms
        $consultaAdms = "SELECT * ";
        $consultaAdms .= " FROM adms ";
        $consultaAdms .= " WHERE usuario = '{$usuario}' AND senha = '{$senha}' AND email = '{$email}'";

        //conexao ao banco de dados
        $resultadoAdms = mysqli_query($conecta, $consultaAdms);

        //testando conexao
        if(!$resultadoAdms){
            die("Falha na consulta ao banco");
        }

        //colocando o resultado da consulta em um array associativo
        $resultadoAdms = mysqli_fetch_assoc($resultadoAdms);
        $resultado = mysqli_fetch_assoc($resultado);

        //mostra mensagem de erro no login
        if(empty($resultado) && empty($resultadoAdms)){
            $mensagem = "Login sem sucesso";
        }

        //se o resultado de usuario for ok redireciona para pagina inicial
        if(!empty($resultado)){
            $_SESSION["user"] = $resultado["ID"];
            header("location:index.php");
        }

        //se o resultado de administradir for ok redireciona para pagina inicial
        if(!empty($resultadoAdms)){
            $_SESSION["user"] = $resultadoAdms["ID"];
            header("location:index.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title title="Estacionamento - Debossam">Estacionamento - Debossam</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="icon" href="css/images/carro-ecologico.png">
    <link href="https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<body>
    <header class="cabecalho p-5">
        <div class="text-center">
            <h1 class="d-inline text-white" title="Estacionamento">Estacionamento</h1>
        </div>
    </header>
    <section class="container contato mt-5">
        <div>
        <!-- inicio do formulario de login -->
            <form action="login.php" method="post">
                <div class="form-group">
                <label for="exampleFormControlInput1">Usuário</label>
                <input type="text" name="usuario" class="form-control" id="exampleFormControlInput1" placeholder="Seu nome de usuário...">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Email</label>
                    <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="nome@exemplo.com">
                    <small id="emailHelp"  class="form-text text-muted">Nunca vamos compartilhar seu email, com ninguém.</small>  
                </div>
                <div class="form-group">
                <label for="exampleFormControlTextarea1">Sua Senha</label>
                <input type="password" class="form-control" name="senha" id="exampleFormControlTextarea1" placeholder="Sua senha..">
                </div>
                <input type="submit" class="btn btn-success btn-lg" name="login" value="Login">
                <!-- mostra mensagem de erro no login -->
                <?php if(isset($mensagem)) { ?>
                <p class="text-white text-center font-weight-bold bg-danger w-25 p-2 mt-1"><?php echo $mensagem?></p>
                <?php }?>
            </form>
            <!-- fim do formulario de login -->
        </div>
    </section>
    <footer class="text-center mt-5 p-5 bg-dark text-white">
        <p alt="Copyright do site">Este site foi desenvolvido por Thiago Debossam Nogueira.</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
<?php mysqli_close($conecta);?>