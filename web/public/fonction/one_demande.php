<?php 
    require_once('../base/init.php');
    if ( !enLigne() ){ 
        header('../location:connexion.php');
        exit();
    } 
    $admin = $_SESSION['utilisateur']['droit'];
    $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];
    if ($admin == 3) { 
        if (isset($_GET['date'])){
            $date=$_GET['date'];
            $requete = $orange->prepare(" SELECT * FROM demande WHERE date='$date' "); 
            $requete->execute();
            $onedemande= $requete->fetchAll(PDO::FETCH_ASSOC); 
        }
        require_once('../base/head2.php');
        require_once('../base/navbar2.php');
    ?>
        <body>    
            <section class="top"> 
                <div class="dropbtn2">
                    <a href="../archive.php">Les Archives</a>
                </div>
                <div class="dropdown">
                    <a href="gestion_demande.php" class="dropdown"><button class="dropbtn">Retour</button></a><br><br>
                </div>
            </section>
            <section class ="middle">
                <div>
                    <h1>Demande à traiter :</h1>
                    <br><br>
                </div>
            </section>
            <section class="corps">
                <table class= "dico">
                    <thead>
                        <tr>
                            <th>Numéro de Demande</th>
                            <th>Nom</th>
                            <th>Mail</th>
                            <th>Sujet</th>
                            <th>Type de demande</th>
                            <th>Statut</th>
                            <th>Date de création</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <?php 
                        if (isset($onedemande)){
                            foreach ($onedemande as $onedemand): ?> 
                                <?php if(!empty($onedemand["id_demande"]) && $onedemand["statut"]!= "Clôturé"): ?>
                                    <div class="contrat">
                                        <tr>
                                            <?php $id_demande=$onedemand["id_demande"] ?>
                                            <?php $mail_user=$onedemand["mail_demande"] ?>
                                            <td><?= $onedemand["id_demande"] ?></td>
                                            <td><?= $onedemand["nom_user"] ?></td>
                                            <td><?= $onedemand["mail_demande"] ?></td>
                                            <td><?= $onedemand["sujet_mail"] ?></td>
                                            <td><?= $onedemand["type_demande"] ?></td>
                                            <td><?= $onedemand["statut"] ?></td>
                                            <td><?= $onedemand["date"] ?></td>
                                            <td><form method="post">
                                            <?php 
                                                if($onedemand["statut"]=="En cours de traitement"){
                                            ?>
                                                    <a href="prise_en_charge_demande.php?id_demande=<?php echo $id_demande;?>&?mail_user=<?php echo $mail_user;?>" onclick="return confirm('Voulez-vous prendre en charge cette demande ?')">Prendre en Charge</a>    
                                            <?php
                                                }
                                                elseif($onedemand["statut"]!="En cours de traitement"){
                                            ?>
                                                    <a href="validation_demande.php?id_demande=<?php echo $id_demande;?>&?mail_user=<?php echo $mail_user;?>" onclick="return confirm('Une fois cloturé, la demande sera archivé, souhiatez-vous continuer l\'action ?')">Clôturer</a>    
                                            <?php
                                                }
                                            ?>
                                            
                                        </form></td>
                                        </tr>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach;
                        } ?>
                </table>
            </section>
        </body>
<?php } elseif ($admin == 1 || $admin == 2) { ?>
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

    .dropdown {
        position: relative;
        display: inline-block;
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
<?php require_once('../base/footer2.php');?>