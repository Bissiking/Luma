// Récupérer les éléments du DOM
var profileIcon = document.getElementById('profileIcon');
var profileMenu = document.getElementById('profileMenu');

// Ajouter un écouteur d'événement pour le clic sur l'icône de profil
profileIcon.addEventListener('click', function () {
    // Basculer la visibilité du menu
    profileMenu.style.display = (profileMenu.style.display === 'none' || profileMenu.style.display === '') ? 'block' : 'none';
});

document.addEventListener('click', function (event) {
    if (event.target !== profileMenu && event.target !== profileIcon && !profileMenu.contains(event.target)) {
        profileMenu.style.display = 'none';
    }
});

function formatReadableDate(dateString) {
    const date = new Date(dateString);
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const day = date.getDate().toString().padStart(2, '0');
    const hours = date.getHours().toString().padStart(2, '0');
    const minutes = date.getMinutes().toString().padStart(2, '0');
    const seconds = date.getSeconds().toString().padStart(2, '0');

    // Format final : "YYYY-MM-DD HH:mm:ss"
    const formattedDate = `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;

    return formattedDate;
}