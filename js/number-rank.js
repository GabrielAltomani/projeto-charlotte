document.addEventListener("DOMContentLoaded", function() {
    const rankNumbers = document.querySelectorAll('.rank-number');
  
    rankNumbers.forEach((rankNumber, index) => {
      rankNumber.textContent = index + 1;
    });
  });
  