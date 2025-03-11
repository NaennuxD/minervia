<script>
var btnSubmit = $('.btn-submit');
var colSubmit = $('#col_btn_submit');
var regexValid = false;
var confirmValid = false;

$("#formAuthentication").submit(function(e){
  $(btnSubmit).attr('disabled', true)
  $(colSubmit).html('<div class="spinner-border text-light" role="status"></div>')
})

$('#password').on( "keyup", function(){
  validarSenha()
  validarConfirmaSenha()
})

$('#password-confirm').on( "keyup", function(){
  validarConfirmaSenha()
})

function validarSenha() {
  var senha = document.getElementById('password').value;

  if(senha.length == 0){
    return false
  }

  let divMaiuscula = $("#regex_maiuscula")
  let divMinuscula = $("#regex_minuscula")
  let divEspecial = $("#regex_especial")
  let divNumero = $("#regex_numero")

  var regexMaiuscula = /[A-Z]/;
  var regexMinuscula = /(?:.*[a-z]){6}/;
  var regexEspecial = /[^A-Za-z0-9]/;
  var regexNumero = /[0-9]/;

  if (!regexMaiuscula.test(senha)) {
    $(divMaiuscula).addClass('is-text-invalid')
  }else{
    $(divMaiuscula).removeClass('is-text-invalid').addClass('is-text-valid')
  }

  if (!regexMinuscula.test(senha)) {
    $(divMinuscula).addClass('is-text-invalid')
  }else{
    $(divMinuscula).removeClass('is-text-invalid').addClass('is-text-valid')
  }

  if (!regexEspecial.test(senha)) {
    $(divEspecial).addClass('is-text-invalid')
  }else{
    $(divEspecial).removeClass('is-text-invalid').addClass('is-text-valid')
  }

  if (!regexNumero.test(senha)) {
    $(divNumero).addClass('is-text-invalid')
  }else{
    $(divNumero).removeClass('is-text-invalid').addClass('is-text-valid')
  }

  if(regexMaiuscula.test(senha) && regexMinuscula.test(senha) && regexEspecial.test(senha) && regexNumero.test(senha)){
    regexValid = true;
  }else{
    regexValid = false;
  }

  toggleSubmit()
}

function validarConfirmaSenha(){
  var senha = document.getElementById('password').value;
  var senha_confirma = document.getElementById('password-confirm').value;

  if(senha_confirma.length == 0){
    return false
  }

  if(senha != senha_confirma){
    confirmValid = false
    $(".password-confirm-invalid").removeClass('d-none')
  }else{
    confirmValid = true
    $(".password-confirm-invalid").addClass('d-none')
  }

  toggleSubmit()
}

function toggleSubmit(){
  if(regexValid && confirmValid){
    $(btnSubmit).removeAttr('disabled')
  }else{
    $(btnSubmit).attr('disabled', true)
  }
}
</script>