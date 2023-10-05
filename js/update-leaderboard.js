function updateLeaderboard() {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "update_leaderboard.php", true);
  xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
          // Atualize o conteúdo do leaderboard com os dados recebidos
          var leaderboardContainer = document.querySelector(".leaderboard ol");
          var newLeaderboardContent = xhr.responseText;
          var currentLeaderboardContent = leaderboardContainer.innerHTML;

          // Se o conteúdo do leaderboard mudou, atualize e detecte as mudanças
          if (newLeaderboardContent !== currentLeaderboardContent) {
              leaderboardContainer.innerHTML = newLeaderboardContent;

              // Detecta mudanças no ranking aqui (o código anterior para detecção de mudanças)
              var rankNumbers = document.querySelectorAll('.rank-number');
              var previousScores = Array.from(rankNumbers).map(function(element) {
                  return parseInt(element.textContent);
              });

              setInterval(function() {
                  rankNumbers.forEach(function(item, index) {
                      var currentScore = parseInt(item.textContent);
                      if (currentScore < previousScores[index]) {
                          item.parentElement.classList.add('ranking-change');
                          setTimeout(function() {
                              item.parentElement.classList.remove('ranking-change');
                          }, 2000);
                      }
                      previousScores[index] = currentScore;
                  });
              }, 1000);
          }
      }
  };
  xhr.send();
}

// Chama a função de atualização a cada 5 segundos
setInterval(updateLeaderboard, 2000);
