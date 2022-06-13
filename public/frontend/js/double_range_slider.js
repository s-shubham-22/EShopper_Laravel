var minPrice = document.querySelector('input[name="minPrice"]'),
    maxPrice = document.querySelector('input[name="maxPrice"]'),
    outputOne = document.querySelector('.outputOne'),
    outputTwo = document.querySelector('.outputTwo'),
    inclRange = document.querySelector('.incl-range'),
    updateView = function () {
        if (this.getAttribute('name') === 'minPrice') {
            outputOne.innerHTML = this.value;
            outputOne.style.left = this.value / this.getAttribute('max') * 100 + '%';
        } else {
            outputTwo.style.left = this.value / this.getAttribute('max') * 100 + '%';
            outputTwo.innerHTML = this.value
        }
        if (parseInt(minPrice.value) > parseInt(maxPrice.value)) {
            inclRange.style.width = (minPrice.value - maxPrice.value) / this.getAttribute('max') * 100 + '%';
            inclRange.style.left = maxPrice.value / this.getAttribute('max') * 100 + '%';
        } else {
            inclRange.style.width = (maxPrice.value - minPrice.value) / this.getAttribute('max') * 100 + '%';
            inclRange.style.left = minPrice.value / this.getAttribute('max') * 100 + '%';
        }
    };

document.addEventListener('DOMContentLoaded', function () {
    updateView.call(minPrice);
    updateView.call(maxPrice);
    $('input[type="range"]').on('mouseup', function () {
        this.blur();
    }).on('mousedown input', function () {
        updateView.call(this);
    });
});