class AdmController{
    constructor(){
        this.trocaDeHtmlVisualmente();
        this.adicionarUsuarios();
        this.filtraTabela();
    }

    //os metodos estaticos sao necessarios!!

    static adicionaUsuarioNaTabela(usuario){
        let tr = document.createElement("tr");
        tr.dataset.usuario = JSON.stringify(usuario);
        tr.innerHTML = `
            <th class="nome" scope="row">${usuario.usuario}</th>
            <td>${usuario.email}</td>
            <td><a title="Botão para editar o usuário" class="btnEdita btn text-white btn-success">Editar</a></td>
            <td><a title="Botão para excluir o usuário" class="btnExclui btn text-white btn-danger">Excluir</a></td>
        `;

        $("#tabela-usuarios").append(tr);
        $(".btnEdita").click(e=>{
            e.preventDefault();
            let alvo = e.target.parentNode.parentNode;
            AdmController.mostraModalEdicao(alvo,usuario);    

        });
    
        $(".btnExclui").click(e=>{
            e.preventDefault();
            let alvo = e.target.parentNode.parentNode;
            AdmController.mostraModalExclusao(alvo);
        });
    }

    //troca de html visualmente
    trocaDeHtmlVisualmente(){
        let admUsuarios = document.querySelector("#linkAdm");
        admUsuarios.addEventListener("click", e=>{
            let adm = document.querySelector("#administracao-de-usuarios");
            let principal = document.querySelector("#principal");
            let linkPrincipal = document.querySelector("#linkPrincipal");

            adm.style.display = "block";
            admUsuarios.classList.add("active"); 

            principal.style.display = "none";
            linkPrincipal.classList.remove("active"); 
        });
    }

    //adicionar usuarios 

    adicionarUsuarios(){
        $("#formulario-usuarios").submit(e=>{
            e.preventDefault();
            let usuario = AdmController.pegaDadosUsuarioDoFormulario($("#usuario").val(),$("#email").val(),$("#senha").val());
            let form = `usuario=${usuario.usuario}&email=${usuario.email}&senha=${usuario.senha}&ID=${usuario.ID}`;
            if(AdmController.validaCampo($("#usuario").val(),$("#email").val(),$("#senha").val(),$("#mensagem-usuarios"))){
                this.inserirUsuarioNoBanco(form, usuario);
                $("#mensagem-usuarios").html("");
            }
        });
    }

    inserirUsuarioNoBanco(dados,usuario){
        $.ajax({
            type: "POST",
            data: dados,
            url: "private/conexoes_php/inserir_usuarios.php",
            async: true
        }).then(data=>{
            $("#mensagem-usuarios").html(data);
            if(!data){
                AdmController.adicionaUsuarioNaTabela(usuario);
                $('#formulario-usuarios')[0].reset();
            }
        },e=>{
            console.error("Erro na consulta ao banco de dados");
        });
    }

    static validaCampo(campoUsuario, campoEmail, campoSenha,localMensagem){
        let usuario = campoUsuario;
        let email = campoEmail;
        let senha = campoSenha;
        let mensagens = [];

        if(usuario.length <= 0 || email.length <=0){
            mensagens.push("Preencha todos os campos.");
            localMensagem.html(mensagens.join(" "));
    
            return false
        }else if(senha.length < 5){
            mensagens.push("A senha deve conter no mínimo 5 caracteres.");
            localMensagem.html(mensagens.join(" "));
            return false
    
        }else {
            return true;
        }
    }

    static pegaDadosUsuarioDoFormulario(campoUsuario,campoEmail,campoSenha,id = ""){
        let usuario = campoUsuario;
        let email = campoEmail;
        let senha = campoSenha;
        let jsonUsuario;
        if(id){
            jsonUsuario = new Usuario(usuario,email,senha,id);
        }else{
            jsonUsuario = new Usuario(usuario,email,senha);
        }
        return jsonUsuario;
    }

    //realizando busca na tabela
    filtraTabela(){
        $("#pesquisar").keyup(function(e){
            let nomes = document.querySelectorAll(".nome");
            let busca = $("#pesquisar").val();
            nomes.forEach(nome=>{
                let texto = nome.textContent;
                let regExp = new RegExp(busca, "i");
                if(!regExp.test(texto)){
                    nome.parentNode.style.display= "none";
                }else{
                    nome.parentNode.style.display= "table-row";
                }
            });
        });
    }

