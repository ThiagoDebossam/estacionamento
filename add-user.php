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

  //verificando campos de preenchimento
  if(isset($_GET["erro"])){
    $mensagem = "Preencha todos os campos!";
  }

  //consulta ao banco de dados
  $consulta = "SELECT usuario,email,ID ";
  $consulta .= " FROM usuarios ";
  //se houver uma pesquisa mostrara apenas o resultado da mesma
  if(isset($_GET["pesquisa"])){
    $p = $_GET["pesquisa"];
    $consulta .= " WHERE usuario LIKE '%{$p}%'";
  }
  //conexao ao banco de dados
  $resultado = mysqli_query($conecta,$consulta);

  //testando conexao
  if(!$resultado){
    die("Erro na consulta!");
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
<body class="fundo">
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
                  <a class="nav-link" href="contato.php">Página de Contato</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="add-user.php">Administração de Usuários</a>
                  </li>
                <li class="nav-item">
                  <a class="nav-link text-danger font-weight-bold text-uppercase" href="sair-add-user.php">Sair</a>
                </li>
              </ul>
            </div>
          </nav>
      <div class="container">
          <section>
          <!-- inicio do formulario para adicionar um usuario -->
            <form action="inserir-user.php" id="formulario" method="get">
                <h2 class=" mt-5" title="Adicionar um novo usuário">Adicionar um novo usuário</h2>
                <div class="form-group">
                    <input  class="form-control" type="text" name="usuario" placeholder="Digite o nome de usuário...">
                </div>
                <div class="form-group">
                    <input  class="form-control"type="email"id="placa" name="email" placeholder="nome@exemplo.com...">
                </div>
                <div class="form-group">
                  <input class="form-control"type="password"id="placa" name="senha" placeholder="Digite a senha...">
              </div>
              <!-- mostra mensagem de erro -->
              <p class="text-danger font-weight-bold"><?php if(isset($mensagem)){ echo $mensagem;}?></p>
                <input title="Botão para adicionar um novo usuário" class="mb-5 btn btn-success btn-lg btn-block" type="submit" name="adicionar" value="Adicionar">
            </form>
          <!-- final do formulario para adicionar um usuario -->
          </section>
          <form action="add-user.php" method="get" class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" name="pesquisa" type="search" placeholder="Nome do usuário" aria-label="Pesquisar">
            <input title="Botão para pesquisar um usuário" class="btn btn-outline-success my-2 my-sm-0" type="submit" value="Pesquisar">
          </form>
          <table class="usuario-desktop">
            <thead>
                <tr>
                  <th scope="col">Usuário</th>
                  <th scope="col">Email</th>
                  <th scope="col">Editar</th>
                  <th scope="col">Excluir</th>
                </tr>
              </thead>
              <tbody>
              <!-- coloca o resultado da consulta em um array associativo -->
                <?php while($linha = mysqli_fetch_assoc($resultado)) {?>
                  <tr>
                    <th scope="row"><?php echo $linha["usuario"]?></th>
                    <td><?php echo $linha["email"]?></td>
                    <input type="hidden" name="ID" value="<?php echo $linha["ID"]?>">
                    <td><a title="Botão para editar o usuário" class="btn btn-success" href="editar.php?codigo=<?php echo $linha["ID"]?>">Editar</a></td>
                    <td><a title="Botão para excluir o usuário" class="btn btn-danger" href="excluir-user.php?codigo=<?php echo $linha["ID"]?>">Excluir</a></td>
                  </tr>
                <?php }?>
              </tbody>
            </table>
            <!-- adaptação para usuários mobile -->
            <section class="usuario-mobile container">
              <?php while($linha = mysqli_fetch_assoc($resultado)) {?>
                <div class="w-100">
                  <p scope="row"><?php echo $linha["usuario"]?></p>
                  <p><?php echo $linha["email"]?></p>
                  <input type="hidden" name="ID" value="<?php echo $linha["ID"]?>">
                  <a class="btn btn-success text-white btn-lg" href="editar.php?codigo=<?php echo $linha["ID"]?>">Editar</a>
                  <a class="btn btn-danger text-white btn-lg" href="excluir-user.php?codigo=<?php echo $linha["ID"]?>">Excluir</a>
                </div>
              <?php }?>
            </section>
        </div>
    </main>
    <footer class="text-center rodape  p-5 bg-dark text-white">
        <p>Este site foi desenvolvido por Thiago Debossam Nogueira.</p>
        <p>Voltar para a <a href="index.php">página inicial</a>.</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
<?php mysqli_close($conecta);?>