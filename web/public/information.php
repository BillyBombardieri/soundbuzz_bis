<?php 
    require_once('base/init.php'); 
    if ( !enLigne() ){ 

        header('location:connexion.php');
        exit();
    }
    $id_dc = $_GET['id_dc'] ;
    $id_fournisseur = $_GET['id_fournisseur'] ;
    $admin = $_SESSION['utilisateur']['droit'];

    //Prepare la requete qui recupere toutes les infos des DC d'un Fournisseur
    $aide = $orange->prepare(" SELECT * FROM datacenter WHERE id_fournisseur=$id_fournisseur"); 

    //Prepare la requete qui recupere tout les Dico d'un DC selon son ID
    $requete = $orange->prepare(" SELECT * FROM information WHERE id_dc=$id_dc"); 

    //$prepare = $orange->prepare(" SELECT * FROM information WHERE nom_dc LIKE '%".$_GET['recherche']."%' "); 
    $nom_datacenter = $orange->prepare(" SELECT nom_dc FROM datacenter WHERE id_dc=$id_dc  ");
    //Prepare la requete qui recupere le nom du fournisseur en fonction de l'ID du fournisseur
    $nom_fourniss = $orange->prepare(" SELECT nom_fournisseur FROM fournisseur WHERE id_fournisseur=$id_fournisseur ");

    //Prepare la requete qui cacul le nombre de FO total
    $totalCable = $orange->prepare(" SELECT SUM(cable_fo) AS total_fo  FROM information WHERE id_dc=$id_dc ");

    //Prepare la requete qui calcul le nombre de FO Disponible
    $totalDispo = $orange->prepare(" SELECT SUM(cable_fo_disp) AS total_dispo  FROM information WHERE id_dc=$id_dc ");
?>

<?php require_once('base/head.php') ?>
<body>
    <?php require_once('base/navbar.php'); ?>
    <main>
        <?php
        //Execute toute les requetes
        $requete->execute(); 
        $nom_datacenter->execute();
        $nom_fourniss->execute();
        $aide->execute();  
        $totalCable->execute();  
        $totalDispo->execute();
        $total_disp = $totalDispo->fetchAll(PDO::FETCH_ASSOC);   
        $total_fo = $totalCable->fetchAll(PDO::FETCH_ASSOC);     
        $aides = $aide->fetchAll(PDO::FETCH_ASSOC);
        $nom_fournisseur = $nom_fourniss->fetchAll(PDO::FETCH_ASSOC);
        $nom_dc = $nom_datacenter->fetchAll(PDO::FETCH_ASSOC);
        $informations = $requete->fetchAll(PDO::FETCH_ASSOC);?>
    </main>
    <section class="top">
        <a href="datacenter.php?id_fournisseur=<?php echo $id_fournisseur;?>&id_dc=<?php echo $id_dc;?>"><button class="dropbtn2">Retour</button></a>
        <?php if ($admin == 2 || $admin == 3) { ?>
            <a href="fonction/addDico.php?id_fournisseur=<?php echo $id_fournisseur;?>&id_dc=<?php echo $id_dc;?>" class="dropDown"><button class="dropbtn2">Ajouter</button></a>
        <?php } ?>
        <div class="dropdown">
            <button class="dropbtn">Datacenters</button>
            <div class="dropdown-content">
                <?php foreach ($aides as $help): ?>
                    <?php if(!empty($help["id_fournisseur"])): ?>
                        <?php $id_fournisseur = $help["id_fournisseur"] ?>
                        <?php $id_dc2 = $help["id_dc"] ?>
                            <a href="information.php?id_fournisseur=<?php echo $id_fournisseur;?>&id_dc=<?php echo $id_dc2;?>"><?= $help["nom_dc"] ?></a>
                    <?php endif ?>
                    <?php endforeach ?>
            </div>
        </div>
    </section>
        <br><br><br>
    <section class="middle">
        <div class="titres">
            <?php foreach ($nom_dc as $name): ?>
                <h1>Fiche d'information du DC : <b><?= $name["nom_dc"] ?></b></h1>
            <?php endforeach ?>
            <?php foreach ($nom_fournisseur as $name2): ?>
                <h1>Fournisseur : <a href="datacenter.php?id_fournisseur=<?php echo $id_fournisseur;?>"><b><?= $name2["nom_fournisseur"] ?></b></a></h1>
            <?php endforeach ?>
            <br><br>
        </div>
        <div class="capacite">
            <?php foreach ($total_fo as $totalF): ?>
                <h3 id="g">Capacité total : <?= $totalF["total_fo"] ?></h3>
            <?php endforeach ?>
            <?php foreach ($total_disp as $totalD): ?>
                <h3 id="d">Capacité disponible : <?= $totalD["total_dispo"] ?></h3>
            <?php endforeach ?>
        </div>
        <br><br>
    </section>
    <section class="corps">  
        <!-- Tableau d'affichage des infos du DC -->  
        <table class= "dico">
            <thead>
                <tr>
                    <th>Code dico</th>
                    <th>Patch Panel</th>
                    <th>Bandeau</th>    
                    <th>Câble Fibre Optique</th>
                    <th>Câble FO disponible</th>
                    <th>Précâblage</th>
                    <th>Précâblage disponible</th>
                    <th>Nom de salle</th>
                    <th>Baies</th>
                    <?php if ($admin == 2 || $admin == 3) { ?>
                        <th>Edit</th>
                    <?php } ?>
                </tr>
            </thead>
            <?php foreach ($informations as $information): ?>
                <div class="information">
                    <?php if(!empty($information["id_info"])): ?>
                    <?php $id_info = $information["id_info"] ?>
                        <tr>   
                            <td><?= $information["code_dico"] ?></td> 
                            <td><?= $information["patch_panel"] ?></td>            
                            <td><?= $information["bandeau"] ?></td>    
                            <td><?= $information["cable_fo"] ?></td>
                            <td><?= $information["cable_fo_disp"] ?></td>
                            <td><?= $information["precablage"] ?></td>
                            <td><?= $information["precablage_dispo"] ?></td>
                            <td><?= $information["nom_salle"] ?></td>
                            <td><?= $information["baies"] ?></td>
                            <?php if ($admin == 2 || $admin == 3) { ?>
                                <td><a href="fonction/editDico.php?id_fournisseur=<?php echo $id_fournisseur;?>&id_info=<?php echo $id_info;?>&id_dc=<?php echo $id_dc;?>"><img src="img/edit.png" alt="" width="20px" height="auto"></a></td>
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
    }


    #g {
        float: left;
        margin-left: 30%;
        text-decoration: underline;
    }

    #d {
        float: right;
        margin-right: 30%;
        text-decoration: underline;
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
        font-size:80%;
        border:1px solid #6495ed;
        padding:5px;
        text-align:center;
    }


    .dropbtn {
        background-color: rgb(255,121,0);
        color: white;
        padding: 13px;
        font-size: 13px;
        border: none;
        cursor: pointer;
        width : 13vh;
    }

    .dropbtn2 {
        background-color: rgb(255,121,0);
        color: white;
        padding: 13px;
        font-size: 13px;
        border: none;
        cursor: pointer;
        margin-top : 10px;
        float :left;
        margin-left : 10px;
        width : 13vh;
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
        margin-top: 0.5vh;
        margin-left: 5px;
    }
</style>
<?php require_once('base/footer.php');  ?>