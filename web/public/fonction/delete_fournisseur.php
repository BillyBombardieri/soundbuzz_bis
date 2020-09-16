<?php 
    require_once('../base/init.php');
    if ( !enLigne() ){ 
        header('location:../connexion.php');
        exit();
    }    
    $id_fournisseur=$_GET['id_fournisseur'];

    $delete = $orange->exec(" DELETE information FROM information, datacenter, fournisseur WHERE fournisseur.id_fournisseur=$id_fournisseur AND information.id_dc = datacenter.id_dc AND datacenter.id_fournisseur =  fournisseur.id_fournisseur");
    $delete = $orange->exec(" DELETE datacenter FROM datacenter, fournisseur WHERE fournisseur.id_fournisseur=$id_fournisseur AND datacenter.id_fournisseur=fournisseur.id_fournisseur");
    $delete = $orange->exec(" DELETE FROM fournisseur WHERE id_fournisseur=$id_fournisseur");
    header("Location: modifListFournisseur.php");
?>
                    