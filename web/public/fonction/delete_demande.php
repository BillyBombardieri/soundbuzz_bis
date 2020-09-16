<?php 
    require_once('../base/init.php');
    if ( !enLigne() ){ 
        header('location:../connexion.php');
        exit();
    } 
    $id=$_GET['id_demande'];
    $delete = $orange->exec(" DELETE FROM demande WHERE id_demande=$id");
    header("Location: view_demande.php");
?>