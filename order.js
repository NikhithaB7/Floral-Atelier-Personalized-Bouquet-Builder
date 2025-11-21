function validateRegisterForm() {
  var pwd = document.forms["registerForm"]["password"].value;
  var cpwd = document.forms["registerForm"]["confirm_password"].value;
  if (pwd !== cpwd) {
    alert("Passwords do not match!");
    return false;
  }
  return true;
}

function validateOrderForm() {
  // Add quantity check, valid item selected etc.
  return true;
}