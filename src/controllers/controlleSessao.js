if(!sessionStorage.getItem("SESSAO")){
    window.location.href = "http://localhost/estacionamento/login/";
}

var sair = document.querySelector("#sair");
sair.onclick = e=>{
    e.preventDefault();
    sessionStorage.removeItem("SESSAO");
    window.location.href = "http://localhost/estacionamento/login/";
}