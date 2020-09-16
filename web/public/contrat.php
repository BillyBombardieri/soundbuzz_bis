<?php 
    require_once('base/init.php');
    require_once('base/head.php');
    require_once('base/navbar.php');
    if ( !enLigne() ){ 
        header('location:connexion.php');
        exit();
    } 
    $id_fournisseur = $_GET['id_fournisseur'] ;
    //recupere les contrats selon l'ID du fournisseur
    $requete = $orange->prepare(" SELECT * FROM contrat WHERE id_fournisseur=$id_fournisseur "); 
    //Recupere le nom du fournisseur selon l'ID du fournisseur
    $nom = $orange->prepare(" SELECT nom_fournisseur FROM fournisseur WHERE id_fournisseur=$id_fournisseur  ");
    $requete->execute(); 
    $nom->execute();  
    $contrats = $requete->fetchAll(PDO::FETCH_ASSOC);          
    $nom_fournisseur = $nom->fetchAll(PDO::FETCH_ASSOC);
    $admin = $_SESSION['utilisateur']['droit'];
?>
<body>    
    <section class="top">
    <?php if ($admin == 2 || $admin == 3) { ?>
        <div class="dropbtn2">
            <a href="fonction/ajoutContrat.php?id_fournisseur=<?php echo $id_fournisseur;?>">Ajouter un Contrat </a>
        </div>
  <?php } ?>
        <div class="dropdown">
            <a href="datacenter.php?id_fournisseur=<?php echo $id_fournisseur;?>" class="dropdown"><button class="dropbtn">Retour</button></a><br><br>
        </div>
        </section>
        <?php foreach ($nom_fournisseur as $name): ?>
        <section class ="middle">
            <div>
                <h1>Liste des contrats du <a href="accueil.php">fournisseur</a> : <b><?= $name["nom_fournisseur"] ?></b></h1>
                <br><br>
            </div>
        <?php endforeach ?>
    </section>
    <section class="corps">
        <table class= "dico">
            <thead>
                <tr>
                    <th>Numéro Contrat</th>
                    <th>FAS</th>
                    <th>Récurrent Mensuel</th>
                    <th>Date de Début</th>
                    <th>Date de Fin</th>
                    <th>Coût première année</th>
                    <th>Coût Annuel</th>
                    <th>Coût dernière année</th>
                    <?php if ($admin == 2 || $admin == 3) { ?>
                        <th>Contrat version PDF</th>
                        <th>EDIT</th>
                    <?php } ?>
                </tr>
            </thead>
            <?php foreach ($contrats as $contrat): ?>
                <div class="contrat">
                    <?php if(!empty($contrat["id_fournisseur"])): ?>
                        <?php
                            $id_fournisseur = $contrat["id_fournisseur"];
                            $dir = 'pdf'; 
                            $files = scandir($dir); 
                            $numero=$contrat["num_contrat"];
                        ?>
                        <tr>
                            <td><?= $numero ?></td>
                            <td><?= $contrat["fas"] ?></td>
                            <td><?= $contrat["recurrent_mensuel"] ?></td>
                            <?php endif; 

                            $fa = $contrat["fas"];
                            $fas = intval($fa);
                            $r = $contrat["recurrent_mensuel"];
                            $rm = intval($r);

                            $date= $contrat["date_debut"];
                            $date= explode('-', $date);
                            $anneeDeb= $date[0];
                            $anneeDebut= intval($anneeDeb);
                            $moisDeb= $date[1];
                            $moisDebut= intval($moisDeb);
                            $jourDeb= $date[2];
                            $jourDebut= intval($jourDeb);

                            $date1= $contrat["date_fin"];
                            $date1= explode('-', $date1);
                            $anneeF= $date1[0];
                            $anneeFin= intval($anneeF);
                            $moisF= $date1[1];
                            $moisFin= intval($moisF);
                            $jourF= $date1[2];
                            $jourFin= intval($jourF);

                            $annee = $anneeDebut ;
                            //Calcul le montat de la première année en fonction du début de la date de contrat
                            for ($annee ; $annee <= $anneeFin; $annee ++) {
                                if ($annee == $anneeDebut) {
                                    if ($jourDebut > 6) {
                                        $cout = 0.75 * $rm;
                                        $mois = 12 - $moisDebut - 1;
                                        $cout = $cout + $fas + ($mois * $rm); 
                                    }
                                    if ($jourDebut > 14) {
                                        $cout = 0.50 * $rm;
                                        $mois = 12 - $moisDebut - 1;
                                        $cout = $cout + $fas + ($mois * $rm); 
                                    }
                                    if ($jourDebut > 23) {
                                        $cout = 0.25 * $rm;
                                        $mois = 12 - $moisDebut - 1;
                                        $cout = $cout + $fas + ($mois * $rm); 
                                    }
                                    if ($jourDebut < 6) {
                                        $mois = 12 - $moisDebut;
                                        $cout = $fas + ($mois * $rm); 
                                    }
                                }
                                //Calcul le montant des années suivantes sauf la dernière
                                if ($annee > $anneeDebut && $annee!= $anneeFin) {
                                    $cout_annuel = 12 *  $rm;
                                }
                                elseif ($anneeFin - $anneeDebut == 1 || $anneeFin - $anneeDebut == 0) {
                                        $cout_annuel = 0;
                                    }
                                
                                //Calcul le montant de la dernière année en fonction de la date de fin du contrat
                                if ($annee == $anneeFin) {
                                    if ($jourFin > 6) {
                                        $cout_fin = 0.75 * $rm;
                                        $moisFin = 12 - $moisFin - 1;
                                        $cout_fin = $cout_fin + $fas + ($moisFin * $rm); 
                                    }
                                    if ($jourFin > 14) {
                                        $cout_fin = 0.50 * $rm;
                                        $moisFin = 12 - $moisFin - 1;
                                        $cout_fin = $cout_fin + $fas + ($moisFin * $rm); 
                                    }
                                    if ($jourFin > 23) {
                                        $cout_fin = 0.25 * $rm;
                                        $mois_fin = 12 - $moisFin - 1;
                                        $cout_fin = $cout_fin + $fas + ($moisFin * $rm); 
                                    }
                                    if ($jourFin < 6) {
                                        $moisFin = 12 - $moisFin;
                                        $cout_fin = $fas + ($moisFin * $rm); 
                                    }
                                }
                            }
                            ?>
                            <td><?= $contrat["date_debut"] ?></td>
                            <td><?= $contrat["date_fin"] ?></td>
                            <td><?= $cout ?></td>
                            <td><?= $cout_annuel ?></td>
                            <td><?= $cout_fin ?></td>
                            <?php if ($admin == 2 || $admin ==3) { ?>
                                <?php 
                                foreach($files as $file) {
                                    if ($file == $contrat["contrat_pdf"]) {  ?>
                                        <td><a target="_blank" href="pdf/<?php echo $file; ?> "> Visualiser </a> </td>
                                    <?php 
                                    }
                                }
                            ?>
                                <td><form method="post">
                                    <a href="fonction/editContrat.php?id_fournisseur=<?php echo $id_fournisseur;?>&num_contrat=<?php echo $numero; ?>"><img src="img/edit.png" alt="" width="22px" height="auto"></a>
                                </form></td>
                            <?php } ?>    
                        </tr>
                </div>
            <?php
                endforeach
             ?>
        </table>
     </section>

     <?php
        //fonction pour supprimer le contrat selon son numero
        if( isset($_POST['supprimer']) && isset($_POST["num_contrat"])) {
            $delete = $orange->prepare("DELETE FROM contrat WHERE num_contrat='$numero'");
            $delete->execute();
            $reload = 1;
     ?>
            <script type="text/javascript">
                window.location.href = 'contrat.php?id_fournisseur='.'$id_fournisseur';
                //window.location.reload();
            </script>
        <?php
            header("Refresh:0");
        } 
        ?>

</body>
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
    }

     .dropbtn2 a {
        color : white;
        text-decoration : none;
        margin-left: 23px;
    }

    .dropdown {
        position: relative;
        display: inline-block;
        margin-top: 0.5vh;
        margin-left: 5px;
    }
</style>
<?php require_once('base/footer.php');?>