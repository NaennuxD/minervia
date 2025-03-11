<script>
  $("#cnpj").mask('99.999.999/9999-99')

  function switchError(value = null, isError = false){
    let btn = $("input[type=submit]")
    let error = $('.error')
  
    if(isError){
      $(btn).attr('disabled', '')
      $(error).removeClass('d-none').html(value)
    }else{
      $(error).addClass('d-none')
      $(btn).removeAttr('disabled')
    }
  }
  
  $("#cnpj").blur((e) => {
    let cnpj = e.target
    let value = cnpj.value
    value = value.replace(/\D/g,'')

    if(!value.length || value.length != 14){
      cnpj.classList.add('is-invalid')
      switchError('CNPJ inválido', true)
      return false
    }
   
    let razao_social = $('#company_name')
    let contato = $('#contact')
    let logradouro = $('#address')
    let cep = $('#cep')
    let numero = $('#number')
    let cidade = $('#city')
    let complemento = $('#complement')
    let uf = $('#state')
    let bairro = $('#neighborhood')
  
    $.ajax({
      url: 'https://brasilapi.com.br/api/cnpj/v1/' + value,
      type: "GET",
      dataType: 'json',
      data: {},
      success: (res) => {
        cnpj.classList.remove('is-invalid')
        cnpj.classList.add('is-valid')
  
        $(razao_social)
          .val(res.razao_social)
          .addClass('is-valid')
          .removeClass('is-invalid')
  
        $(contato)
          .val(res.ddd_telefone_1)
          .addClass('is-valid')
          .removeClass('is-invalid')
  
        $(logradouro)
          .val(res.logradouro)
          .addClass('is-valid')
          .removeClass('is-invalid')
  
        $(cep)
          .val(res.cep)
          .addClass('is-valid')
          .removeClass('is-invalid')
  
        $(numero)
          .val(res.numero)
          .addClass('is-valid')
          .removeClass('is-invalid')
  
        $(cidade)
          .val(res.municipio)
          .addClass('is-valid')
          .removeClass('is-invalid')
  
        $(complemento)
          .val(res.complemento)
          .addClass('is-valid')
          .removeClass('is-invalid')
  
        $(uf)
          .val(res.uf)
          .addClass('is-valid')
          .removeClass('is-invalid')
  
        $(bairro)
          .val(res.bairro)
          .addClass('is-valid')
          .removeClass('is-invalid')
  
        
        switchError('', false)
        
      },
      error: (res) => {
        cnpj.classList.add('is-invalid')
  
        $(razao_social)
          .val('')
          .addClass('is-invalid')
  
        $(contato)
          .val('')
          .addClass('is-invalid')
  
        $(logradouro)
          .val('')
          .addClass('is-invalid')
  
        $(cep)
          .val('')
          .addClass('is-invalid')
  
        $(numero)
          .val('')
          .addClass('is-invalid')
  
        $(cidade)
          .val('')
          .addClass('is-invalid')
  
        $(complemento)
          .val('')
          .addClass('is-invalid')
  
        $(uf)
          .val('')
          .addClass('is-invalid')
  
        $(bairro)
          .val('')
          .addClass('is-invalid')
  
        switchError(res.responseJSON.message, true)
        
      }
    })
  })
</script>

<script>
$('#logo').change(function() {
  let logo = $('.current-logo')
  let file = $(this)[0].files[0]

  if (file) {
    let name = file.name

    $(logo)
      .attr("src", URL.createObjectURL(file))
  }
});
</script>