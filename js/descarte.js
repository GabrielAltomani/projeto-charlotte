//Variável para rastrear se o countdown está ativo ou não
var isCountdownActive = false;

// Variável para armazenar o ID do timeout
var timeoutId;

// Event listener para o botão "Realizar Descarte"
document.getElementById("descarte").addEventListener("click", function() {
  var botao = document.getElementById("descarte");
  
  // Verifica se o countdown está ativo ou não
  if (isCountdownActive) {
    botao.innerHTML = "Realizar Descarte"; // Retorna o texto original ao botão
    botao.classList.remove("clicked"); // Remove a classe "clicked"
    clearTimeout(timeoutId); // Cancela o timeout ativo
  } else {
    document.getElementById("alertOverlay").style.display = "flex"; // Mostra o overlay de alerta
  }

  // Alterna o estado do countdown
  isCountdownActive = !isCountdownActive;
});

// Event listener para o botão "Cancelar" no alerta
document.getElementById("cancelButton").addEventListener("click", function() {
  document.getElementById("alertOverlay").style.display = "none"; // Esconde o overlay de alerta
});


// Event listener para o botão "Entendi" no alerta
document.getElementById("confirmButton").addEventListener("click", function() {
  document.getElementById("alertOverlay").style.display = "none"; // Esconde o overlay de alerta

  // Verifica se userData.id está definido e não é nulo ou vazio
  if (userData.id) {
      var botao = document.getElementById("descarte");
      botao.classList.add("clicked"); // Adiciona a classe "clicked" ao botão
      startCountdown(botao, 40000); // Inicia o countdown 

      isCountdownActive = true; // Atualiza o estado do countdown

      // Faz uma requisição AJAX para api.php enviando apenas o idUsuario
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "api.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // Define o tipo de conteúdo como formulário
      console.log("idUsuario a ser enviado: " + userData.id);

      // Crie uma string no formato 'chave=valor' para o envio do idUsuario
      var data = 'idUsuario=' + encodeURIComponent(userData.id);

      xhr.onreadystatechange = function() {
          if (xhr.readyState == 4) {
              if (xhr.status == 200) {
                  // Sucesso na requisição, você pode fazer algo com a resposta, se necessário
                  console.log(xhr.responseText);
              } else {
                  // Erro na requisição, exiba uma mensagem de erro ou trate conforme necessário
                  console.error("Erro na requisição AJAX: " + xhr.status);
              }
          }
      };

      // Envia a string de dados
      xhr.send(data);
  } else {
      console.log("ID do usuário não está definido corretamente.");
  }
});






// Função para iniciar o countdown
function startCountdown(button, duration, idUsuario) {
    var seconds = duration / 1000;
    function updateText() {
        if (seconds > 0 && isCountdownActive) {
            button.innerHTML = "Tempo para descarte: " + " (" + seconds + "s)";
            seconds--;
            timeoutId = setTimeout(updateText, 1000);
        } else {
            button.innerHTML = "Realizar Descarte";
            button.classList.remove("clicked");
        }
    }

    updateText();
}