<?php 
    require_once('../base/init.php');

    if ( !enLigne() ){ 

        header('../location:connexion.php');
        exit();
    }
    
    $verifAdmin = $_SESSION['utilisateur']['droit'];
    if ($verifAdmin == 2 || $verifAdmin == 3) {

        $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur']; 
        $prenom = $_SESSION['utilisateur']['prenom']; 
        $nom = $_SESSION['utilisateur']['nom']; 
        $minefournisseurs=array();
        $notminefournisseurs=array();
    ?>
    <?php 

        //Enlever le fournisseur de la liste
        if( isset($_POST['enlever']) ) { 
            $enlever = $orange->exec(" UPDATE fournisseur SET id_utilisateur = NULL WHERE id_fournisseur='$_POST[id_fournisseurE]' ");
            $succes = '<div style="color:green;text-align:center;font-weight:bold;">Fourniseur enlevé de votre liste !</div>';
        }

        //Ajouter le fournisseur a la liste
        if( isset($_POST['ajouter']) ) { 
            $ajouter = $orange->exec(" UPDATE fournisseur SET id_utilisateur='$id_utilisateur' WHERE id_fournisseur='$_POST[id_fournisseurA]' ");
            $succes = '<div style="color:green;text-align:center;font-weight:bold;">Fournisseur ajouté à votre liste !</div>';
        }
    ?>

    <?php require_once('../base/head2.php') ?>
    <body>
        <?php require_once('../base/navbar2.php'); ?>
        <main>
            <!-- Fonction de recherche -->
            <?php 
                if(isset($_GET['recherche'])){
                    $mine = $orange->prepare(" SELECT * FROM fournisseur WHERE id_utilisateur='$id_utilisateur' AND nom_fournisseur LIKE '%".$_GET['recherche']."%'  "); 
                    $notmine = $orange->prepare(" SELECT * FROM fournisseur WHERE id_utilisateur IS NULL AND nom_fournisseur LIKE '%".$_GET['recherche']."%'  "); 
                    $mine->execute();
                    $notmine->execute(); 
                    $minefournisseurs = $mine->fetchAll(PDO::FETCH_ASSOC);
                    $notminefournisseurs = $notmine->fetchAll(PDO::FETCH_ASSOC); 
                }
            ?>
        </main>
        <section class="top">
            <div class="dropdown">
                <a href="../maListe.php" class="dropdown"><button class="dropbtn">Retour</button></a><br><br>
            </div>
            <h1>Modification de <b>Ma Liste</b></h1><br>
            <?php 
                if (isset($succes)){
                    echo $succes;
                } 
            ?>
            <br><br><br>
            <form method="GET" class="formulaire">

                <label for="fournisseur">Fournisseur :</label>
                <input type="recherche" name="recherche" autocomplete="on"><br><br>
                
                <button>Afficher</button>
            </form>
        </section>
        <br><br><br>
        <section class="corps">
            <!-- Recherche: aucun résultat -->
            <?php if( empty($notminefournisseurs) && empty($minefournisseurs) && isset($_GET["recherche"]) ): ?>
                <h2 class="no_search">Aucun DataCenter ne correspond à votre recherche, ou il appartient déjà à une autre liste.</h2>
            <?php endif ?> 
                <!-- Enlever -->
                <?php foreach ($minefournisseurs as $mine): ?>
                    <div class="fournisseur">          
                        <?php if(!empty($mine["id_fournisseur"])): ?>
                            <?php
                            $dossier = "../logo/";
                            $ouverture = opendir($dossier); 
                            $image = readdir($ouverture);
                            echo '<img src="'.$dossier.$mine['logo'].'" title="'.$mine['logo'].'" alt="" width="50%" height="auto"/>'; ?>
                            <br><br>
                            <form method="post" class="imgFour">
                                <input class="input2" type="hidden" name="id_fournisseurE" value="<?= $mine["id_fournisseur"] ?>">
                                <input class="input2" type="submit" name="enlever" value="Enlever">
                            </form>
                        <?php endif ?> 
                    </div>
                <?php endforeach ?> 

                <!-- Ajouter -->
                <?php foreach ($notminefournisseurs as $notmine): ?>
                    <div class="fournisseur">          
                        <?php if(!empty($notmine["id_fournisseur"])): ?>
                            <?php
                            $dossier = "../logo/";
                            $ouverture = opendir($dossier); 
                            $image = readdir($ouverture);
                            echo '<img src="'.$dossier.$notmine['logo'].'" title="'.$notmine['logo'].'" alt="" width="50%" height="auto"/>'; ?>
                            <br><br>
                            <form method="post" class="imgFour">
                                <input class="input2" type="hidden" name="id_fournisseurA" value="<?= $notmine["id_fournisseur"] ?>">
                                <input class="input2" type="submit" name="ajouter" value="Ajouter">
                            </form>
                        <?php endif ?> 
                    </div>
                <?php endforeach ?>
        </section>
        <br><br>

<?php
} elseif ($verifAdmin == 1) { ?>
    <body class="noir">
        <div class="blanc">
            <a href="../accueil.php" class="img"><img src="../logo/logo-orange.png" alt=""></a>
            <p class="p_erreur"> Vous n'avez pas accès à ce contenu, veuillez cliquer sur l'image afin d'être redirigé</p>
        </div>
    </body> 
<?php } ?>



<style>
    .top h1 {
        margin-top: 2%;
        text-align: center;
        font-size: 300%;
    }

    .top b {
        color: rgb(255,121,0);
    }

    .top p {
        text-align: center;
        font-size: 130%;
    }

    .formulaire {
        text-align: center;
        font-size: 150%;
    }

    .formulaire input {
        font-size: 50%;
        background-color : white;
        border-style: solid;
        border-color: rgb(255,121,0);
    }

    .top button {
        background-color: rgb(255,121,0);
        color: white;
        padding: 13px;
        font-size: 13px;
        border: none;
        cursor: pointer;
        margin-bottom: 1vh;
        width : 17vh;
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

    .fournisseur {
        text-align : center;
    }

    .corps {
        margin-block-end: 3%;
    }

    .input2 {
        background-color: rgb(255,121,0);
        color: white;
        padding: 13px;
        font-size: 13px;
        border: none;
        cursor: pointer;
        width: 10vh;
        margin-right : 30px;
        margin-top : 13px;
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

    form.imgFour {
        text-align : center;
        margin-left : 3vh;
    }

    .no_search {
        margin-left: 1%;
        font-size: 120%;
    }
    .dropbtn {
            background-color: rgb(255,121,0);
            color: white;
            padding: 13px;
            font-size: 13px;
            border: none;
            cursor: pointer;
            margin-bottom: 1vh;
            width : 17vh;
     }
    .dropdown {
        position: relative;
        display: inline-block;
        margin-top: 0.5vh;
        margin-left: 5px;
    }
</style>
<?php require_once('../base/footer.php'); ?>
