<?php require_once('../base/init.php'); ?>
<?php 

    $verifAdmin = $_SESSION['utilisateur']['droit'];
    if ($verifAdmin == 2 || $verifAdmin == 3) {

        if ( !enLigne() ){ 

            header('location: ../connexion.php');
            exit();
        }
        $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];
        //Prepare une requete qui recupere tout les fournisseurs 
        $requete = $orange->prepare(" SELECT * FROM fournisseur ORDER BY nom_fournisseur ASC"); 
        $test=array();
        $valeur='';
    ?>
    <?php require_once('../base/head2.php') ?>
    <body>
        <?php require_once('../base/navbar2.php');?>
        <main>
            <?php
            //execute la requete prepare
            $requete->execute(); 
            $fournisseurs = $requete->fetchAll(PDO::FETCH_ASSOC);?>
        </main>
        <section class="top">
            <div class="dropbtn2">
                <a href="../accueil.php">Retour</a><br><br>
            </div>
            <div class="dropbtn">
                <a href="ajoutFournisseur.php">Ajouter Fournisseur </a>
            </div>
            <br><br><br><br><br>
            <h1>SUPPRIMER UN <b>FOURNISSEUR</b></h1><br>
            <form method="GET" class="formulaire">
                <label for="fournisseur">Fournisseur :
                    <input class="input2" type="recherche" name="recherche" autocomplete="on">
                </label>
                <button>Afficher</button>
            </form>
            <!-- Fonction de recherche selon la valeur du Input -->
            <?php if(isset($_GET['recherche'])){
                    $ifNotId = $orange->prepare(" SELECT * FROM fournisseur WHERE nom_fournisseur LIKE '".$_GET['recherche']."%' ORDER BY nom_fournisseur ASC"); 
                    $ifNotId->execute();
                    $fournisseurs = $ifNotId->fetchAll(PDO::FETCH_ASSOC); 
                }
            ?>
                <?php if(empty($ifNotId) && isset($_GET["recherche"]) ){ ?>
                    <h2 class="no_search">Aucun Fournisseur ne correspond à votre recherche</h2>
                <?php } ?>
            <br><br><br>    
        </section>

        <section class="corps">
            <?php foreach ($fournisseurs as $fournisseur): ?>
                <div class="fournisseur">          
                    <?php if(!empty($fournisseur["id_fournisseur"])): ?>
                        <?php $id_fournisseur = $fournisseur["id_fournisseur"] ?>
                            <?php
                            $dossier = "../logo/";
                            $ouverture = opendir($dossier);//ouverture du dossier 
                            $image = readdir($ouverture);
                            echo '<a href="../datacenter.php?id_fournisseur='.$id_fournisseur.'"><img src="'.$dossier.$fournisseur['logo'].'" title="'.$fournisseur['logo'].'" alt="" width="50%" height="auto"/></a>';
                            ?>
                            <form method="post" class="imgFour">
                            <a class="seconda" href="delete_fournisseur.php?id_fournisseur=<?php echo $id_fournisseur;?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce Fournisseur ? Cette action est irréversible et entraînera la suppression de Datacenters / codes Dico associés au fournisseur.')">Supprimer</a>
                            </form>
                    <?php endif ?> 
                </div>
            <?php endforeach;?>
        </section>
        <h4 class="info">Pour plus d'informations, cliquez sur l'un des fournisseurs</h4><br>  
    </body>

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

    .corps {
        margin-block-end: 3%;
    }

    .formulaire {
        text-align : center;
    }

    .fournisseur a.seconda {
        background-color: rgb(255,121,0);
        color: white;
        padding: 13px;
        font-size: 13px;
        border: none;
        cursor: pointer;
        width: 13vh;
        margin-right : 30px;
        margin-top : 13px;
    }

    input {
        background-color: rgb(255,121,0);
        color: white;
        padding: 13px;
        font-size: 13px;
        border: none;
        cursor: pointer;
        width: 13vh;
        margin-right : 30px;
        margin-top : 13px;
    }

    form.imgFour {
        text-align : center;
        margin-left : 6.5vh;
    }

    label {
        font-size: 22px;
    }

    button {
        font-size : 13px;
        color: white;
        background-color: rgb(255,121,0);
        width : 13vh;
        height : 5vh;
        border :none;
        cursor: pointer;
    }

    .no_search {
        margin-left: 1%;
        font-size: 120%;
    }

    input.input2 {
        color: black;
        padding: 13px;
        font-size: 13px;
        border: none;
        width: 10vh;
        margin-right : 15px;
        margin-top : 13px;
        background-color : white;
        border: 1px solid #ccc;
        border-radius: 4px;
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

    .top h1 {
        margin: 0;
        text-align: center;
        color: black;
        font-size: 250%;
    }

    .top b {
        color: rgb(255,121,0);
    }

    .top h2 {
        margin: 0;
        text-align: center;
        color: black;
    }

    .top a {
        position: relative;
        display: inline-block;
        text-align : center;
        text-decoration : none;
        color : white;
        font-size : 15px;
    }

    .corps {
        display: grid;
        grid-template-columns: repeat(6,16.5%);
        justify-items: center;
        align-items: center;
    }

    .fournisseur a {
        text-decoration: none;
        text-align: center;
        min-height: 10em;
        display: table-cell;
        vertical-align: middle;
        padding-bottom: 1vh;
    }

    .info {
        text-align:center;
    }

    .dropbtn {
    background-color: rgb(255,121,0);
    color: white;
    padding: 13px;
    font-size: 13px;
    border: none;
    cursor: pointer;
    width: 16vh;
    float : right;
    margin-right : 30px;
    margin-top : 13px;
    text-align : center;
    }

    .dropbtn2 {
    background-color: rgb(255,121,0);
    color: white;
    padding: 13px;
    font-size: 13px;
    border: none;
    cursor: pointer;
    width: 16vh;
    float : left;
    margin-left : 30px;
    margin-top : 13px;
    text-align : center;
    padding-bottom : unset;
    }

    .dropdown {
    position: relative;
    display: inline-block;
    float: right;
    margin-top: 1vh;
    margin-right: 10px;
    }

    .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 100px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    }

    .dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    }

    .dropdown-content a:hover {
        background-color: #ddd;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown:hover .dropbtn {
        background-color: rgb(255,100,0);
    }

    .dropDown {
    position: relative;
    display: inline-block;
    float: left;
    margin-top: 0.5vh;
    margin-left: 5px;
    }
</style>
<?php require_once('../base/footer.php');  ?>