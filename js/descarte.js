var isClicked = false;
var timeoutId;

document.getElementById("descarte").addEventListener("click", function() {
  var botao = document.getElementById("descarte");

  if (isClicked) {
    // Reverter o botão ao estado original
    botao.innerHTML = "Realizar Descarte";
    botao.classList.remove("clicked");
    clearTimeout(timeoutId); // Cancelar o timeout ativo
  } else {
    // Mudar o botão para o estado "Descarte Realizado!" e iniciar o countdown
    botao.classList.add("clicked");
    startCountdown(botao, 10000); // Iniciar o countdown
  }

  isClicked = !isClicked; // Alternar o estado do botão
});

function startCountdown(button, duration) {
  var seconds = duration / 1000;

  function updateText() {
    if (seconds > 0) {
      // Atualizar o texto do botão para mostrar a contagem regressiva
      button.innerHTML = "Tempo para descarte: " + " (" + seconds + "s)";
      seconds--;
      timeoutId = setTimeout(updateText, 1000); // Atualizar a cada segundo
    } else {
      // Quando o countdown chega a zero, voltar ao estado normal do botão
      button.innerHTML = "Realizar Descarte";
      button.classList.remove("clicked");
    }
  }

  updateText(); // Iniciar a atualização do texto
}