function showPopup(message, isSuccess) {
    var popup = document.getElementById('popup');
    var popupContent = document.getElementById('popup-content');
    var popupMessage = document.getElementById('popup-message');

    popupMessage.innerHTML = message;

    if (isSuccess) {
        popupContent.style.backgroundColor = '#4CAF50'; // Couleur de réussite
    } else {
        popupContent.style.backgroundColor = '#e44d26'; // Couleur d'erreur
    }

    popup.style.display = 'flex';
}

// Fonction pour fermer la popup
function closePopup() {
    document.getElementById('popup').style.display = 'none';
}