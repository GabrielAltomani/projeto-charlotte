// Variável para rastrear se o countdown está ativo ou não
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

  var botao = document.getElementById("descarte");
  botao.classList.add("clicked"); // Adiciona a classe "clicked" ao botão
  startCountdown(botao, 10000); // Inicia o countdown com duração de 10000 milissegundos (10 segundos)

  isCountdownActive = true; // Atualiza o estado do countdown
});

// Função para iniciar o countdown
function startCountdown(button, duration) {
  var seconds = duration / 1000;

  // Função para atualizar o texto do botão com a contagem regressiva
  function updateText() {
    if (seconds > 0) {
      button.innerHTML = "Tempo para descarte: " + " (" + seconds + "s)";
      seconds--;
      timeoutId = setTimeout(updateText, 1000); // Atualiza a cada segundo
    } else {
      // Quando o countdown chega a zero, retorna o botão ao estado original
      button.innerHTML = "Realizar Descarte";
      button.classList.remove("clicked");
    }
  }

  updateText(); // Inicia a atualização do texto
}
