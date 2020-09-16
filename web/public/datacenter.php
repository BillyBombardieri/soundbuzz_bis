<?php require_once('base/init.php'); ?>
<?php 
    if ( !enLigne() ){ 

        header('location:connexion.php');
        exit();
    }
    $id_fournisseur = $_GET['id_fournisseur'] ;
    //Prepare la requete qui recupere tout les DC d'un fournisseur selon son ID
    $requete = $orange->prepare(" SELECT * FROM datacenter WHERE id_fournisseur=$id_fournisseur "); 
    //Prepare la requete qui permet de recuperer le nom du fournisseur en fonction de son ID
    $nom = $orange->prepare(" SELECT nom_fournisseur FROM fournisseur WHERE id_fournisseur=$id_fournisseur  ");
    $admin = $_SESSION['utilisateur']['droit'];
?>
<?php require_once('base/head.php') ?>
<body>
    <?php require_once('base/navbar.php'); ?>
    <main>
        <?php
            $requete->execute(); 
            $nom->execute();            
            $nom_fournisseur = $nom->fetchAll(PDO::FETCH_ASSOC);
            $datacenters = $requete->fetchAll(PDO::FETCH_ASSOC);
        ?>
    </main>
    <section class="top">
        <div class="dropdown">
        <?php if ($admin == 2 || $admin == 3) { ?>
            <a href="maListe.php" class="dropdown"><button class="dropbtn">Retour Liste</button></a><br><br>
        <?php } ?>
            <a href="accueil.php" class="dropdown"><button class="dropbtn">Accueil</button></a><br><br>
    <?php if ($admin == 2 || $admin == 3) { ?>
        <a href="fonction/addDC.php?id_fournisseur=<?php echo $id_fournisseur;?>" class="dropdown"><button class="dropbtn">Ajouter un DC</button></a> <br><br>
   <?php } ?>
            <a href="contrat.php?id_fournisseur=<?php echo $id_fournisseur;?>" class="dropdown"><button class="dropbtn">Consulter les contrats</button></a>
        </div>
        </section>
        <br><br>
        <?php foreach ($nom_fournisseur as $name): ?>
        <section class="middle">
            <div>
                <h1>Fiche d'information du <a href="accueil.php">fournisseur</a> : <b><?= $name["nom_fournisseur"] ?></b></h1>
                <br><br>
            </div>
        </div>
        <?php endforeach ?>
    </section><br><br>

    <section class="corps">
        <table class= "dico">
            <thead>
                <tr>
                    <th>Datacenter</th>
                    <th>Adresse</th>
                    <th>Ville</th>
                    <th>CP</th>
                    <th>MMR</th>
                    <th>Liste géré par UPR</th>
                    <th class="thObs">Contact et accès</th>
                    <th>Portail intranet hébergeur</th>
                    <th>Demande d'accès</th>
                    <th class="thObs">Observations</th>
                    <th>Code DICO</th>
                <?php if ($admin == 2 || $admin == 3){ ?>
                    <th>Edit</th>
                <?php } ?>
                </tr>
            </thead>
            <!-- Tableau d'affichage -->
            <?php foreach ($datacenters as $datacenter): ?>
                <div class="datacenter">
                    <?php if(!empty($datacenter["id_fournisseur"])): ?>
                        <?php $id_fournisseur = $datacenter["id_fournisseur"] ?>
                        <?php $id_dc = $datacenter["id_dc"] ?>
                        <tr>
                            <td><?= $datacenter["nom_dc"] ?></td>
                            <td><?= $datacenter["adresse"] ?></td>
                            <td><?= $datacenter["ville"] ?></td>
                            <td><?= $datacenter["code_postal"] ?></td>
                            <td><?= $datacenter["MMR"] ?></td>
                            <td><?= $datacenter["liste_gerer_UPR"] ?></td>
                            <td><?= $datacenter["contact_acces"] ?></td>
                            <td><?= $datacenter["port_intranet_heberg"] ?></td>
                            <td><?= $datacenter["demande_acces"] ?></td>
                            <td><?= $datacenter["observations"] ?></td>
                            <td><a href="information.php?id_fournisseur=<?php echo $id_fournisseur;?>&id_dc=<?php echo $id_dc;?>"><img src="img/info.png" alt="" width="22px" height="auto"></a></td>
                            <?php if ($admin == 2 || $admin == 3){ ?>    
                                <td><a href="fonction/editDC.php?id_fournisseur=<?php echo $id_fournisseur;?>&id_dc=<?php echo $id_dc;?>"><img src="img/edit.png" alt="" width="22px" height="auto"></a></td>
                            <?php } ?>
                        </tr>
                    <?php endif ?>
                </div>
            <?php endforeach ?>
        </table>
     </section>
</body>
<style>
    .corps {
        margin-block-end: 3%;
    }
    .top {
        margin-bottom : 15px;
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

    th.thObs {
        padding : 5vh;
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
        float: left;
        margin-top: 0.5vh;
        margin-left: 5px;
    }
</style>
<?php require_once('base/footer.php');  ?>