    static mostraModalEdicao(alvo){
        let alvoTrEdicao = alvo;
        alvo = JSON.parse(alvo.dataset.usuario);
        if(!alvo.usuario){
            alvo.usuario = alvo._usuario;
            alvo.email = alvo._email;
            alvo.senha = alvo._senha;
            alvo.ID = alvo._ID;
        }
        let modalEdicao = document.querySelector("#formulario-edicao");
        modalEdicao.innerHTML= `
            <div class="container container-edicao">
                <h3 class="titulo_modal text-center text-primary">Formulário de edição</h3>
                <form id="edicao">
                <div class="form-group">
                <label class="font-weight-bold" for="exampleInputUsuario2">Nome de usuário</label>
                <input type="text" value="${alvo.usuario}" name="edicao_nome" class="form-control" id="edicaoUsuario">
            </div>
            <div class="form-group">
                <label class="font-weight-bold" for="exampleInputEmail2">Endereço de email</label>
                <input type="email" value="${alvo.email}" name="edicao_email" class="form-control" id="edicaoEmail" aria-describedby="emailHelp">
                <input type="hidden" value="${alvo.email}" name="edicao_email_ref">
                <input type="hidden" id="idUsuario" name="ID" value="${alvo.ID}">
            </div>
            <div class="form-group">
                <label class="font-weight-bold"for="exampleInputPassword2">Senha</label>
                <input type="text" minlength="5" maxlength="20" value="${alvo.senha}" name="edicao_senha" class="form-control" id="edicaoSenha">
            </div>
            <p class="text-danger font-weight-bold" id="mensagem-usuarios-modal"></p>
            <button type="submit" class="btnEdita btn btn-lg btn-primary">Editar</button>
            <button type="button" class="btnCancela btn btn-lg btn-default">Cancelar</button>
                </form>
            </div>`;
    
        modalEdicao.classList.add("mostrar-modal");
    
        $(".btnCancela").click(e=>{
            modalEdicao.classList.remove("mostrar-modal");
        });
    
        $("#edicao").submit(function(e){
            e.preventDefault();
            let form = $(this);
            if(AdmController.validaCampo($("#edicaoUsuario").val(),$("#edicaoEmail").val(),$("#edicaoSenha").val(),$("#mensagem-usuarios-modal"))){
                AdmController.alterarUsuario(form,alvoTrEdicao);
            }
        });
    }

    static mostraModalExclusao(alvo){
        let usuario = JSON.parse(alvo.dataset.usuario);

        if(!usuario.usuario){
            usuario.usuario = usuario._usuario;
            usuario.email = usuario._email;
            usuario.senha = usuario._senha;
            usuario.ID = usuario._ID;
        }
        let modalExclusao = document.querySelector("#modal-exclusao");
        modalExclusao.innerHTML = `
            <div class="container container-exclusao">
                <h3 class="titulo_modal text-center text-danger">Deseja realmente excluir este usuário?</h3>
                <form id="exclusao">
                <div class="form-group">
                <label class="font-weight-bold" for="exampleInputUsuario2">Nome de usuário</label>
                <p type="text" name="exclusao_nome" class="form-control" id="exclusaoUsuario">${usuario.usuario}</p>
            </div>
            <div class="form-group">
                <label class="font-weight-bold" for="exampleInputEmail2">Endereço de email</label>
                <p type="email" name="exclusao_email" class="form-control" id="exclusaoEmail" aria-describedby="emailHelp">${usuario.email}</p>
                <input type="hidden" name="ID" value="${usuario.ID}">
            </div>
            <p class="text-danger font-weight-bold" id="mensagem-usuarios-modal"></p>
            <button type="submit" class="btnExcluiUsuario btn btn-lg btn-danger">Excluir</button>
            <button type="button" class="btnCancelaExclusao btn btn-lg btn-default">Cancelar</button>
                </form>
            </div>
        `;
        modalExclusao.classList.add("mostrar-modal");
        $(".btnCancelaExclusao").click(e=> {
            e.preventDefault();
            modalExclusao.classList.remove("mostrar-modal");
        });
        $(".btnExcluiUsuario").click(e=>{
            e.preventDefault();
            AdmController.excluirUsuario(usuario,alvo);
            modalExclusao.classList.remove("mostrar-modal");
        });
    }

    static alterarUsuario(dados,alvoTrEdicao){
        let modal = document.querySelector("#formulario-edicao");
        $.ajax({
            type: "POST",
            data: dados.serialize(),
            url:"private/conexoes_php/editar_usuario.php",
            async: true
        }).then(data=>{
            $("#mensagem-usuarios-modal").html(data);
            if(!data){
                modal.classList.remove("mostrar-modal");
                let usuarioEdicao = AdmController.pegaDadosUsuarioDoFormulario($("#edicaoUsuario").val(),$("#edicaoEmail").val(),$("#edicaoSenha").val(),$("#idUsuario").val());
                AdmController.editarUsuarioVisualmente(usuarioEdicao,alvoTrEdicao);
            }
        },e=>{
            console.error("Erro na consulta ao banco de dados");
        });
    }

    static editarUsuarioVisualmente(usuarioEdicao,alvoTrEdicao){
        let th = alvoTrEdicao.querySelector("th");
        let td = alvoTrEdicao.querySelector("td");
        th.textContent = usuarioEdicao.usuario;
        td.textContent = usuarioEdicao.email;
        
        let usuario = usuarioEdicao.usuario;
        let email = usuarioEdicao.email;
        let senha = usuarioEdicao.senha;
        let ID = usuarioEdicao.ID;
    
        alvoTrEdicao.dataset.usuario = JSON.stringify({usuario,email,senha,ID});
    }

    static excluirUsuario(usuario,alvo) {
        $.ajax({
            type: "GET",
            data: usuario,
            url: "private/conexoes_php/excluir_usuario.php",
            async: true
        }).then(data=>{
            console.log(data);
            AdmController.removeUsuarioVisualmente(alvo);
        },e=>{
            console.error("erro");
        });
    }
    
    static removeUsuarioVisualmente(alvo){
        $(alvo).remove();
    }
}