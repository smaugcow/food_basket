// Получаем все чекбоксы с классом "toggle-checkbox"
var checkboxes = document.querySelectorAll('.toggle-checkbox');

// Добавляем обработчик события для каждого чекбокса
checkboxes.forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
        // Получаем ID товара из атрибута "data-id"
        var itemId = this.getAttribute('data-id');

        // Получаем соответствующую строку в таблице
        var row = this.closest('tr');

        // Если чекбокс отмечен, изменяем цвет строки на зеленый, иначе возвращаем обычный цвет
        if (this.checked) {
            row.style.backgroundColor = '#04d4bf';
            row.style.color = 'white';
        } else {
            row.style.backgroundColor = '';
            row.style.color = '';
        }
    });
});