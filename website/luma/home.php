<?php
require_once('./lib/truncateText.php');
require('./base/nexus_base.php');
?>
<!-- <link rel="stylesheet" href="../css/home.css?0"> -->
<link rel="stylesheet" href="../css/home.css?1">
<script>
    document.title = "Accueil";
</script>

<section class="information">
    <div class="home">
        <h2>Qu'est-ce LUMA ?</h2>
        <div class="block-img-text block-left-img">
            <p>
                LUMA est un projet qui englobe d'autres projets et services. Les services comme (Plex, Nino, Serveur de jeux, ...).<br>
                LUMA peut vous permettrent (à terme), d'héberger votre propre plateforme vidéo chez vous. Pas besoin de mettre sur Youtube ou autres plateforme. D'autres services sont prévus mais ne verront peut-être jamais le jour.
            </p>
            <img src="/images/luma/luma300.png" alt="LUMA LOGO">
        </div>
        <h2>Pourquoi LUMA ? Son histoire et celle de Nino (Oui elles sont liés)</h2>
        <div class="block-img-text block-right-img">
            <p>
                J'avoue me poser cette question assez souvent. LUMA n'avait pas ce nom il y a 3 ans. LUMA se nommait Nina.<br>
                De base, Nina était un serveur. Mais je voulais un site associé à celui-ci pour gérer les servies proposé par celui-ci. Alors est née Nina.
                Ce projet avait pour but de faire la gestion des serveurs minecraft, superviser les containers docker (pour ceux qui connaissent) et m'avertir quand un service ne fonctionnait plus. Pas de bol, ceci a été mal calculer et géré et a été abandonné. L'année suivante l'échec de Nina, alors je décide de reprendre celle-ci, mais avec de nouvelles compétences acquises pendant l'année d'arrêt de développement.<br>
                <br>
                Suite à ceci, je décide de changer le nom en Nexus. Nina étant "morte" alors il fallait que le projet revienne en force avec certaines fonctionnalités attendues ... Je nomme Nino. Nino est, comme j'aime bien dire, mon YouTube maison. C'est ici que je mets toutes mes vidéos, car YouTube, c'est bien, mais les droits des musiques et toutes les restrictions, ça m'énerve. Sur Nino, je publie ce que je veux, pour qui je veux, sans aucun souci.<br>
                <br>
                Une fois Nino fonctionnelle, celle-ci a fonctionné pendant plusieurs mois jusqu'au drame. Nexus n'avait qu'une seule base de données (hors développement).<br>
                Ce qui devait arriver, arriva. La base de données de Nexus, c'est brisé, et a emporté avec elle 2 ans de travail. (note à moi-même, faire des sauvegardes). Par dépit et incompatibilité entre la base de données de développement et celle de production, je décide d'abandonner encore le projet, en laissant tous les services pour mort.<br>
                <br>
                Encore, 1 an plupart, je décide de reprendre le projet, mais cette fois-ci avec une aide, ChatGPT. ChatGPT est une IA, et elle m'aide dans le développement de LUMA. Oui !! LUMA !! Le nom LUMA a été choisi comme un petit souvenir personnel, et ce projet, c'est vu remonter assez rapidement, avec une toute nouvelle gestion de celui-ci. Je suis toujours tout seul sur ce projet, mais cela ne m'empêche pas de continuer d'ajouter des petites fonctionnalités ou autres sur le site, et des services qui peuvent être intéressantes pour certains
            </p>
            <img src="/images/luma/luma_bg_300.png" alt="LUMA LOGO">
        </div>
        <h2>Fonctionnalités gratuites et Whitelist de LUMA</h2>
        <div class="block-img-text block-left-img">
            <p>
                Actuellement, il y peut de fonctionnalités disponibles. Mais LUMA est en constante évolution. <br>
                - Plex (Netflix maison)<br>
                - Serveur de jeux<br>
                <br>
                Les services cité ci-dessus, sont des services dit sous Whitelist. Les accès sont restreints, au personnes proches.<br>
                <br>
                Nino est libre d'accès, mais par-contre ... Attention !! Celui-ci ne contient pas de filtre ou de blocage pour les moins de 18 ans. <br>
                Veuillez à éviter de laisser les enfants consulter le contenu de Nino car certaines vidéos pourrait avoir un humour un peu borderline ou les jeux non approprié. <br>
                <br>
                Un système de profils est dans la liste des chsoes de prévu, mais actuellement non prioritaire.
            </p>
            <img src="/images/luma/luma_bg_300.png" alt="LUMA LOGO">
        </div>
        <!-- FIN HOME -->
    </div>
</section>

<!-- SCRIPTS SRV -->
<script src="../javascripts/home.js?1"></script>