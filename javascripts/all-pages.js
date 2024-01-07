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