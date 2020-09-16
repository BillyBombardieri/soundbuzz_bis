<!-- ENTREZ EMAIL PUIS VALIDER AVEC BOUTTON SUPPRIMER AVEC POP UP -->


<?php 

    if(isset($_POST['supprimer']) && isset($mail)){
        $prepare -> $requete(DELETE FROM user WHERE email='$mail');
        $execute -> $requete();
    }

?>