<?php require_once("banco.php"); ?>
<?php 
    //inicia sessão
    session_start();

    //confere se o usuario passou pela pagina de login
    if(!isset($_SESSION["user"])){
        header("location:login.php");
    }

    //verificando campos de preenchimento
    if(isset($_GET["erroCarro"])){
        $mensagem = "Preencha todos os campos!";
    }

    //consulta ao banco de dados
    $consulta = "SELECT modelo,placa,hora,carroID ";
    $consulta .= " FROM carros ";
    //se ouver uma pesquisa, mostrara somente o resultado da mesma
    if(isset($_GET["pesquisa"])){
        $p = $_GET["pesquisa"];
        $consulta .= " WHERE placa LIKE '%{$p}%'";
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
        <!-- inicio da barra de navegacao -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark"> 
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#conteudoNavbarSuportado" aria-controls="conteudoNavbarSuportado" aria-expanded="false" aria-label="Alterna navegação">
                <span class="navbar-toggler-icon"></span>
            </button>       
            <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <a class="nav-link active" href="index.php">Página Inicial <span class="sr-only">(página atual)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="contato.php" >Página de Contato</a>
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
        <!-- final da barra de navegacao -->
        <div  class="container">
            <section>
                <!-- inicio do formulario para adicionar veiculo -->
                <form action="inserir.php" id="formulario" method="get">
                    <h2 class=" mt-5" title="Adicionar veículo">Adicionar veículo</h2>
                    <div class="form-group">
                        <input class="form-control" type="text" name="modelo_carro" placeholder="Digite o modelo do carro...">
                    </div>
                    <div class="form-group">
                        <input class="form-control"type="text"id="placa" name="placa_carro" placeholder="Digite a placa do carro...">
                    </div>
                    <!-- mostra mensagem caso os campos não sejam preenchidos -->
                    <p class="text-danger font-weight-bold"><?php if(isset($mensagem)){ echo $mensagem;}?>
                    <input title="Botão para adicionar veículo" class="mb-5 btn btn-success btn-lg btn-block" type="submit" name="adicionar" value="Adicionar">
                </form>
                <!-- final do formulario -->
            </section>
            <!-- inicio do formulario de pesquisa -->
            <form action="index.php" method="get">
                <div class="form-group mb-2">
                    <input class="form-control" type="search" name="pesquisa" placeholder="Digite a placa do veículo...">
                    <input title="Botão para pesquisar veículo" type="submit" class="btn btn-primary" name="pesquisar" value="Pesquisar">
                </div>
            </form>
            <!-- final do formulario de pesquisa -->
            <section class="tabela bg-white">
            <!-- inicio da tabela de carros -->
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Modelo</th>
                        <th scope="col">Placa</th>
                        <th scope="col">Entrada</th>
                        <th scope="col">Finalizar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- listagem dos carros -->
                    <!-- coloca o resultado da consulta em um array associativo na variavel linha -->
                    <?php while($linha = mysqli_fetch_assoc($resultado)){?>
                        <form action="excluir.php" method="get">
                            <tr>
                                <th scope="row"><?php echo $linha["modelo"]?></th>
                                <td><?php echo $linha["placa"]?></td>
                                <td><?php echo $linha["hora"]?></td>
                                <input type="hidden" name="carroID" value="<?php echo $linha["carroID"]?>">
                                <td title="Botão para finalizar veículo">
                                    <a href="dados-carro.php?ID=<?php echo $linha["carroID"]?>" class="link btn btn-danger finalizar text-center">Finalizar</a>
                                </td>
                            </tr>
                        </form>
                    <?php }?>
                    <!-- fim da listagem dos carros -->
                    </tbody>
                </table>
            <!-- final da tabela de carros -->
            </section>  
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
