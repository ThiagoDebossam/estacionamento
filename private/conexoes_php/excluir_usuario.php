<?php require_once("banco.php");?>
<?php 
    if(isset($_GET["ID"])){
        $ID = $_GET["ID"];

        $exclusao = "DELETE FROM usuarios WHERE ID = '{$ID}' ";
        $exclusao = mysqli_query($conecta,$exclusao);
        if(!$exclusao) die("ERRO");
    }else{
        die("Erro de acesso!.");
    }

    mysqli_close($conecta);
?>