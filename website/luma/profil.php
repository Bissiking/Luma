<?php
if (isset($_SESSION['authentification']['user'])) :
    $urlIcons = './images/icons/';
?>

    <link rel="stylesheet" href="css/profils.css?0">
    <div class="container">
        <form class="form-container" id="logoForm">
            <div class="profils-icons-preview">
                <img id="imgPreview-Profils" class="imgProfils" src="images/icons/<?= $_SESSION['authentification']['user']['iconsProfils'] ?>.png" alt="">
                <p><?= ($_SESSION['authentification']['user']['nomComplet'] != '') ? $_SESSION['authentification']['user']['nomComplet'] : "Pseudo: " . $_SESSION['authentification']['user']['identifiant']  ?></p>
            </div>

            <hr width="100%">

            <div class="profils-Icons-Choix">

                <label>
                    <input type="radio" name="image" value="1">
                    <img src="<?= $urlIcons.'1.png' ?>" alt="Icons 1">
                </label>

                <label>
                    <input type="radio" name="image" value="2">
                    <img src="<?= $urlIcons.'2.png' ?>" alt="Icons 2">
                </label>

                <label>
                    <input type="radio" name="image" value="3">
                    <img src="<?= $urlIcons.'3.png' ?>" alt="Icons 3">
                </label>

                <label>
                    <input type="radio" name="image" value="4">
                    <img src="<?= $urlIcons.'4.png' ?>" alt="Icons 4">
                </label>

                <label>
                    <input type="radio" name="image" value="5">
                    <img src="<?= $urlIcons.'5.png' ?>" alt="Icons 5">
                </label>

                <label>
                    <input type="radio" name="image" value="6">
                    <img src="<?= $urlIcons.'6.png' ?>" alt="Icons 6">
                </label>

                <label>
                    <input type="radio" name="image" value="7">
                    <img src="<?= $urlIcons.'7.png' ?>" alt="Icons 7">
                </label>

                <label>
                    <input type="radio" name="image" value="8">
                    <img src="<?= $urlIcons.'8.png' ?>" alt="Icons 8">
                </label>

                <label>
                    <input type="radio" name="image" value="9">
                    <img src="<?= $urlIcons.'9.png' ?>" alt="Icons 9">
                </label>
            </div>

        </form>
        <form class="form-container" id="profileForm">
            <div class="input-container">
                <input type="text" id="nomComplet" placeholder="" value="<?= ($_SESSION['authentification']['user']['nomComplet'] != '') ? $_SESSION['authentification']['user']['nomComplet'] : ''  ?>">
                <label for="nomComplet">Nom complet</label>
                <span class="underline"></span>
            </div>

            <div class="input-container">
                <input type="password" id="password" placeholder="">
                <label for="password">Nouveau mot de passe</label>
                <span class="underline"></span>
            </div>

            <div class="input-container">
                <input type="password" id="confirm-password" placeholder="">
                <label for="confirm-password">Confirmation du nouveau mot de passe</label>
                <span class="underline"></span>
            </div>

            <div class="input-container">
                <input type="email" id="email" placeholder="" value="<?= ($_SESSION['authentification']['user']['email'] != '') ? $_SESSION['authentification']['user']['email'] : ''  ?>">
                <label for="email">Email</label>
                <span class="underline"></span>
            </div>

            <div class="button-block">
                <button type="submit" class="custom-button">Enregistrer</button>
            </div>
        </form>
        <div id="message"></div>
    </div>
    <script src="javascripts/home/profils.js?0"></script>

<?php else : header('Location: /');
endif; ?>