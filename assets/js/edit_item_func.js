// Отслеживаем ввод в поле new_item_name
var newItemNameInput = document.getElementById('new_item_name');
var inputLabel = document.querySelector('.input-label label');

newItemNameInput.addEventListener('input', function() {
    inputLabel.textContent = "New name: " + this.value;
});