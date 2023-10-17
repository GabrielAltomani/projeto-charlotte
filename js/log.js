//$(document).ready(function(){

    const email = document.querySelector("#email_log");
    const senha = document.querySelector("#senha_log");
    const botao = document.querySelector("#botaoLog");
    const alerta = document.querySelector("#alertBox");
  
        // Event listener para o botão "Entendi" no alerta
        document.getElementById("confirmButton").addEventListener("click", function() {
        document.getElementById("alertOverlay").style.display = "none"; // Esconde o overlay de alerta
        });

        botao.addEventListener("click", function(event){
        event.preventDefault(); 

        if(email.value === ""){

            // Definir o texto do título e da mensagem
            alerta.querySelector(".alert-message").innerHTML = "Coloque seu email";
            document.getElementById("alertOverlay").style.display = "flex";
           
        } else if(senha.value ===""){

            alerta.querySelector(".alert-message").innerHTML = "Coloque sua senha";
            document.getElementById("alertOverlay").style.display = "flex";

        } else {
       
        let dados = {
            ec: email.value
        };
       
        fetch('validaEmail.php', {
            method: 'POST',
            body: new URLSearchParams(dados)
        })
        .then(response=>response.text())
        .then(retEmail=>{
           if(retEmail!=""){
    
               let dadosPesq = {
                ep: email.value,
                sc: senha.value
               };

               fetch('pesqUsu.php?'+new URLSearchParams(dadosPesq), {
                   method: 'GET'
               })
               .then(response=>response.text())
               .then(pesqUsu=>{
                   if(pesqUsu.trim().length === 0){

                       fetch('pesqAdm.php?'+ new URLSearchParams(dadosPesq), {
                           method: 'GET'
                       })
                       .then(response=>response.text())
                       .then(pesqAdm=>{
                           if(pesqAdm.trim().length === 0){
                               alerta.querySelector(".alert-message").innerHTML = "Usuário não encontrado";
                               document.getElementById("alertOverlay").style.display = "flex";
                               
                           } else {
                               window.location.replace("adm-ranking.php?id="+pesqAdm);
                           }
                       })
                   } else{
                        window.location.replace("home.php?id="+pesqUsu);
                   }

               })
               
           } else{
               alerta.querySelector(".alert-message").innerHTML = "Email inválido. Exemplo de email válido: nome@email.com";
               document.getElementById("alertOverlay").style.display = "flex"; 
               
           }
    
        })// fim do .then de validação de email
    
    }// fim do else de verificação de campos vazios
        }); //fim do click
    
   // });