$("#formularioLogin").submit(function(e){
    e.preventDefault();
    let form = $(this);
    verificaLogin(form);
});

function verificaLogin(login){
    $.ajax({
        type: "POST",
        data: login.serialize(),
        url:"../private/conexoes_php/conexao_login.php",
        async: true
    }).then(data=>{
        if(data == "Sucesso"){
            sessionStorage.setItem("SESSAO", "user");
            window.location.href = "../";
        }else{
            $("#mensagem").html(data);
        }
    }, e=>{
        console.error("Problemas com o banco de dados.");
    });
}