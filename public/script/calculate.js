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
        function roundWorkTime(hours) {
            const floorHours = Math.floor(hours);
            const decimalPart = hours - floorHours;
            let result;

            if (decimalPart <= 0.01) {
                result = floorHours;
            } else if (decimalPart <= 0.25) {
                result = floorHours;
            } else if (decimalPart <= 0.5) {
                result = floorHours + ' часов 30 минут';
            } else {
                result = Math.ceil(hours);
            }

            if (typeof result === 'number') {
                result = result + ' ' + getCorrectHoursDeclension(result);
            }

            return result;
        }

        function getCorrectHoursDeclension(hours) {
            if (hours % 10 === 1 && hours % 100 !== 11) {
                return 'часа';
            } else if (hours % 10 >= 2 && hours % 10 <= 4 && (hours % 100 < 10 || hours % 100 >= 20)) {
                return 'часов';
            } else {
                return 'часов';
            }
        }

        resultTime.textContent = 'от ' + roundWorkTime(totalTime);
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
