<?php require_once("banco.php");?>
<?php 
    //inicia sessao
    session_start();

    //verifica se o usuario passou pelo login
    if(!isset($_SESSION["user"])){
        header("location:login.php");
    }

    //recebe os dados do usuario
    if(isset($_POST["usuario"])){
        $usuario = $_POST["usuario"];
        $senha = $_POST["senha"];

        //consulta no banco de dados
        $consulta = " SELECT usuario,senha,ID ";
        $consulta .= " FROM adms ";
        $consulta .= " WHERE usuario = '{$usuario}' AND senha = '{$senha}'";

        //conexao ao banco de dados
        $resultado = mysqli_query($conecta,$consulta);

        //testando conexao
        if(!$resultado){
            die("Falha na consulta!");
        }

        //coloca o resultado da consulta em um array associativo
        $resultado = mysqli_fetch_assoc($resultado);
        
        //mostra mensagem de erro
        if(empty($resultado)){
            $mensagem = "Login sem sucesso!";
        }else{
            //inicia sessao como administrador
            $_SESSION["master"] = $resultado["ID"];
            header("location:add-user.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/reset.css">
    <title>Estacionamento - Debossam</title>
    <link rel="icon" href="css/images/carro-ecologico.png">
    <link href="https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<body>
    <header class="cabecalho p-5">
        <div class="text-center">
            <h1 class="d-inline text-white">Estacionamento</h1>
        </div>
    </header>
    <section>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark"> 
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#conteudoNavbarSuportado" aria-controls="conteudoNavbarSuportado" aria-expanded="false" aria-label="Alterna navegação">
                <span class="navbar-toggler-icon"></span>
            </button>       
            <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <a class="nav-link" href="index.php">Página Inicial <span class="sr-only">(página atual)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="contato.php">Página de Contato</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active " href="add-user.php">Administração de Usuários</a>
                  </li>
                <li class="nav-item">
                  <a class="nav-link text-danger font-weight-bold text-uppercase" href="sair.php">Sair</a>
                </li>
              </ul>
            </div>
          </nav>
    </section>
    <section class="container contato mt-5">
        <div>
        <h1 class="d-inline text-primary" title="Administração de Usuários">Administração de Usuários</h1>
            <!-- inicio do formulario de login -->
            <form action="login-add-user.php" method="post">
                <div class="form-group">
                <label for="exampleFormControlInput1">Usuário</label>
                <input type="text" name="usuario" class="form-control" id="exampleFormControlInput1" placeholder="Seu nome de usuário...">
                </div>
                <div class="form-group">
                <label for="exampleFormControlTextarea1">Sua Senha</label>
                <input type="password" class="form-control" name="senha" id="exampleFormControlTextarea1" placeholder="Sua senha..">
                </div>
                <input title="Login" type="submit" class="btn btn-success btn-lg" name="login" value="Login">
                <!-- mostra mensagem de erro -->
                <?php if(isset($mensagem)) { ?>
                <p title="Mensagem de erro no login" class="text-white text-center font-weight-bold bg-danger w-25 p-2 mt-1"><?php echo $mensagem?></p>
                <?php }?>
            </form>
            <!-- final do formulario de login -->
        </div>
    </section>
    <footer class="text-center mt-5 p-5 bg-dark text-white">
        <p>Este site foi desenvolvido por Thiago Debossam Nogueira.</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
<?php mysqli_close($conecta);?>