class IndexController{
    constructor(){
        this.trocaDeHtmlVisualmnete();
        this.inserirCarroNobanco();
        this.mascaraPlaca();
        this.filtraTabela();
    }

    trocaDeHtmlVisualmnete(){
        let linkPrincipal = document.querySelector("#linkPrincipal");
        linkPrincipal.addEventListener("click", e=>{
            let adm = document.querySelector("#administracao-de-usuarios");
            let linkAdm = document.querySelector("#linkAdm");

            let principal = document.querySelector("#principal");
            adm.style.display = "none";
            linkAdm.classList.remove("active"); 

            principal.style.display = "block";
            linkPrincipal.classList.add("active"); 
        });
    }

    static adicionaCarroNaTabela(carro,tabela){
        let tr = document.createElement("tr");
        tr.dataset.carro = JSON.stringify(carro);
        tr.innerHTML = `
            <td scope="row">${carro.modelo.toUpperCase()}</td>
            <td class="placa">${carro.placa.toUpperCase()}</td>
            <td>${carro.hora}</td>
            <input type="hidden" value="${carro.carroID}">
            <td title="Botão para finalizar veículo">
                <button class="link text-white btn btn-danger finalizar text-center">Finalizar</button>
            </td>
        `;
        $(tabela).append(tr);
        
        $(".finalizar").click(function(e){
            let alvo = e.target.parentNode.parentNode;
            IndexController.mostraModal(alvo);
        });
    }

    static mostraModal(alvo){
        let modal = document.querySelector("#modal-index");
        let carro = JSON.parse(alvo.dataset.carro);

        // 'recupera' getters da classe carro
        if(!carro.modelo){
            carro.modelo = carro._modelo;
            carro.placa = carro._placa;
            carro.hora = carro._hora;
            carro.carroID = carro._carroID;
        }
        modal.classList.add("mostrar-modal");
        modal.innerHTML = `
            <div class="index-modal">
                <h3 class="titulo_modal text-center">Informações do carro</h3>
                
                <p>MODELO: </p>
                <p class="text-warning" id="modelo_modal">${carro.modelo}</p>
    
                <p>PLACA: </p>
                <p class="text-warning" id="placa_modal">${carro.placa}</p>
    
                <p>HORA: </p>
                <p class="text-warning" id="hora_modal">${carro.hora}</p>
                <input type="hidden" value="${carro.carroID}">
                <div class="calcular">
                    <label for="tempo">Fraçõe(s) usada(s):</label>
                    <input id="tempo"type="text"> <br>
                    <label for="valor_hora" >Valor fração:</label>
                    <input id="valor_hora" type="text"> <br>
                    <p id="calcular" class="btn btn-primary btn-lg btn-block">Calcular</p>
                </div>
                <div>
                    <p class="dinheiro text-success"></p>
                </div>
                <div class="botoes">
                    <button id="excluir-carro" class="excluir btn btn-danger">Excluir carro</button>
                    <button id="cancelar"class="cancelar btn btn-primary">Cancelar exclusão</button>
                </div>    
            </div>`;
        
    
        $("#calcular").click(function(e){
            let valorHora = $("#valor_hora").val();
            let tempo = $("#tempo").val();
    
            let valor = valorHora * tempo;
            $(".dinheiro").html(`R$: ${valor}`);
        });
    
        $(".cancelar").click(function(e){
            modal.classList.remove("mostrar-modal");
        });
    
        $("#excluir-carro").click(e=>{
            $.ajax({
                type: "GET",
                data: `carroID=${carro.carroID}`,
                url: "private/conexoes_php/excluir_carro.php",
                async: true
            }).then(e=>{
                $(alvo).remove();
                modal.classList.remove("mostrar-modal");
            });
        });
    }

    //parte da adição de veiculos
    inserirCarroNobanco(){
        $('#formulario').submit(e=>{
            e.preventDefault();
            let carro = this.pegaDadosDoFormulario();
            let form = `modelo_carro=${carro.modelo}&placa_carro=${carro.placa}&carroID=${carro.carroID}`;
            if(this.validarCampo() && this.validaPlacaCheckBox()){
                $("#mensagem").html("");
                this.inserirCarro(form,carro);
            }
        });
    }

    validarCampo(){
        var modelo = $("#modelo").val();
        var placa = $("#placa").val();
        if(modelo.length <= 0 || placa.length <= 0){
            $("#mensagem").html("Preencha todos os campos!");
            return false;
        }else{
            return true;
        }
    }

    validaPlacaCheckBox(){
        let campoPlaca = document.querySelector("#placa");
        let check = document.querySelector("#exampleCheck1");
        campoPlaca = campoPlaca.value;
    
        if(check.checked && campoPlaca.length === 7){
            return true;
        }else if(!check.checked && campoPlaca.length === 8){
            return true;
        }else{
            $("#mensagem").html("A placa deve conter no mínimo 7 caracteres");
            return false;
        }
    }
    
    mascaraPlaca(){
        let campoPlaca = document.querySelector("#placa");
        let check = document.querySelector("#exampleCheck1");

        //faz as alteracoes conforme o usuario digita
        campoPlaca.oninput = function (){
            let placa = campoPlaca.value;
            if(!check.checked){
                if(placa.length === 3){
                    campoPlaca.value += "-";
                    campoPlaca.setAttribute("maxlength", 8);
                    campoPlaca.setAttribute("minlength", 8);
                }
            }else{
                campoPlaca.value = placa.replace("-","");
                campoPlaca.setAttribute("maxlength", 7);
                campoPlaca.setAttribute("minlength", 7);
            }
        }

        //faz as alteracoes conforme muda o checkbox
        check.addEventListener("change", e=>{
            let placa = campoPlaca.value;
            if(!check.checked){
                if(placa.length >= 3){
                    let hifen = placa.substr(0,3)+"-"+placa.substr(3);
                    campoPlaca.value = hifen;
                }
                campoPlaca.setAttribute("maxlength", 8);
                campoPlaca.setAttribute("minlength", 8);

            }else{
                campoPlaca.value = placa.replace("-","");
                campoPlaca.setAttribute("maxlength", 7);
                campoPlaca.setAttribute("minlength", 7);
            }
        });
    }

    inserirCarro(dados,carro){
        $.ajax({
            type: "POST",
            data: dados,
            url:"private/conexoes_php/inserir_carro.php",
            async: true
        }).then(data=>{
            $("#mensagem").html(data);
            if(!data){    
                IndexController.adicionaCarroNaTabela(carro,$("#tabela"));
                $('#formulario')[0].reset();
            }
        }, e=>{
            console.error("Erro na consulta ao banco de dados");
        });
    }

    //pega dados inseridos no formulario
    pegaDadosDoFormulario(){
        let modelo = $("#modelo").val().toUpperCase();
        let placa = $("#placa").val().toUpperCase();
        let hora = new Date();
        hora = `${hora.getHours()}:${hora.getMinutes()}:00`;
    
        let carro = new Carro(modelo,placa,hora);
        return carro;
    }

    //realizando busca na tabela
    filtraTabela(){
        $("#buscar").keyup(function(e){
            let placas = document.querySelectorAll(".placa");
            let busca = $("#buscar").val().toUpperCase();
            placas.forEach(placa=>{
                let texto = placa.textContent;
                let regExp = new RegExp(busca, "i");
                if(!regExp.test(texto)){
                    placa.parentNode.style.display= "none";
                }else{
                    placa.parentNode.style.display= "table-row";
                }
            });
        });
    }
}