<?php require_once("banco.php"); ?>
<?php
    //inicia sessao
    session_start();

    //confere se o usuario passou pela pagina de login
    if(!isset($_SESSION["user"])){
        header("location:login.php");
    }

    //consulta ao banco de dados do carro em evidencia
    if(isset($_GET["ID"])){
        $id = $_GET["ID"];

        $consulta = " SELECT * ";
        $consulta .= " FROM carros ";
        $consulta .= " WHERE carroID = {$id} ";

        //conexao ao banco de dados
        $resultado = mysqli_query($conecta,$consulta);

        //testando conexao
        if(!$resultado){
            die("Erro na cosnulta");
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
<body class="fundo">
    <header class="cabecalho p-5">
        <div class="text-center">
            <h1 class="d-inline text-white">Estacionamento</h1>
        </div>
    </header>

    <main class="container">
        <!-- inicio do formulario de exibicao dos dados do carro -->
        <form action="excluir.php" method="get" class="principal mt-5 mb-5">
            <!-- coloca o resultado da consulta em um array associativo na variavel linha -->
            <?php while($linha = mysqli_fetch_assoc($resultado)){ ?>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label font-weight-bold">Modelo</label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext text-success font-weight-bold" id="staticEmail" value="<?php echo $linha["modelo"]?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="font-weight-bold col-sm-2 col-form-label">Placa</label>
                    <div class="col-sm-10">
                        <input type="text"  readonly class="form-control-plaintext text-success font-weight-bold" id="staticEmail" value="<?php echo $linha["placa"]?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="font-weight-bold col-sm-2 col-form-label">Entrada</label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext text-success font-weight-bold" id="staticEmail" value="<?php echo $linha["hora"]?>">
                    </div>
                </div>
                <input type="hidden" name="carroID" value="<?php echo  $linha["carroID"] ;?>">
                <button title="Finalizar"type="submit" class="link btn btn-danger btn-lg btn-block btn-lg finalizar text-center" value="Finalizar">Finzalizar</button>
                <a title="Cancelar" href="index.php" class="link btn btn-warning btn-lg btn-block btn-lg finalizar text-center" value="cancelar">Cancelar</a>
            <?php }?>
        </form>
        <!-- fim do formulario de exibicao dos dados do carro -->
    </main>

    <footer class="text-center  p-5 bg-dark text-white rodape">
        <p>Este site foi desenvolvido por Thiago Debossam Nogueira.</p>
        <p>Caso queria enviar um email acesse a nossa <a href="contato.php">página de contato</a>.</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
<?php mysqli_close($conecta);?>