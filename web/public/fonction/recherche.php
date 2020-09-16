<?php 
    require_once('../base/init.php');
    $dc =array();
    $info=array();
    $nom_fournisseur=array();

    if(!enLigne() ){

        header('location: ../connexion.php');
        exit();
    }
    //Prepare la requete qui recupere toute la table Information
    $information = $orange->prepare(" SELECT * FROM information"); //informations

    require_once('../base/head2.php') 
?>
<body>
    <?php require_once('../base/navbar2.php'); ?>
    <main>
        <?php 
            if(isset($_GET['r_fournisseur']) && (isset($_GET['r_datacenter']))):
                $datacenter = $orange->prepare(" SELECT * FROM fournisseur f, datacenter d WHERE f.nom_fournisseur LIKE '%".$_GET['r_fournisseur']."%' AND d.nom_dc LIKE '%".$_GET['r_datacenter']."%' AND d.id_fournisseur=f.id_fournisseur "); //recherche datacenter
                $datacenter->execute();  
                $information->execute();      
                $dc = $datacenter->fetchAll(PDO::FETCH_ASSOC);
                $info = $information->fetchAll(PDO::FETCH_ASSOC); 
            endif 
        ?>
    </main> 
    <section class="top">
        <div class="dropdown">
            <a href="../accueil.php" class="dropdown"><button class="dropbtn">Retour</button></a>
        </div><br><br>
        <h1>Recherche <b>Datacenter</b></h1>
        <br><br><br>
        <form method="GET" class="formulaire">

            <label for="fournisseur">Fournisseur :</label>
            <input type="recherche" name="r_fournisseur"><br><br>

            <label for="datacenter">Datacenter :</label>
            <input type="recherche" name="r_datacenter"><br><br>
            
            <button>Rechercher</button> <br><br>
        </form>
    </section>

    <?php if(empty($dc) && isset($_GET['r_fournisseur']) && (isset($_GET['r_datacenter']))): ?>
        <h2 class="no_search">Aucun évènement corresponds à votre recherche</h2>
    <?php endif ?> 
    <?php
        foreach ($nom_fournisseur as $name){
     ?>
        <p>
            <?php
                $name['nom_fournisseur']; 
            ?> 
         </p>
    <?php } ?>

    <br><br>
    <section class="corps">
        <table class= "dico">
            <?php if(!empty($dc) && (isset($_GET["r_fournisseur"])) && (isset($_GET["r_datacenter"])) ): ?>
            <thead>
                <tr>
                    <th>Datacenter</th>
                    <th>Adresse</th>
                    <th>Ville</th>
                    <th>CP</th>
                    <th>MMR</th>
                    <th>Liste géré par UPR</th>
                    <th>Contact et accès</th>
                    <th>Portail intranet hébergeur</th>
                    <th>Demande d'accès</th>
                    <th>Observations</th>
                </tr>
            </thead>
            <?php endif ?> 
            <?php
                foreach ($dc as $datacenter): 
            ?>
            <div class="datacenter">
                <?php if(!empty($datacenter["id_fournisseur"])): ?>
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
                    </tr>
                <?php endif ?>
            </div>
            <?php endforeach ?>
        </table>
        <br><br>
    </section>
    <br><br>
<style>
    body {
        margin: 0;
        padding: 0;
    }

    .top h1 {
        margin-top: 2%;
        text-align: center;
        font-size: 300%;
    }

    h2 {
        text-align : center;
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
        border-style: solid;
        border-color: rgb(255,121,0);
    }

    .top button {
        background-color: rgb(255,121,0);
        color: white;
        padding: 10px;
        font-size: 13px;
        border: none;
        cursor: pointer;
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

    .dropbtn {
        background-color: rgb(255,121,0);
        color: white;
        padding: 13px;
        font-size: 13px;
        border: none;
        cursor: pointer;
        margin-bottom: 1vh;
        width : 17vh;
        height : 5vh;
    }
    .dropdown {
        position: relative;
        display: inline-block;
        margin-top: 0.5vh;
        margin-left: 5px;
    }
</style>
<?php require_once('../base/footer.php');  ?>