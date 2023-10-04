//$(document).ready(function(){

    let nome = document.querySelector("#inputNome");
    let email = document.querySelector("#inputEmail");
    let senha = document.querySelector("#logPassword");
    let botao = document.querySelector("#botao_salvar");

    const alerta = document.querySelector("#alertBox");
    const alerta2 = document.querySelector("#alertBox2");


    //definindo as funções realizadas ao clicar no botão de editar
    botao.addEventListener("click", function(event){
        event.preventDefault();
        
        //verificando se os campos estão vazios
        if(nome.value ===""){
            alerta2.querySelector(".alert-message").innerHTML = "Digite o seu nome";
            document.getElementById("alertOverlay2").style.display = "flex";
            
            
        } else if(senha.value ===""){
            alerta2.querySelector(".alert-message").innerHTML = "Digite uma senha";
            document.getElementById("alertOverlay2").style.display = "flex";
             
        } else { //se não estiverem, :

            let dadosEdt = {
                ec: email.value,
                nc: nome.value
            };

            //fazendo uma requisição post para a edição dos dados 
            //no banco de dados 
            fetch('edt_usu.php', {
            method: 'POST',
            body: new URLSearchParams(dadosEdt)
            })
            .then(response => response.text())
            .then(edtUsu => {

                //retorna uma variavel
                if(edtUsu!=""){  //verifica se o retono é vazio
                    alerta2.querySelector(".alert-title").innerHTML = "";
                    alerta2.querySelector(".alert-message").innerHTML = edtUsu;
                    document.getElementById("alertOverlay2").style.display = "flex";
                           
                } else{
                    alerta2.querySelector(".alert-message").innerHTML = "Erro ao alterar";
                    document.getElementById("alertOverlay2").style.display = "flex";
                            
                }
            })
        }// fim do else de verificção de campo vazio
        }); //fim do click do botão de editar

        //define a função do cliclk do link sair
        document.getElementById("sair_link").addEventListener("click", function(evento) {
            evento.preventDefault();
    
            //manda mostrar a caixa de alerta
            document.getElementById("alertOverlay").style.display = "flex";
        });

        //define a função do botao de confirma do 1º alertOverlay
        document.getElementById("confirmButton").addEventListener("click", function(){
            document.getElementById("alertOverlay").style.display = "none"; // Esconde o overlay de alerta
            window.location.replace("login.html");
        })

        //define a função do botao de cancela do 1º alertOverlay
        document.getElementById("cancelButton").addEventListener("click", function() {
            document.getElementById("alertOverlay").style.display = "none"; // Esconde o overlay de alerta
        });

        //define a função do click do link de excluir
        document.getElementById("excluir_link").addEventListener("click", function(evento) {
            evento.preventDefault();
    
            document.getElementById("alertOverlay3").style.display = "flex";
        });

        //define a função do botao de cancela do 3º alertOverlay(usado no excluir)
        document.getElementById("cancelButton2").addEventListener("click", function(){
            document.getElementById("alertOverlay3").style.display = "none";
        })

        //define a funcao do botao de confirma do 3º alertOverlay(usado no excluir)
        document.getElementById("confirmButton2").addEventListener("click", function(){
            fetch('excluir_usu.php', {
                method: 'GET'
            })
            .then(response=>response.text())
            .then(ex_ret=>{
                if(ex_ret!=""){
                    document.getElementById("alertOverlay3").style.display = "none";
                    window.location.replace("login.html");
                } else{
                    alerta2.querySelector(".alert-message").innerHTML = "Erro ao excluir";                }
            })
                
            document.getElementById("alertOverlay3").style.display = "none";
        });

        //define a funcao do botao entendi do 2º alertOverlay(usado nos alertas do botao de editar)
        document.getElementById("entendiButton").addEventListener("click", function() {
            document.getElementById("alertOverlay2").style.display = "none"; // Esconde o overlay de alerta
        });
        

        

        

        senha.addEventListener("blur", function(){
            alert("campo senha saiu do foco");
        });

        
   // });