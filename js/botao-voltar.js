// Seleciona a âncora do botão
const botaoVoltar = document.getElementById("botaoVoltar");

// Adiciona um ouvinte de evento de clique à âncora
botaoVoltar.addEventListener("click", function(event) {
    event.preventDefault(); // Evita que o link recarregue a página
    window.history.back();   // Volta para a página anterior
    animatePageBack();
});

function animatePageBack() {
    document.body.classList.add("fade-out"); // Adiciona a classe para ativar a animação
    setTimeout(() => {
        window.history.back();
    }, 500); // Aguarda 500ms antes de voltar à página anterior
}