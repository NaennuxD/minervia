<script>
function generatePassword() {
  var chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJLMNOPQRSTUVWXYZ@#$%&";
  var passwordLength = 16;
  var password = "";

  for (var i = 0; i < passwordLength; i++) {
    var randomNumber = Math.floor(Math.random() * chars.length);
    password += chars.substring(randomNumber, randomNumber + 1);
  }
  document.getElementById('password').value = password
}
</script>