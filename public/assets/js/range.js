let notaRange = document.querySelector('#nota')
let notaSpan = document.querySelector('.nota')

notaRange.addEventListener("change", function(){
  notaSpan.innerHTML = this.value
})

notaRange.addEventListener("DOMContentLoaded", function(){
  notaSpan.innerHTML = this.value
})