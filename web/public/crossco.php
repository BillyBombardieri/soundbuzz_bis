<?php 
    require_once('base/init.php');
    if ( !enLigne() ){ 
        header('location:connexion.php');
        exit();
    } 
    //recupere tout les crossconnect
    $requete = $orange->prepare(" SELECT * FROM cross_connect "); 
    $requete->execute(); 
    $prestations = $requete->fetchAll(PDO::FETCH_ASSOC); 
    $admin = $_SESSION['utilisateur']['droit'];
?>
<?php if ($admin == 2 || $admin == 3) { 
    require_once('base/head.php');
    require_once('base/navbar.php');
    ?>
    <body>    
        <section class="top"> 
            <div class="dropbtn2">
                <a href="fonction/addCrossco.php?admin=<?php echo $admin;?>">Ajouter un Cross Connect</a>
            </div>
            <div class="dropdown2">
                <a href="accueil.php" class="dropdown"><button class="dropbtn3">Retour</button></a><br><br>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Fournisseur</button>
                <div class="dropdown-content">
                    <a href="fonction/telehouse.php"> Téléhouse</a>
                    <a href="fonction/equinix.php"> Equinix</a>
                </div>
            </div>
        </section>
            <form method="GET" class="formulaire">
                <label for="fournisseur">Numéro de Prestation :
                    <input class="input2" type="recherche" name="recherche" autocomplete="on">
                </label>
                <button>Afficher</button>
            </form>
            <!-- Fonction de recherche selon la valeur du Input -->
            <?php if(isset($_GET['recherche'])){
                    $ifNotId = $orange->prepare(" SELECT * FROM cross_connect WHERE num_prestation LIKE '".$_GET['recherche']."%' ORDER BY num_prestation ASC"); 
                    $ifNotId->execute();
                    $prestations = $ifNotId->fetchAll(PDO::FETCH_ASSOC); 
                }
            ?>
                <?php if(empty($ifNotId) && isset($_GET["recherche"]) ){ ?>
                    <h2 class="no_search">Aucun Fournisseur ne correspond à votre recherche</h2>
                <?php } ?>
            <section class ="middle">
                <div>
                    <h1>Liste des Cross Connects :</h1>
                    <br><br>
                </div>
            </section>
            <section class="corps">
                <table class= "dico">
                    <thead>
                        <tr>
                            <th>Numéro Prestation</th>
                            <th>Type Câble</th>
                            <th>Hébergeur Orange</th>
                            <th>Patch Panel Orange</th>
                            <th>Numéro Port Orange</th>
                            <th>Nom Client</th>
                            <th>Hébergeur Client</th>
                            <th>Patch Panel Client</th>
                            <th>Numéro Port Client</th>
                            <th>Numéro Série Cross Connect</th>
                            <?php if ($admin == 2 || $admin == 3) { ?>
                                <th>EDIT</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <?php foreach ($prestations as $presta): ?> 
                    <?php if(!empty($presta["num_prestation"])): ?>
                        <div class="contrat">
                                <?php
                                    $num_prestation = $presta["num_prestation"];
                                ?>
                                <tr>
                                    <td><?= $presta["num_prestation"] ?></td>
                                    <td><?= $presta["type_cable"] ?></td>
                                    <td><?= $presta["hebergeur_orange"] ?></td>
                                    <td><?= $presta["patch_panel_orange"] ?></td>
                                    <td><?= $presta["num_port_orange"] ?></td>
                                    <td><?= $presta["nom_client"] ?></td>
                                    <td><?= $presta["hebergeur_client"] ?></td>
                                    <td><?= $presta["patch_panel_client"] ?></td>
                                    <td><?= $presta["num_port_client"] ?></td>
                                    <td><?= $presta["num_serie_cross_connect"] ?></td>
                                    <?php endif; ?>
                                    <?php if ($admin == 2 || $admin ==3) { ?>
                                        <td><form method="post">
                                            <a href="fonction/editCrossco.php?num_prestation=<?php echo $num_prestation;?>"><img src="img/edit.png" alt="" width="22px" height="auto"></a>
                                        </form></td>
                                    <?php } ?>    
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
            </section>
        </body>
            <?php } elseif ($admin == 1) { ?>
                <body class="noir">
                    <div class="blanc">
                        <a href="accueil.php" class="img"><img src="logo/logo-orange.png" alt=""></a>
                        <p class="p_erreur"> Vous n'avez pas accès à ce contenu, veuillez cliquer sur l'image afin d'être redirigé</p>
                    </div>
                </body> 
            <?php } ?>
<style>
    .corps {
        margin-block-end: 3%;
    }

    input {
        text-decoration: none;
        color: rgb(255,121,0);
        border: none;
        width: 10vh;
        font-size: 150%;
        font-family: sans-serif;
        background-color: white;
        cursor : pointer;
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

    .top a {
        text-decoration: none;
        color: black;
    }

    .middle h1 {
        margin: 0;
        text-align: center;
        color: black;
        font-size: 250%;
    }

    .middle b {
        color: rgb(255,121,0);
    }

    .middle a {
        text-decoration: none;
        color: black;
    }

    .dico {
        border-collapse: collapse;
        width: 80%;
        margin:auto;
    }

    .dico td, .dico th {
        border: 1px solid black;
        padding: 8px;
    }

    .dico tr:nth-child(even){background-color: #f2f2f2;}

    .dico tr:hover {background-color: #ddd;}

    .dico th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: center;
        background-color: rgb(255,121,0);
        color: white;
    }

    table {
    border:3px solid black;
    }

    thead, tfoot {
        background-color:#D0E3FA;
        background-image:url(sky.jpg);
        border:1px solid #6495ed;
    }

    tbody {
        background-color:#FFFFFF;
        border:1px solid #6495ed;
    }

    th {
        font-family:monospace;
        border:1px dotted #6495ed;
        background-color:#EFF6FF;
        padding: 15px;
    }

    td {
        font-family:sans-serif;
        font-size:70%;
        border:1px solid #6495ed;
        padding:5px;
        text-align:center;
    }

    td a {
        font-size: 150%;
        text-decoration: none;
        color: rgb(255, 121, 0);
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
        margin-top: 10px;
        height: 6.5vh;
    }
     .dropbtn2 {
        background-color: rgb(255,121,0);
        color: white;
        padding: 13px;
        font-size: 15px;
        border: none;
        cursor: pointer;
        margin-bottom: 1vh;
        width : 17vh;
        float : right;
        margin : 10px;
        text-align: center;
    }

     .dropbtn2 a {
        color : white;
        text-decoration : none;
    }

    .dropbtn3 {
        background-color: rgb(255,121,0);
        color: white;
        padding: 13px;
        font-size: 15px;
        border: none;
        cursor: pointer;
        margin-bottom: 1vh;
        width : 17vh;
        float : left;
        margin : 10px;
        text-align: center;
    }

     .dropbtn3 a {
        color : white;
        text-decoration : none;
    }

    .dropdown2 {
        position: relative;
        display: inline-block;
        margin-top: 0.5vh;
        margin-left: 5px;
    }

    .dropdown {
    position: relative;
    display: inline-block;
    float: right;
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

    .formulaire {
        text-align : center;
        margin-bottom: 25px;
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
</style>
<?php require_once('base/footer.php');?>