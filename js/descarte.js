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
  var botao = document.getElementById("descarte");
  botao.classList.add("clicked");
  startCountdown(botao, 40000);
  isCountdownActive = true;
  api();
});

async function api() {
  console.log(userData.id);
  // Faz uma requisição GET para a API passando o ID do usuário na URL
  const response = await fetch(`/charlotte-app/api.js?id_usuario=${userData.id}`, {
    method: 'GET'
    })
  const data = await response.json();
  console.log({data})
}

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