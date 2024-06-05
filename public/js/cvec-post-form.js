var radios = document.querySelectorAll('input[name="resident_crous"]');
var residence = document.getElementById('div-logements');
var logementSelect = document.getElementById('residence');
var adresse = document.getElementById('adresse-div');
var adresseInput = document.getElementById('adresse');
var numChambre = document.getElementById('room-number-fields');
var roomNumber = document.getElementById('numero_chambre');
var codePostal = document.getElementById('code_postal');
var city = document.getElementById('ville');

residence.style.display = "none";
adresse.style.display = "none";
numChambre.style.display = "none";

radios.forEach(function(radio) {
    radio.addEventListener('change', function() {
        if (this.value === 'oui') {
            toggleElements([adresse], 'none');
            toggleElements([residence, numChambre], 'block');
            setRequiredAttributes([logementSelect, roomNumber], true);
            adresseInput.removeAttribute('required');
            document.getElementById('is_in_residence').value = true;

            clearFields([adresseInput, codePostal, city]);
        } else {
            toggleElements([residence, numChambre], 'none');
            toggleElements([adresse], 'block');
            setRequiredAttributes([logementSelect, roomNumber], false);
            adresseInput.setAttribute('required', 'required');
            document.getElementById('is_in_residence').value = false;

            clearFields([logementSelect, roomNumber]);
        }
    });
});

function toggleElements(elements, displayValue) {
    elements.forEach(function(element) {
        element.style.display = displayValue;
    });
}

function setRequiredAttributes(elements, isRequired) {
    elements.forEach(function(element) {
        if (isRequired) {
            element.setAttribute('required', 'required');
        } else {
            element.removeAttribute('required');
        }
    });
}

function clearFields(elements) {
    elements.forEach(function(element) {
        element.value = '';
    });
}

function disablePlaceholderOption() {
    var placeholderOption = document.querySelector('#residence option[value=""]');
    placeholderOption.disabled = true;
}
