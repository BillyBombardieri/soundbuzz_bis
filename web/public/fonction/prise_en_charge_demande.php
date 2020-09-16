<?php 
    require_once('../base/init.php');
    if ( !enLigne() ){ 
        header('location:../connexion.php');
        exit();
    } 
    $id=$_GET['id_demande'];
    $mail=$_GET['mail_user'];
    $nom=$_SESSION['utilisateur']['nom'];
    $prenom=$_SESSION['utilisateur']['prenom'];
    $change = $orange->exec(" UPDATE demande SET statut = 'Prise en charge par $nom $prenom' WHERE id_demande=$id");
    $subject="Validation prise en charge";
    $msg="Votre demande à été prise en charge par $nom, $prenom et sera traité dans les plus brefs délais";
    mail($mail, $subject, $msg);
    header("Location: gestion_demande.php");
?>