<?php
    require_once('base/init.php');
    $verifAdmin = $_SESSION['utilisateur']['droit'];

    if ( !enLigne() ){ 

        header('location:connexion.php');
        exit();
    }

    if ($verifAdmin == 2 || $verifAdmin == 3) {
        //Recupere les données de la session de l'utilisateur
        $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur']; 
        $prenom = $_SESSION['utilisateur']['prenom']; 
        $nom = $_SESSION['utilisateur']['nom'];
        
        //Prepare la requete qui recupere tout les fournisseurs selon l'ID du l'utilisateur
        $prepare = $orange->prepare(" SELECT * FROM fournisseur WHERE id_utilisateur='$id_utilisateur' " );
        require_once('base/head.php')
    ?>
    <body>
        <?php require_once('base/navbar.php'); ?>
        <main>
            <?php
                //Execute la requete precedente
                $prepare->execute(); 
                $liste_fournisseurs = $prepare->fetchAll(PDO::FETCH_ASSOC);
            ?>
        </main>
        <section class="top">
            <div class="dropdown">
                <a href="accueil.php" class="dropdown"><button class="dropbtn">Retour</button></a><br><br><br>
                <a href="fonction/modifListe.php" class="dropdown"><button class="dropbtn">Modifier</button></a>
            </div>
            <br><br><br>
            <h1>Ma liste de <b>Fournisseurs</b></h1><br><br><br>
        </section>
        <section class="corps">
            <!-- Affiche la liste de fournisseur de l'utilisateur -->
            <?php foreach ($liste_fournisseurs as $fournisseur): ?>
                <div class="fournisseur">          
                    <?php 
                        if(!empty($fournisseur["id_fournisseur"])): 
                            $id_fournisseur = $fournisseur["id_fournisseur"];
                            $dossier = "logo/";
                            $ouverture = opendir($dossier);//Ouverture du dossier 
                            $image = readdir($ouverture);
                            echo '<a href="datacenter.php?id_fournisseur='.$id_fournisseur.'"><img src="'.$dossier.$fournisseur['logo'].'" title="'.$fournisseur['logo'].'" alt="" width="50%" height="auto"/></a>';
                            endif 
                    ?> 
                </div>
            <?php endforeach ?> 
        </section>
    </body>

<?php
} elseif ($verifAdmin == 1) { ?>
    <body class="noir">
        <div class="blanc">
            <a href="accueil.php" class="img"><img src="logo/logo-orange.png" alt=""></a>
            <p class="p_erreur"> Vous n'avez pas accès à ce contenu, veuillez cliquer sur l'image afin d'être redirigé</p>
        </div>
    </body> 
<?php } ?>

<style>
    .top h1 {
        margin: 0;
        text-align: center;
        color: black;
        font-size: 250%;
    }


    .top b {
        color: rgb(255,121,0);
    }

    .corps {
        display: grid;
        grid-template-columns: repeat(5,20%);
        justify-items: center;
        align-items: center;
    }

    .fournisseur a {
        text-decoration: none;
        text-align: center;
        min-height: 10em;
        display: table-cell;
        vertical-align: middle;
    }

    .dropbtn {
        background-color: rgb(255,121,0);
        color: white;
        padding: 13px;
        font-size: 13px;
        border: none;
        cursor: pointer;
        width: 17vh;
    }

    .dropdown {
        position: relative;
        display: inline-block;
        float: left;
        margin-top: 0.5vh;
        margin-left: 5px;
    }

    .noir {
        background : black;
    }

    .blanc {
        background : white;
        border: 10px solid rgb(255,121,0);
        margin-left: 25vh;
        margin-right: 25vh;
        margin-top : 10vh;
    }

    .img {
        text-align: center;
        display: block;
        margin-top: 5vh;
        margin-bottom: 6vh;
    }

    .p_erreur {
        text-align : center;
        font-size: 16px;

    }
</style>
<?php require_once('base/footer.php'); ?>