function calculate() {
    var service = document.getElementById("service").value;
    var size = document.getElementById("size").value;
    var result = document.getElementById("result");

    if (service == 0 || size <= 0) {
        result.innerHTML = "Пожалуйста, выберите услугу и введите размер квартиры.";
    } else {
        var total = parseFloat(service) * parseFloat(size);
        result.innerHTML = "Стоимость уборки: $" + total.toFixed(2);
    }
}
