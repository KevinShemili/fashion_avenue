let nameField = document.getElementById("nameField");
let surnameField = document.getElementById("surnameField");
let emailField = document.getElementById("emailField");
let passField = document.getElementById("passField");

window.addEventListener("pageshow", () => {
  nameField.value = "";
  surnameField.value = "";
  emailField.value = "";
  passField = "";
});
