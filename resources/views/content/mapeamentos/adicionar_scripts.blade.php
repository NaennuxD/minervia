<script>
  function openDropDown(origin){
    let destiny
    switch (origin) {
      case 'customer':
        destiny = 'customer-dropdown'
        break;
    
      default:
        break;
    }
    document.getElementById(destiny).classList.add("d-block");
  }

  function closeDropdown(origin){
    let destiny
    switch (origin) {
      case 'customer':
        destiny = 'customer-dropdown'
        break;
    
      default:
        break;
    }
    if($("#" + destiny).hasClass('d-block')){
      document.getElementById(destiny).classList.remove("d-block");
    }
  }

  function filterFunction(origin) {
    let destiny
    switch (origin) {
      case 'customer':
        destiny = 'customer-dropdown'
        break;
    
      default:
        break;
    }
    if(!$("#" + destiny).hasClass('d-block')){
      openDropDown(origin)
    }

    var input, filter, ul, li, a, i;
    input = document.getElementById("empresa");
    filter = input.value.toUpperCase();

    if(input.value.length === 0){
      closeDropdown(origin)
    }

    div = document.getElementById(destiny);
    a = div.getElementsByTagName("a");
    for (i = 0; i < a.length; i++) {
      txtValue = a[i].textContent || a[i].innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        a[i].style.display = "";
      } else {
        a[i].style.display = "none";
      }
      
      if(a[i].id == 'add_customer'){
        a[i].style.display = "";
      }
    }
  } 

  function swapValue(empresa_id, empresa){
    $("#empresa").val(empresa)
    $("#empresa_id").val(empresa_id)
    closeDropdown('customer')
  }
    
  $("document").ready(function(){
    let empresas = $("input[name='empresas']").val()
    empresas = JSON.parse(empresas)

    let url = new URL(window.location.href);
    let currentEnterprise

    if (url.searchParams.has('empresa_id')) {
      currentEnterprise = empresas.filter((e) => {
        return e.id == url.searchParams.get('empresa_id')
      })

      swapValue(currentEnterprise[0].id, currentEnterprise[0].company_name)
    }

    $("#customer-query").html('')
    $("#customer-query").append(`<a href="/empresa/adicionar?return_url=/mapeamento/adicionar" id="add_customer"><i class="bx bx-plus"></i> Adicionar novo</a>`)

    empresas.forEach((customer) => {
      $("#customer-query").append(`<a href="javascript:swapValue('${customer.id}', '${customer.company_name}')">${customer.company_name}</a>`) 
    })
  })
</script>