<?php require_once('../base/init.php'); ?>
<?php 
    $nom_f =array();
    $info=array();
    $dc=array();

    if(!enLigne() ){

        header('location: ../connexion.php');
        exit();
    }
?>
<?php require_once('../base/head2.php') ?>
<body>
    <?php require_once('../base/navbar2.php'); ?>
    <main>
        <?php if((isset($_GET['recherche']))): ?>
            <?php
            $datacenter = $orange->prepare(" SELECT * FROM datacenter"); //recherche datacenter
            $fournisseur = $orange->prepare(" SELECT * FROM fournisseur ");
            $information = $orange->prepare(" SELECT * FROM information WHERE code_dico LIKE '%".$_GET['recherche']."%' "); //informations
            $datacenter->execute();  
            $information->execute(); 
            $fournisseur->execute();
            $nom_f = $fournisseur->fetchAll(PDO::FETCH_ASSOC);
            $info = $information->fetchAll(PDO::FETCH_ASSOC);
            $dc = $datacenter->fetchAll(PDO::FETCH_ASSOC);
            ?>
        <?php endif ?>
    </main> 

    <section class="top">
    <div class="dropdown">
            <a href="../accueil.php" class="dropdown"><button class="dropbtn">Retour</button></a>
    </div><br><br>
        <h1>Recherche <b>Code Dico</b></h1>
        <br><br><br>
        <form method="GET" class="formulaire">

            <label for="dico">Code Dico :</label>
            <input type="recherche" name="recherche"><br><br>
            
            <button>Rechercher</button> <br><br>
        </form>
    </section>

    <?php if( empty($info) && (isset($_GET["recherche"])) ): ?>
        <h2 class="no_search">Aucun évènement ne corresponds à votre recherche</h2>
    <?php endif ?> 
    

    <br><br>
    <section class="corps">
        <table class= "dico">
        <?php if(!empty($info) ): ?>
        <thead>
            <tr>
                <th>Code dico</th>
                <th>Bandeau</th>    
                <th>Câble Fibre Optique</th>
                <th>Câble FO disponible</th>
                <th>Précâblage</th>
                <th>Précâblage disponible</th>
                <th>Nom de salle</th>
                <th>Baies</th>
                <th>ID Datacenter</th>
            </tr>
        </thead>
        <?php endif ?>
        <?php foreach ($info as $informa): ?>
            <div class="information">
                <?php if(!empty($informa) ): ?>
                    <tr>   
                        <td><?= $informa["code_dico"] ?></td>            
                        <td><?= $informa["bandeau"] ?></td>    
                        <td><?= $informa["cable_fo"] ?></td>
                        <td><?= $informa["cable_fo_disp"] ?></td>
                        <td><?= $informa["precablage"] ?></td>
                        <td><?= $informa["precablage_dispo"] ?></td>
                        <td><?= $informa["nom_salle"] ?></td>
                        <td><?= $informa["baies"] ?></td>
                        <td><?= $informa["id_dc"] ?></td>
                    </tr>
                <?php endif ?>
            </div>
        <?php endforeach ?>
        </table>
        <br><br>
    </section>
</body>
<br><br><br>
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

    .top b {
        color: rgb(255,121,0);
    }

    h2 {
        text-align : center;
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

    .fournisseur h2 {
        text-align: center;
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
        float: left;
        margin-top: 0.5vh;
        margin-left: 5px;
    }
</style>
<?php require_once('../base/footer.php');  ?>