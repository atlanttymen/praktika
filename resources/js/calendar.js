


//Content///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// JavaScript для модального окна
document.querySelectorAll('.calendar-day').forEach(day => {
    day.addEventListener('click', function(event) {
        // Предотвращаем всплытие события, чтобы не закрыть модальное окно сразу
        event.stopPropagation();

        const date = this.getAttribute('data-date'); // Получаем дату из атрибута
        const formattedDate = new Date(date); // Преобразуем в объект Date

        // Форматируем дату
        const year = formattedDate.getFullYear();
        const month = String(formattedDate.getMonth() + 1).padStart(2, '0'); // Месяцы начинаются с 0
        const dayOfMonth = String(formattedDate.getDate()).padStart(2, '0');

        // Устанавливаем время начала и окончания
        document.getElementById('start_time').value = `${year}-${month}-${dayOfMonth}T09:00`; // Время начала
        document.getElementById('end_time').value = `${year}-${month}-${dayOfMonth}T10:00`; // Время окончания
        
        // Получаем позицию элемента, на который кликнули
        const rect = this.getBoundingClientRect();
        
        // Устанавливаем позицию модального окна рядом с элементом
        const modal = document.getElementById('eventModal');
        modal.style.display = 'flex'; // Показываем модальное окно
        modal.style.top = `${rect.bottom + 2 + window.scrollY}px`; // Устанавливаем вертикальную позицию
        modal.style.left = `${rect.left + 20 + window.scrollX}px`; // Устанавливаем горизонтальную позицию
    });
});

// Закрываем модальное окно при нажатии на пустое пространство
document.addEventListener('click', function(event) {
    const modal = document.getElementById('eventModal');
    if (modal.style.display === 'flex') {
        modal.style.display = 'none'; // Закрываем модальное окно
    }
});

// Предотвращаем закрытие модального окна, если кликнули внутри него
document.getElementById('eventModal').addEventListener('click', function(event) {
    event.stopPropagation(); // Предотвращаем всплытие события
});

document.querySelectorAll('.calendar-day').forEach(day => {
    day.addEventListener('click', function() {
        const date = this.getAttribute('data-date');
        document.getElementById('start_time').value = date + 'T09:00'; // Установите время начала по умолчанию
        document.getElementById('end_time').value = date + 'T10:00'; // Установите время окончания по умолчанию
        document.getElementById('eventModal').style.display = 'block'; // Показываем модальное окно
    });
});

document.addEventListener('DOMContentLoaded', () => {
    function closeModal() {
        document.getElementById('eventModal').style.display = 'none'; // Закрываем модальное окно
    }
})