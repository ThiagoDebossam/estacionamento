<?php require_once("banco.php");?>
<?php 
    //inicia sessao
    session_start();

    //verifica se o usuario passou pelo login
    if(!isset($_SESSION["user"])){
        header("location:login.php");
    }

    //verifica se o usuario eh uma adimistrador
    if(!isset($_SESSION["master"])){
        header("location:login-add-user.php");
    }

    //recebe os dados do usuario
    if(isset($_POST["usuario"])){
        $usuario = $_POST["usuario"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        $ID = $_POST["ID"];

        //exclusao no banco de dados
        $excluir = "DELETE FROM usuarios ";
        $excluir .= " WHERE ID = {$ID}";

        //conexao ao banco de dados
        $excluir = mysqli_query($conecta,$excluir);

        //testando conexao
        if(!$excluir){
            die("Erro na exclusão!");
        }else{
            //se a edicao for sucesso redireciona para pagina de administracao
            header("location:add-user.php");
        }
    }
    //consulta ao banco de dados
    $consulta = "SELECT usuario,email,senha,ID ";
    $consulta .= "FROM usuarios ";
    //recebe o id do usuario para consulta-lo no banco, se nao houver condigo redireciona
    if(isset($_GET["codigo"]) && $_GET["codigo"] ==! "" ) {
        $id = $_GET["codigo"];
        $consulta .= "WHERE ID = '{$id}' ";
    } else{  
        header("location:add-user.php");

    }

    //conexao ao banco
    $consulta = mysqli_query($conecta,$consulta);

    //testando conexao
    if(!$consulta){
        die("Erro na consulta");
    }

    //coloca o resultado da consulta em um array associativo
    $dados_usuario = mysqli_fetch_assoc($consulta);
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
</head>
<body class="fundo">
    <header class="cabecalho p-5">
        <div class="text-center">
            <h1 class="d-inline text-white">Estacionamento</h1>
        </div>
    </header>
    <main class="container mt-5 mb-5">
        <div class="principal">
            <!-- inicio do formulario de exclusao -->
            <form action="excluir-user.php" method="post">
                <h1 class="text-danger" title="Deseja excluir este usuário?">Deseja excluir este usuário?</h1>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nome de usuário</label>
                    <input type="text" name="usuario" value="<?php echo $dados_usuario["usuario"]?>" readonly class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nome de usuário">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Endereço de email</label>
                    <input type="email" value="<?php echo $dados_usuario["email"]?>" readonly name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="nome@exemplo.com">
                    <small id="emailHelp" class="form-text text-muted">Nunca vamos compartilhar seu email, com ninguém.</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Senha</label>
                    <input type="text" value="<?php echo $dados_usuario["senha"]?>" readonly name="senha" class="form-control" id="exampleInputPassword1" placeholder="Senha">
                    <input type="hidden" value="<?php echo $dados_usuario["ID"]?>" name="ID">
                </div>
                <button title="Excluir" type="submit" class="btn btn-danger btn-lg btn-block">Excluir</button>
                <a title="Cancelar" href="add-user.php" class="btn btn-warning btn-lg btn-block">Cancelar</a>
            </form>
            <!-- final do formulario de exclusao -->
        </div>
    </main>
      <footer class="text-center mt-5 p-5 bg-dark text-white">
        <p>Este site foi desenvolvido por Thiago Debossam Nogueira.</p>
        <p>Caso queria enviar um email acesse a nossa <a href="contato.php">página de contato</a>.</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
<?php mysqli_close($conecta);?>