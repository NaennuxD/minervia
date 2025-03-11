<script type="text/javascript">
function handleEnter (field, event) {
  var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
  if (keyCode == 13) {
    var i;
    for (i = 0; i < field.form.elements.length; i++)
      if (field == field.form.elements[i]){
        break;
      }
    i = (i + 1) % field.form.elements.length;
    field.form.elements[i].focus();
    return false;
  }else{
    return true;
  }
}      
</script>

<script tyle="text/javascript">
  function toggleCheckboxes(value){
    $('input.'+value).prop('checked', function(index, checked) {
      return !checked;
    });
  }

  $('#modalImportMaps').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget)
    let width = button.data('width')
    let instruction = button.data('instruction')
    let modal = $(this)
    let checkboxes = modal.find('input[type=checkbox]')

    modal.find('.modal-dialog').addClass(width)

    $(checkboxes).prop("checked", false);
    $('.btn-import-selected').attr('disabled', true)
  })

  let checkboxes = $('#modalImportMaps').find('input[type=checkbox]')
  $(checkboxes).on('change', function(){
    if ($(this).is(':checked')){
      $('.btn-import-selected').removeAttr('disabled')
    }
  })

  $('#modalImportPoliticas').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget)
    let width = button.data('width')
    let instruction = button.data('instruction')
    let modal = $(this)
    let checkboxes = modal.find('input[type=checkbox]')

    modal.find('.modal-dialog').addClass(width)

    $(checkboxes).prop("checked", false);
    $('.btn-import-selected-pol').attr('disabled', true)
  })

  let checkboxesPol = $('#modalImportPoliticas').find('input[type=checkbox]')
  $(checkboxesPol).on('change', function(){
    if ($(this).is(':checked')){
      $('.btn-import-selected-pol').removeAttr('disabled')
    }
  })

  $('.btn-import-selected').on('click', function(e){
    let modal = $('#modalImportMaps')
    let checkboxes = modal.find('input[type=checkbox]')
    let checked = checkboxes.filter((key, value) => {
      return $(value).is(':checked')
    })

    if(checked.length === 0){
      alert('Escolha pelo menos uma opção')
      return
    }

    Object.values(checkboxes).forEach((value) => {
      if($(value).is(':checked') && $(value).hasClass('check_dados_pessoais_tratados')){
        let values = {
          valor: $(value).data('valor'),
          categoria: $(value).data('categoria'),
          crianca: $(value).data('crianca'),
          titular: $(value).data('titular'),
          volume: $(value).data('volume')
        };

        let count = clone('dados_pessoais_tratados', 'dados_pessoais_tratados-step-clone', 'dados_pessoais_tratados-step-clone-drop')
        setValue('dados_pessoais_tratados', count, values)
      }
    })

    modal.modal('toggle')
  })

  
  $('.btn-import-selected-pol').on('click', function(e){
    let modal = $('#modalImportPoliticas')
    let checkboxes = modal.find('input[type=checkbox]')
    let checked = checkboxes.filter((key, value) => {
      return $(value).is(':checked')
    })

    if(checked.length === 0){
      alert('Escolha pelo menos uma opção')
      return
    }

    Object.values(checkboxes).forEach((value) => {
      if($(value).is(':checked') && $(value).hasClass('check_medidas_de_seguranca')){
        let values = {
          valor: $(value).data('tema'),
        };

        let count = clone('medidas_de_seguranca', 'medidas_de_seguranca-step-clone', 'medidas_de_seguranca-step-clone-drop')
        setValue('medidas_de_seguranca', count, values)
      }
    })

    modal.modal('toggle')
  })

  $('#modalImportMaps').on('hidden.bs.modal', function (e) {
    $(this).modal('dispose')
  })

  $('#modalImportPoliticas').on('hidden.bs.modal', function (e) {
    $(this).modal('dispose')
  })

  const setValue = (slug, key, values) => {
    if(slug == 'dados_pessoais_tratados'){
      if($('input[name="map[' + slug + '][0][valor]"]').val() == ""){
        removeClone(slug, key)
        key = 0;
      }

      $('input[name="map[' + slug + '][' + key + '][valor]"]').val(values.valor)
      $('input[name="map[' + slug + '][' + key + '][subitems][categoria_do_dado]"]').val(values.categoria)
      $('input[name="map[' + slug + '][' + key + '][subitems][titular_do_dado]"]').val(values.titular)
      $('input[name="map[' + slug + '][' + key + '][subitems][volume_de_titulares]"]').val(values.volume)

      let radio = $('input[name="map[' + slug + '][' + key + '][subitems][dado_de_crianca_ou_adolescente]"]')

      radio.map((key, value) => {
        if($(value).val() == values.crianca){
          $(value).attr('checked', true)
        }
      })
    }else{
      if($('input[name="map[' + slug + '][0][valor]"]').val() == ""){
        removeClone(slug, key)
        key = 0;
      }

      $('input[name="map[' + slug + '][' + key + '][valor]"]').val(values.valor)
    }
  }

  const removeClone = (slug, key) => {
    if($('hr.hr-'+slug+'-number-'+key)){
      $('hr.hr-'+slug+'-number-'+key).remove()
    }

    $('div.clone-'+slug+'-number-'+key).remove()
  }

  const removeSubitemClone = (slug) => {
    $('div.clone-'+slug).remove()
  }

  let clonneds = [];
  let subitemsClonneds = [];

  @if(isset($mapeamento["dados"]))
    @foreach($mapeamento["dados"] as $key => $value)
      @for($m = 0; $m < count($value) - 1; $m++)
        clonneds.push('{{$key}}')
      @endfor
    @endforeach
  @endif

  @if(isset($mapeamento["dados"]))
    @foreach($mapeamento["dados"] as $values)
    
      @foreach($values as $value)
        @if(isset($value["subitems"]))
          @foreach($value["subitems"] as $key => $subitem)
            @for($m = 0; $m < count($value) - 1; $m++)
              @if(substr($key, -2, 1) == '_')
                subitemsClonneds.push('{{$key}}')
              @endif
            @endfor
          @endforeach
        @endif
      @endforeach
    @endforeach
  @endif


  const clone = (slug, from, to) => {

    clonneds.push(slug);
    let count = clonneds.filter((v) => (v === slug)).length;
    let customCount =  Math.floor(Math.random() * (1000 - 1))

    $("." + to).append('<hr class="hr-'+ slug +'-number-'+ customCount +'">')
    let clone = $("." + from).first().clone()
    let inputs = clone.find('input')
    let selects = clone.find('select')
    let labels = clone.find('label')

    let drops = clone.find('.step-clone-drop')
    let classDrops = drops.attr('class')
    let newClassDrops = classDrops + '_' + customCount
    drops.attr('class', newClassDrops)
    drops.html("")

    let suggests = clone.find('#' + slug + '_suggestions')
    let currentSuggestsId = $(suggests).attr('id')
    let newSuggestsId = currentSuggestsId + '_' + customCount
    $(suggests).attr('id', newSuggestsId)

    let suggetsSubItem = suggests.prevObject.find('.suggestions.subitem')

    suggetsSubItem.map((index, value) => {
      let currentSuggestsIdsSubItem = $(value).attr('id')
      let newSuggestsIdsSubItem = currentSuggestsIdsSubItem + '_' + customCount
      $(value).attr('id', newSuggestsIdsSubItem)
    })

    let btn = clone.find('.btnCloneSubItem')
    if(btn.length > 0){
      let btnOnClick = $(btn).attr('onClick')
      let newBtnOnClick = btnOnClick.replace("')", "_" + customCount + "', '"+ customCount +"')")
      $(btn).attr('onClick', newBtnOnClick)
    }

    let stepClone = clone.find('.step-clone')
    let classStepClone = stepClone.attr('class')
    let newClassStepClone = classStepClone + '_' + customCount
    stepClone.attr('class', newClassStepClone)

    $(labels).each(function (index, value){
      let lfor = $(value).attr('for')

      if(!lfor){
        return
      }

      let number = lfor.substr(-1)
      number = Number(number)

      if(isNaN(number)){
        return
      }

      let newNumber = number + customCount
      let newFor = lfor.replace('_' + number, '_' + newNumber)

      $(value).attr('for', newFor).val("")
    })

    $(inputs).each(function (index, value){

      // $(value).removeAttr('checked')
      let name = $(value).attr('name')
      let type = $(value).attr('type')
      let newName = name.replace('[0]', '[' + customCount + ']')

      let id = $(value).attr('id')
      let number = id.substr(-1)
      let newNumber = Number(number) + customCount
      let newId = id.replace('_' + number, '_' + newNumber)

      $(value).attr('name', newName)
      $(value).attr('id', newId)

      let currentSuggests = $(value).attr('data-suggests')
      let newSuggests = currentSuggests + '_' + customCount
      $(value).attr('data-suggests', newSuggests)

      if(type == 'text'){
        $(value).val("").attr('data-id', customCount)
      }
    })

    $(selects).each(function (index, value){
      let name = $(value).attr('name')
      let newName = name.replace('[0]', '[' + customCount + ']')

      $(value).attr('name', newName).val("").attr('data-id', customCount)
    })
    
    $(clone).find('h5').html(`<h5 class="mb-4 d-flex">Preencha os campos abaixo:<img src="{{asset('assets/img/delete.png')}}" alt="Excluir" class="rounded-circle ms-2 cursor-pointer" onclick="removeClone('${slug}',${customCount})" style="width: 20px"></h5>`)
    clone.appendTo("." + to).addClass('clone-'+ slug +'-number-' + customCount)

    $("." + to + " ." + from).removeClass(from)

    return customCount
  }

  const cloneSubitem = (slug, from, to, toIndex = 0) => {
    let count, number, newNumber, newLast
    
    if(subitemsClonneds.length == 0){
      newNumber = Math.floor(Math.random() * (1000 - 1))
      count = newNumber
      number = 0
      // newNumber = Number(number) + 1
      newLast = slug + '_' + newNumber
    }else{
      let last = subitemsClonneds.at(-1)
      number = last.substr(-1)
      // newNumber = Number(number) + 1
      newNumber = Math.floor(Math.random() * (1000 - 1))
      newLast = last.replace('_' + number, '_' + newNumber)
      count = newNumber
    }

    subitemsClonneds.push(newLast);

    let clone = $("." + from).first().clone()
    let inputs = clone.find('input')
    let selects = clone.find('select')
    let suggests = clone.find('#' + slug + '_suggestions')

    let currentSuggestsId = $(suggests).attr('id')
    let newSuggestsId = currentSuggestsId + '_' + count
    $(suggests).attr('id', newSuggestsId)

    $(inputs).each(function (index, value){
      let name = $(value).attr('name')
      let newName = name.replace('[' + slug + ']', '[' + slug + '_' + count + ']')
      
      if(toIndex != 0){
        newName = newName.replace('[0]', '['+toIndex+']')
      }

      $(value).attr('name', newName).val("").attr('data-id', count)

      let currentSuggests = $(value).attr('data-suggests')
      let newSuggests = currentSuggests + '_' + count
      $(value).attr('data-suggests', newSuggests)
    })

    $(selects).each(function (index, value){
      let name = $(value).attr('name')
      let newName = name.replace('[' + slug + ']', '[' + slug + '_' + count + ']')

      $(value).attr('name', newName).val("").attr('data-id', count)
    })
    
    $(clone).find('label').append(`<img src="{{asset('assets/img/delete.png')}}" alt="Excluir" class="rounded-circle ms-2 cursor-pointer" onclick="removeSubitemClone('${slug}_${count}')" style="width: 20px" />`)
    clone.appendTo("." + to).addClass('clone-'+ slug + '_' + count)

    $("." + to + " ." + from).removeClass(from)

    return count
  }
 
  var mutationObserver = new MutationObserver(function(mutations) {
    mutations.forEach(function(){
      const element = document.querySelectorAll('.step.active')[0]
      const categories = document.getElementById('bs-stepper-header')

      if(categories instanceof HTMLElement && element instanceof HTMLElement){
        categories.scroll({top: 0, left: element.offsetLeft - 530, behavior: 'smooth' })
      }
    });
  });

  const all = document.querySelector('.step')

  if(all){
    mutationObserver.observe(all, {
      attributes: true,
      subtree: true,
      childList: true
    });
  }

  var stepper = new Stepper(document.querySelector("#stepper"));
  setCurrent();

  function next() {
    stepper.next();
    setCurrent();
  }

  function previous() {
    stepper.previous();
    setCurrent();
  }

  function jumpTo(step) {
    stepper.to(step + 1)
    setCurrent()
  }

  function setCurrent() {
    document.getElementById("current-step").innerText = stepper._currentIndex + 1;

    let currentIndex = stepper._currentIndex
    let currentContent = stepper._stepsContents[currentIndex]
    let input = $(currentContent).find('input').first().focus()
  }

  $("#stepper")[0].addEventListener('shown.bs-stepper', function (event) {

  });

  const slider = document.querySelector('.bs-stepper-header');
  let isDown = false;
  let startX;
  let scrollLeft;

  slider.addEventListener('mousedown', (e) => {
    isDown = true;
    startX = e.pageX - slider.offsetLeft;
    scrollLeft = slider.scrollLeft;
  });
  slider.addEventListener('mouseleave', () => {
    isDown = false;
  });
  slider.addEventListener('mouseup', () => {
    isDown = false;
  });
  slider.addEventListener('mousemove', (e) => {
    if(!isDown) return;
    e.preventDefault();
    const x = e.pageX - slider.offsetLeft;
    const walk = (x - startX) * 3;
    slider.scrollLeft = scrollLeft - walk;
  });
</script>