function compte_a_rebours(date, text_Pref, text_Pref_after, attr)
{
    if (attr == "player"){
        var compte_a_rebours = document.getElementById("cr");
    }else{
        var compte_a_rebours = document.getElementById(attr);
    }

    var date_actuelle = new Date();
    var date_evenement = new Date(date);
    var total_secondes = (date_evenement - date_actuelle) / 1000;

    if (total_secondes > 0)
    {
        prefixe = text_Pref_after; // On modifie le préfixe si la différence est négatif
        total_secondes = Math.abs(total_secondes) + 30; // On ne garde que la valeur absolue
        var jours = Math.floor(total_secondes / (60 * 60 * 24));
        var heures = Math.floor((total_secondes - (jours * 60 * 60 * 24)) / (60 * 60));
        minutes = Math.floor((total_secondes - ((jours * 60 * 60 * 24 + heures * 60 * 60))) / 60);
        secondes = Math.floor(total_secondes - ((jours * 60 * 60 * 24 + heures * 60 * 60 + minutes * 60)));

        var et = "et";
        var mot_jour = "jours,";
        var mot_heure = "heures,";
        var mot_minute = "minutes,";
        var mot_seconde = "secondes";

        if (jours == 0)
        {
            jours = '';
            mot_jour = '';
        }
        else if (jours == 1)
        {
            mot_jour = "jour,";
        }

        if (heures == 0)
        {
            heures = '';
            mot_heure = '';
        }
        else if (heures == 1)
        {
            mot_heure = "heure,";
        }

        if (minutes == 0)
        {
            minutes = '';
            mot_minute = '';
        }
        else if (minutes == 1)
        {
            mot_minute = "minute,";
        }

        if (secondes == 0)
        {
            secondes = '';
            mot_seconde = '';
            et = '';
        }
        else if (secondes == 1)
        {
            mot_seconde = "seconde";
        }

        if (minutes == 0 && heures == 0 && jours == 0)
        {
            et = "";
        }


        if(jours != 0){
            compte_a_rebours.innerHTML = jours + " jours";
        } else if(heures != 0){
            compte_a_rebours.innerHTML = heures + " heures / "+secondes;
        }else if(minutes != 0){
            compte_a_rebours.innerHTML = minutes + " minutes";
        }else if(secondes != 0){
            compte_a_rebours.innerHTML = secondes + " secondes";
        }

    }
    else
    {
        compte_a_rebours.innerHTML = 'Encore un peu de patience';
    }
}