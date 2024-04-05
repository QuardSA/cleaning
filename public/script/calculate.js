    const sizeInput = document.getElementById('size');
    const serviceSelect = document.getElementById('service');
    const resultSpan = document.getElementById('result');

    function calculatePrice() {
        const size = sizeInput.value;
        const servicePrice = serviceSelect.value;

        const totalPrice = size * servicePrice;

        resultSpan.textContent ='от ' + totalPrice + ' рублей';
    }

    sizeInput.addEventListener('input', calculatePrice);
    serviceSelect.addEventListener('change', calculatePrice);

    calculatePrice();
