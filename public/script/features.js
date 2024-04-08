function addfeatures() {
    let container = document.getElementById('featurescontainer');
    let maxFeatures = 4;
    let currentFeatures = container.querySelectorAll('.form-floating').length;

    if (currentFeatures < maxFeatures) {
        let newfeature = document.createElement('div');
        newfeature.className = 'form-floating';
        newfeature.innerHTML = container.querySelector('.form-floating').innerHTML;
        container.appendChild(newfeature);
    } else {
        alert('Достигнуто максимальное количество блоков');
    }
}
