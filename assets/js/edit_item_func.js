// Отслеживаем ввод в поле new_item_name
var new_item_name_input = document.getElementById('new_item_name');
var input_label = document.querySelector('.input-label label');

new_item_name_input.addEventListener('input', function() {
    input_label.textContent = "New name: " + this.value;
});