const sizeInput = document.getElementById('size');
const serviceSelect = document.getElementById('service');
const resultSpan = document.getElementById('result');
const resultTime = document.getElementById('timeresult');
sizeInput.addEventListener('input', calculatePrice);
sizeInput.addEventListener('input', calculateTime);

serviceSelect.addEventListener('change', calculatePrice);

function calculatePrice() {
    const selectedOption = serviceSelect.value.split('|');
    const servicePrice = parseFloat(selectedOption[0]);

    const size = sizeInput.value;
    const totalPrice = size * servicePrice;

    resultSpan.textContent = 'от ' + totalPrice + ' рублей';
}

function calculateTime() {
    const selectedOption = serviceSelect.value.split('|');
    const serviceTime = parseFloat(selectedOption[1]);

    const size = sizeInput.value;
    const time = (size * serviceTime)/60;

    let timeText;
    switch (true) {
        case time === 1:
            timeText = 'часа';
            break;
        case time === 1:
            timeText = 'часа';
            break;
        case time >= 2 && time <= 100:
            timeText = 'часов';
            break;
        default:
            timeText = 'часов';
            break;
    }

    resultTime.textContent = 'от ' + time + ' ' + timeText;
}

sizeInput.addEventListener('input', calculatePrice);
serviceSelect.addEventListener('change', calculatePrice);

calculatePrice();
calculateTime();
