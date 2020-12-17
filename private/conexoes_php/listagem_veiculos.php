<?php require_once("banco.php"); ?>
<?php 
    if(isset($_GET['callback'])){
        //preparo do arquivo para callback

        $callback = isset($_GET['callback']) ? $_GET['callback'] : false;

        $consulta = "SELECT * FROM carros ";
        $carros = mysqli_query($conecta,$consulta);

        if(!$carros) die("Erro na consulta");

        $retorno = array();

        while($linha = mysqli_fetch_object($carros)){
            $retorno[] = $linha;
        }

        echo  ($callback ? $callback . '(' : '') . json_encode($retorno) . ($callback ?  ')' : '');
    }else{
        die("Erro de acesso!.");
    }  
    //fecha conexao
    mysqli_close($conecta);
?>