<?php require_once("banco.php"); ?>
<?php 
    //inicia sessaqo
    session_start();

    //verifica se o usuario passou pelo login
    if(!isset($_SESSION["user"])){
      header("location:login.php");
    }

    //recebe os dados da mensagem
    if(isset($_POST["enviar"])){
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $mensagem = $_POST["mensagem"];

        //verifica se todos os campos foram preenchidos
        if(empty($email) || empty($nome) || empty($mensagem)){
          $mensagemErro = "Preencha todos os campos!";
        }else {
          $mensagem = "Mensagem enviada!";
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
</head>
<body>
    <header class="cabecalho p-5">
        <div class="text-center">
            <h1 class="d-inline text-white" title="Estacionamento">Estacionamento</h1>
        </div>
    </header>
    <main>
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
              <a class="nav-link active" href="contato.php">Página de Contato</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="add-user.php">Administração de Usuários</a>
              </li>
            <li class="nav-item">
              <a class="nav-link text-danger font-weight-bold text-uppercase" href="sair.php">Sair</a>
            </li>
          </ul>
        </div>
      </nav>
      <section class="container contato mt-5">
        <!-- inicio do forumalario de mensagem -->
        <form action="contato.php" method="post">
          <div class="form-group">
            <label for="exampleFormControlInput1">Nome</label>
            <input type="text" name="nome" class="form-control" id="exampleFormControlInput1" placeholder="Seu nome...">
          </div>
          <div class="form-group">
              <label for="exampleFormControlInput1">Email</label>
              <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="nome@exemplo.com">
              <small id="emailHelp" class="form-text text-muted">Nunca vamos compartilhar seu email, com ninguém.</small>
            </div>
          <div class="form-group">
            <label for="exampleFormControlTextarea1">Sua mensagem</label>
            <textarea class="form-control" name="mensagem" id="exampleFormControlTextarea1" placeholder="Sua mensagem.." rows="3"></textarea>
          </div>
          <!-- mostra mensagem de sucesso -->
          <?php if(isset($mensagem)) { ?>
          <p class="text-success font-weight-bold"><?php echo $mensagem?></p>
          <?php }?>
          <!-- mostra mensagem de erro -->
          <?php if(isset($mensagemErro)) { ?>
          <p class="text-danger font-weight-bold"><?php echo $mensagemErro?></p>
          <?php }?>
          <input title="Botão para enviar uma mensagem aos administradores" type="submit" class="btn btn-success btn-lg" name="enviar">
        </form>
          <!-- final do forumalario de mensagem -->
      </section>
    </main>
    <footer class="text-center mt-5 p-5 bg-dark text-white">
        <p>Este site foi desenvolvido por Thiago Debossam Nogueira.</p>
        <p>Voltar para a <a href="index.php">página inicial</a>.</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>