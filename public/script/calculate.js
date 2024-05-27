document.addEventListener('DOMContentLoaded', function () {
    const sizeInput = document.getElementById('size');
    const serviceSelect = document.getElementById('service');
    const resultSpan = document.getElementById('result');
    const resultTime = document.getElementById('timeresult');
    let additionalServiceCheckboxes;
    let totalTime = 0;

    function calculatePrice() {
        const selectedService = serviceSelect.options[serviceSelect.selectedIndex];
        const servicePrice = parseFloat(selectedService.dataset.cost);
        const size = parseFloat(sizeInput.value);

        let totalPrice = size * servicePrice;
        if (additionalServiceCheckboxes) {
            additionalServiceCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const additionalServicePrice = parseFloat(checkbox.dataset.cost);
                    console.log(checkbox.dataset.cost);
                    totalPrice += additionalServicePrice;
                }
            });
        }

        resultSpan.textContent = 'от ' + totalPrice + ' рублей';
    }

    function calculateTime() {
        totalTime = 0;

        const selectedService = serviceSelect.options[serviceSelect.selectedIndex];
        const serviceTime = parseFloat(selectedService.dataset.workTime);
        const size = parseFloat(sizeInput.value);

        totalTime = (size * serviceTime) / 60;

        console.log("Total time before additional services:", totalTime);

        if (additionalServiceCheckboxes) {
            additionalServiceCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const additionalServiceTime = parseFloat(checkbox.dataset.worktime);

                    totalTime += additionalServiceTime / 60;
                }
            });
        }

        displayTotalTime(totalTime);
    }

    function displayTotalTime(totalTime) {
        resultTime.textContent = 'от ' + roundWorkTime(totalTime);
    }

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

    function fetchAndDisplayAdditionalServices(serviceId) {
        fetch(`/api/services/${serviceId}/additional_services`)
            .then(response => response.json())
            .then(data => {
                const additionalServicesContainer = document.getElementById('additional-services-container');
                additionalServicesContainer.innerHTML = '';
                data.forEach(service => {
                    const div = document.createElement('div');
                    div.classList.add('form-check');
                    div.innerHTML = `
                        <input class="form-check-input additional-service" type="checkbox"
                            value="${service.id}" id="additionalservice${service.id}"
                            data-cost="${service.cost}"
                            data-worktime="${service.work_time}"
                            name="additionalservices[]">
                        <label class="form-check-label" for="additionalservice${service.id}">
                            ${service.titleadditionalservices} | ${service.cost} руб
                        </label>
                    `;
                    additionalServicesContainer.appendChild(div);
                });

                additionalServiceCheckboxes = document.querySelectorAll('.additional-service');
                additionalServiceCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', calculatePrice);
                    checkbox.addEventListener('change', calculateTime);
                });

                calculatePrice();
                calculateTime();
            });
    }

    sizeInput.addEventListener('input', calculatePrice);
    sizeInput.addEventListener('input', calculateTime);
    serviceSelect.addEventListener('change', function () {
        calculatePrice();
        calculateTime();
        fetchAndDisplayAdditionalServices(serviceSelect.value);
    });

    calculatePrice();
    calculateTime();
    fetchAndDisplayAdditionalServices(serviceSelect.value);
});




