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
    botao.classList.add("clicked"); // Adiciona a classe "clicked" ao botão
    startCountdown(botao, 40000, userData.id); // Inicia o countdown 

    isCountdownActive = true; // Atualiza o estado do countdown
    // Faz uma requisição AJAX para enviar o ID do usuário para api.php
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "api.php", true);
    xhr.setRequestHeader("Content-Type", "application/json"); // Define o tipo de conteúdo como JSON
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Callback após a resposta da API (se necessário)
            console.log(xhr.responseText);
        }
    };

    // Envia o ID do usuário como parte do corpo da requisição em formato JSON
    var jsonData = JSON.stringify({ idUsuario: userData.id });
    xhr.send(jsonData);

    console.log(userData.id); // Verifica se userData.id está definido corretamente
    console.log('API request sent'); // Verifica se a requisição AJAX está sendo enviada
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