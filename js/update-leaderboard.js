function updateLeaderboard() {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "update_leaderboard.php", true);
  xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
          // Atualize o conteúdo do leaderboard com os dados recebidos
          var leaderboardContainer = document.querySelector(".leaderboard ol");
          leaderboardContainer.innerHTML = xhr.responseText;
      }
  };
  xhr.send();
}

// Chama a função de atualização a cada 5 segundos
setInterval(updateLeaderboard, 5000); 