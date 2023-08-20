function myLogPass() {
  var a = document.getElementById('logPassword');
  var b = document.getElementById('aye');
  var c = document.getElementById('aye-slash');

  if (a.type === "password") {
    a.type = "text"
    b.style.opacity = "0";
    c.style.opacity = "1";
  } else {
    a.type = "password";
    b.style.opacity = "1";
    c.style.opacity = "0";
  }
}