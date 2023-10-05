$(document).ready(function(){

let nome = document.querySelector("#nome_cad");
let email = document.querySelector("#email_cad");
let senha = document.querySelector("#senha_cad");
const alerta = document.querySelector("#alertBox");

    // Event listener para o botão "Entendi" no alerta
    document.getElementById("confirmButton").addEventListener("click", function() {
    document.getElementById("alertOverlay").style.display = "none"; // Esconde o overlay de alerta
    });

    $('#botaoCad').click(function(event){
    event.preventDefault();
    
    if(email.value === ""){
        alerta.querySelector(".alert-message").innerHTML = "Digite o seu email";
        document.getElementById("alertOverlay").style.display = "flex";
        
    } else if(nome.value ===""){
        alerta.querySelector(".alert-message").innerHTML = "Digite o seu nome";
        document.getElementById("alertOverlay").style.display = "flex";
        
    } else if(senha.value ===""){
        alerta.querySelector(".alert-message").innerHTML = "Digite a sua senha";
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
            ep: email.value
           };
    
           fetch('pesqUsuCad.php?'+ new URLSearchParams(dadosPesq), {
               method: 'GET'
           })
           .then(response=>response.text())
           .then(pesqUsu=>{
               if (pesqUsu.trim().length === 0) { // Verifica se pesqUsu está vazio
                let dadosCad = {
                  ec: email.value,
                  nc: nome.value,
                  sc: senha.value
                };
                fetch('cadastro_usuario.php', {
                    method: 'POST',
                    body: new URLSearchParams(dadosCad)
                  })
                  .then(response => response.text())
                  .then(cadUsu => {
                    if(cadUsu!=""){
                        window.location.replace("login.html");
                    } else{
                        alerta.querySelector(".alert-message").innerHTML = "Erro ao cadastrar";
                        document.getElementById("alertOverlay").style.display = "flex";
                       
                    }
                  })
              } else {
                alerta.querySelector(".alert-message").innerHTML = "Usuário já existe. Tente outro e-mail";
                document.getElementById("alertOverlay").style.display = "flex";
                
              }
           }) 
    
           
       } else{
            alerta.querySelector(".alert-message").innerHTML = "Email inválido. Exemplo de email válido: nome@email.com";
            document.getElementById("alertOverlay").style.display = "flex";
           
       }

    })

}// fim do else de verificção de campo vazio
    }) //fim do click

})