<?php 
    require_once('../base/init.php');
    if ( !enLigne() ){ 
        header('location: ../connexion.php');
        exit();
    } 
    $date_cloture=date('Y-m-d H:i');
    $id=$_GET['id_demande'];
    $mail=$_GET['mail_user'];
    $change = $orange->exec(" UPDATE demande SET statut = 'Clôturé', date_cloture ='$date_cloture' WHERE id_demande=$id ");
    $subject="Demande Clôturé";
    $msg="Votre demande à été clôturé par $nom, $prenom";
    mail($mail, $subject, $msg);
    header("Location: gestion_demande.php");
?>