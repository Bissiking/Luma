### 6.0.0






## Features de la V6

- Structure NodeJS
- Gestion automatique de certaines fonctionnalités
- Lancement de Child séparé (Automatisation des alertes des agents)
- Système de réplicat pour le multisite
- Au lancement, si pas de configuration, affichage de la page de configuration

- Base de donnée SQL pour stocker des données interne au site (A voir si j'utilise pas un JSON)
- Regénération des base de donnée SQL de LUMA avec une nouvelle momenclature
- Utilisation d'une base de donnée MongoDB pour des systèmes plus strict

- Gestionnaire de fichier comme FMW ou autres
- Ajout de vidéo Nino, LUMA service

- Intégration de l'API de LUMA
- Intégration de l'API de Nino
- Intégration du player de Nino (Portage et fonctionnalité plus puissante)
    - Nino (Plateforme standard)
    - Cover (Espace dédié au cover)
    - Pubs (Espace dédié au PUB maison) || Accès très restreint, car les pub seront affichés au début des vidéos

- Page qui permet de programmé des actions interne de LUMA
    - Mise à jour automatique du site
    - Mise à jour des réplicats
    - Mise à jour des agents
    - Changement des miniatures (Si disponible)
    - Récupération des métadonnées des vidéos

- Nino, ajout d'une fonctionnalité permettant de faire plusieurs miniature




================

Les branches:
    - API
    - Nino
    - LUMA
    - Les agents de LUMA


API: API dédié à LUMA pour la gestion standard des différents services. Connexion, gestion des agents, ... (Base SQL)

Nino: L'application plus pousser que le player de Nino. Elle embarquerait l'ajout de vidéo et l'édition. Elle embarquerait aussi un transcodeur en ALPHA pour la diffusion des différentes vidéos.

[StreamVibe] Idée non exaustive - Module de Nino externe qui récupère un flux OBS ou autres et qui le retranscrit en flux vidéo standard

[PlayHub] Idée non exaustive - Pas encore de solution

[TalkNet] Idée non exaustive - Chat avec vidéo et audio assez fidèle


[V6 de LUMA]: Idée en reflexion. La V6 de LUMA va être exploser en plusieurs branche Git. Chaque branche va pouvoir géré sa parcelle de LUMA Hub