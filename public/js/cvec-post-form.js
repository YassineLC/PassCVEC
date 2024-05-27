var radios = document.querySelectorAll('input[name="resident_crous"]');
var residence = document.getElementById('div-logements');
var logementSelect = document.getElementById('residence');

residence.style.display = "none";

radios.forEach(function(radio) {
    radio.addEventListener('change', function() {
        if (this.value === 'oui') {
            residence.style.display = 'block';
            logementSelect.required = true;
            document.getElementById('is_in_residence').value = true;
        } else {
            residence.style.display = 'none';
            logementSelect.required = false;
            document.getElementById('is_in_residence').value = false;
        }
    });
});

function disablePlaceholderOption() {
    var placeholderOption = document.querySelector('#residence option[value=""]');
    placeholderOption.disabled = true;
}
