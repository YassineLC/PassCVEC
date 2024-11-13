document.addEventListener('DOMContentLoaded', function() {
    // Récupération des éléments
    const radios = document.querySelectorAll('input[name="resident_crous"]');
    const residence = document.getElementById('div-logements');
    const numChambre = document.getElementById('room-number-fields');
    const adresseInput = document.getElementById('adresse');
    const addressFields = document.getElementById('address-fields');

    // Fonction pour cacher tous les champs au départ
    function hideAllFields() {
        if (residence) residence.style.display = 'none';
        if (numChambre) numChambre.style.display = 'none';
        if (adresseInput) adresseInput.parentElement.style.display = 'none';
        if (addressFields) addressFields.style.display = 'none';
    }

    // Cacher tous les champs au chargement
    hideAllFields();

    // Ajouter les écouteurs d'événements aux boutons radio
    radios.forEach(function(radio) {
        radio.addEventListener('change', function() {
            hideAllFields(); // Cacher tous les champs d'abord

            if (this.value === 'oui') {
                // Afficher les champs pour résident Crous
                if (residence) residence.style.display = 'block';
                if (numChambre) numChambre.style.display = 'block';
                // Mettre à jour les attributs required
                if (document.getElementById('residence')) {
                    document.getElementById('residence').setAttribute('required', 'required');
                }
                if (document.getElementById('numero_chambre')) {
                    document.getElementById('numero_chambre').setAttribute('required', 'required');
                }
                // Définir is_in_residence à true
                if (document.getElementById('is_in_residence')) {
                    document.getElementById('is_in_residence').value = 'true';
                }
            } else if (this.value === 'non') {
                // Afficher les champs pour non-résident
                if (adresseInput) adresseInput.parentElement.style.display = 'block';
                if (addressFields) addressFields.style.display = 'block';
                // Mettre à jour les attributs required
                if (adresseInput) adresseInput.setAttribute('required', 'required');
                if (document.getElementById('code_postal')) {
                    document.getElementById('code_postal').setAttribute('required', 'required');
                }
                if (document.getElementById('ville')) {
                    document.getElementById('ville').setAttribute('required', 'required');
                }
                // Définir is_in_residence à false
                if (document.getElementById('is_in_residence')) {
                    document.getElementById('is_in_residence').value = 'false';
                }
            }
        });
    });
});

function disablePlaceholderOption() {
    const select = document.getElementById('residence');
    const placeholderOption = select ? select.querySelector('option[disabled]') : null;
    if (placeholderOption) {
        placeholderOption.disabled = true;
    }
}
