const upass = document.getElementById("userPass");
const cpass = document.getElementById("confPass");

document.getElementById("userPassBtn").addEventListener("click", e => {
  console.log(e.target.value);
  if (upass.getAttribute("type") == password) {
    upass.setAttribute("type", "text");
  } else {
    upass.setAttribute("type", "password");
  }
});

document.getElementById("confPassBtn").addEventListener("click", e => {
  if (cpass.getAttribute("type") == password) {
    cpass.setAttribute("type", "text");
  } else {
    cpass.setAttribute("type", "password");
  }
});
