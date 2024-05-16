document.addEventListener('DOMContentLoaded', function () {
    const sizeInput = document.getElementById('size');
    const serviceSelect = document.getElementById('service');
    const additionalServiceCheckboxes = document.querySelectorAll('.additional-service');
    const resultSpan = document.getElementById('result');
    const resultTime = document.getElementById('timeresult');

    function calculatePrice() {
        const selectedService = serviceSelect.options[serviceSelect.selectedIndex];
        const servicePrice = parseFloat(selectedService.dataset.cost);
        const size = parseFloat(sizeInput.value);

        let totalPrice = size * servicePrice;
        additionalServiceCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const additionalServicePrice = parseFloat(checkbox.dataset.cost);
                totalPrice += additionalServicePrice;
            }
        });

        resultSpan.textContent = 'от ' + totalPrice + ' рублей';
    }

    function calculateTime() {
        const selectedService = serviceSelect.options[serviceSelect.selectedIndex];
        const serviceTime = parseFloat(selectedService.dataset.workTime);
        const size = parseFloat(sizeInput.value);

        let totalTime = (size * serviceTime) / 60;
        additionalServiceCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const additionalServiceTime = parseFloat(checkbox.dataset.workTime);
                totalTime += additionalServiceTime / 60;
            }
        });

        let timeText;
        switch (true) {
            case totalTime === 1:
                timeText = 'час';
                break;
            case totalTime >= 2 && totalTime <= 4:
                timeText = 'часа';
                break;
            default:
                timeText = 'часов';
                break;
        }

        resultTime.textContent = 'от ' + totalTime.toFixed(2) + ' ' + timeText;
    }

    sizeInput.addEventListener('input', calculatePrice);
    sizeInput.addEventListener('input', calculateTime);
    serviceSelect.addEventListener('change', calculatePrice);
    serviceSelect.addEventListener('change', calculateTime);
    additionalServiceCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', calculatePrice);
        checkbox.addEventListener('change', calculateTime);
    });

    calculatePrice();
    calculateTime();
});
