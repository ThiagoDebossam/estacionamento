window.onload = new IndexController(), new AdmController();

//listagem dos carros
function retornarCarros(data){
    data.forEach(carro=>{
        IndexController.adicionaCarroNaTabela(carro,$("#tabela"));
    });
}

function retornarUsuarios(data){
    data.forEach(usuario=>{
        AdmController.adicionaUsuarioNaTabela(usuario);
    });
}