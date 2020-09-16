<?php 
    require_once('../base/init.php');
    require_once('../PHPExcel/Classes/PHPExcel.php');
    if ( !enLigne() ){ 
        header('location:../connexion.php');
        exit();
    }
    //Récupère le niveau d'admin de la session actuelle
    $verifAdmin = $_SESSION['utilisateur']['droit'];

    if ($verifAdmin == 2 || $verifAdmin == 3) {
        require_once('../base/head2.php');
        require_once('../base/navbar2.php');

        $requete = $orange->prepare(" SELECT * FROM Equinix "); 
        $requete->execute(); 
        $prestations = $requete->fetchAll(PDO::FETCH_ASSOC);
?>
    <body>
    <main>
        <?php require_once('../base/navbar2.php');?>   
        <section class="top">
            <div class="dropbtn2">
                <a href="statistique_equinix.php">Statistique</a>
            </div>
            <div class="dropdown">
                <a href="../crossco.php" class="dropdown"><button class="dropbtn">Retour</button></a><br><br>
            </div>
            <br><br>

    <?php
        if (isset($noerror)){
            echo $noerror;
        }  
        if (isset($error)){
            echo  $error;
        }
        if (isset($erreur_file)){
            echo  $erreur_file;
        }
        if (isset($erreur_upload)){
            echo  $erreur_upload;
        }
    ?>
    <div>
        <h1>Mise à jours des Cross Connects de Equinix</b></h1>
    </div>
    <!-- Formulaire pour AJOUTER un Fournisseur -->
    <form class="form-style-7" method="post" action=""  enctype="multipart/form-data">
        <ul>
            <li>
                <label for="url">Télécharger le fichier excel</label>
                <input type="file" id="logo" name="logo" accept=".xlsx, .xls" maxlength="100">
                <span>Téléchargez le fichier au format XLSX ou XLS</span>
            </li>
            <li>
                <input type="submit" name="ajouter" value="Ajouter" >
            </li>
        </ul>
    </form>
    <?php
    //Verifie l'extension et la taille du PDF
    if(isset($_FILES['logo']['name'])) {
        $dossier = '../trash/';
        $fichier = basename($_FILES['logo']['name']);
        $taille_maxi = 100000;
        $taille = filesize($_FILES['logo']['tmp_name']);
        $extensions = array('.xlsx', '.xls');
        $extension = strrchr($_FILES['logo']['name'], '.'); 
        //Début des vérifications de sécurité...
        if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
        {
            $erreur_file = 'Vous devez uploader un fichier de type XLSX ou XLS !';
        }
        if($taille>$taille_maxi)
        {
            $erreur_file = 'Le fichier est trop gros...';
        }
        if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
        {
            //On formate le nom du fichier ici...
            $fichier = strtr($fichier, 
                'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
                'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
            $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
            if(move_uploaded_file($_FILES['logo']['tmp_name'], $dossier . $fichier)) 
            {
                // Ouvrir un fichier Excel en lecture
                $objReader = PHPExcel_IOFactory::createReader('Excel2007');
                $objPHPExcel = $objReader->load($dossier.$fichier);
                $sheet = $objPHPExcel->getActiveSheet() ;
                $highestRow = $sheet->getHighestRow();
                // on vide la table avant d'insérer les nouvelles données
                $delet= $orange -> prepare("DELETE FROM equinix");
                $delet->execute();
                for ($i=2; $i<=$highestRow; $i++){
                    $cell_1 = $sheet->getCellByColumnAndRow(0, $i) ;
                    $cell_11 = $sheet->getCellByColumnAndRow(11, $i) ;
                    $cell_19 = $sheet->getCellByColumnAndRow(19, $i) ;
                    $cell_21 = $sheet->getCellByColumnAndRow(21, $i) ;
                    $cell_27 = $sheet->getCellByColumnAndRow(27, $i) ;
                    $cell_28 = $sheet->getCellByColumnAndRow(28, $i) ;
                    $cell_30 = $sheet->getCellByColumnAndRow(30, $i) ;
                    //insertition de chaque ligne en BDD 
                    $th= $orange ->prepare("INSERT INTO equinix (serial_number, patch_panel_demandeur, patch_panel_client, port_client_cote_demandeur, port_client_cote_client, site_crossco, type_connecteur_client) VALUES (:serial_number, :patch_panel_demandeur, :patch_panel_client, :port_client_cote_demandeur, :port_client_cote_client, :site_crossco, :type_connecteur_client)");
                    $th->bindParam(':serial_number', $cell_11);
                    $th->bindParam(':patch_panel_demandeur', $cell_19);
                    $th->bindParam(':patch_panel_client', $cell_27);
                    $th->bindParam(':port_client_cote_demandeur', $cell_21);
                    $th->bindParam(':port_client_cote_client', $cell_28);
                    $th->bindParam(':site_crossco', $cell_1);
                    $th->bindParam(':type_connecteur_client', $cell_30);
                    $th->execute();
    
                }
                unlink($dossier.$fichier);
                echo("Cross Connects mis à jours pour Equinix");
            }
            else //Sinon (la fonction renvoie FALSE).
            {
                $erreur_upload = 'Echec de l\'upload !';
            }
        }
    }
?>
        <form method="GET" class="formulaire">
            <label for="fournisseur">Référence du Cross Connect :
                <input class="input2" type="recherche" name="recherche" autocomplete="on">
            </label>
            <button>Afficher</button>
        </form>
        <!-- Fonction de recherche selon la valeur du Input -->
        <?php if(isset($_GET['recherche'])){
                $ifNotId = $orange->prepare(" SELECT * FROM equinix WHERE serial_number LIKE '".$_GET['recherche']."%' ORDER BY serial_number ASC"); 
                $ifNotId->execute();
                $prestations = $ifNotId->fetchAll(PDO::FETCH_ASSOC); 
            }
        ?>
            <?php if(empty($ifNotId) && isset($_GET["recherche"]) ){ ?>
                <h2 class="no_search">Aucun Fournisseur ne correspond à votre recherche</h2>
            <?php } ?>
        </section>
        <section class ="middle">
            <div>
                <h1>Liste des Cross Connects de Equinix :</h1>
                <br><br>
            </div>
        </section>
        <section class="corps">
            <table class= "dico">
                <thead>
                    <tr>
                        <th>Serial Number</th>
                        <th>Type Connecteur Client</th>
                        <th>PP Demandeur</th>
                        <th>PP Client</th>
                        <th>Port Client côté Demandeur</th>
                        <th>Port Client côté Client</th>
                        <th>Site</th>
                    </tr>
                </thead>
                <?php foreach ($prestations as $presta): ?> 
                <?php if(!empty($presta["serial_number"])): ?>
                    <div class="contrat">
                            <tr>
                                <td><?= $presta["serial_number"] ?></td>
                                <td><?= $presta["type_connecteur_client"] ?></td>
                                <td><?= $presta["patch_panel_demandeur"] ?></td>
                                <td><?= $presta["patch_panel_client"] ?></td>
                                <td><?= $presta["port_client_cote_demandeur"] ?></td>
                                <td><?= $presta["port_client_cote_client"] ?></td>
                                <td><?= $presta["site_crossco"] ?></td>
                                <?php endif; ?>   
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
        </section>
</main>
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

<footer>
<?php require_once('../base/footer2.php'); ?>
</footer>
<!-- Style du formulaire -->
<style type="text/css">
    .form-style-7{
        max-width:65vh;
        margin:50px auto;
        background:#fff;
        border-radius:2px;
        padding:20px;
        font-family: Georgia, "Times New Roman", Times, serif;
    }
    .form-style-7 h1{
        display: block;
        text-align: center;
        padding: 0;
        margin: 0px 0px 20px 0px;
        color: black;
        font-size:x-large;
    }
    .form-style-7 ul{
        list-style:none;
        padding:0;
        margin:0;	
    }
    .form-style-7 li{
        display: block;
        padding: 9px;
        border:1px solid black;
        margin-bottom: 30px;
        border-radius: 3px;
    }
    .form-style-7 li:last-child{
        border:none;
        margin-bottom: 0px;
        text-align: center;
    }
    .form-style-7 li > label{
        display: block;
        float: left;
        margin-top: -19px;
        background: #FFFFFF;
        height: 16px;
        padding: 2px 5px 2px 5px;
        color: black;
        font-size: 14px;
        overflow: hidden;
        font-family: Arial, Helvetica, sans-serif;
    }
    .form-style-7 input[type="text"],
    .form-style-7 input[type="date"],
    .form-style-7 input[type="datetime"],
    .form-style-7 input[type="email"],
    .form-style-7 input[type="number"],
    .form-style-7 input[type="search"],
    .form-style-7 input[type="time"],
    .form-style-7 input[type="url"],
    .form-style-7 input[type="file"],
    .form-style-7 input[type="password"],
    .form-style-7 textarea,
    .form-style-7 select 
    {
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        width: 100%;
        display: block;
        outline: none;
        border: none;
        height: 45px;
        line-height: 25px;
        font-size: 16px;
        padding: 0;
        font-family: Georgia, "Times New Roman", Times, serif;
    }
    .form-style-7 li > span{
        background: rgb(255,121,0);
        display: block;
        padding: 3px;
        margin: 0 -9px -9px -9px;
        text-align: center;
        color: black;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11px;
        margin-top: 3px;
    }
    .form-style-7 textarea{
        resize:none;
    }
    .form-style-7 input[type="submit"],
    .form-style-7 input[type="button"]{
        background:black;
        border: none;
        padding: 10px 20px 10px 20px;
        border-bottom: 3px solid rgb(255,121,0);
        border-radius: 3px;
        color: white;
        width: 17vh;
    }
    .form-style-7 input[type="submit"]:hover,
    .form-style-7 input[type="button"]:hover{
        background: rgb(255,121,0);
        color:white;
    }
</style>
<!-- Style Global -->
<style>
    .corps {
        margin-block-end: 3%;
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
    .top h1 {
        margin: 0;
        text-align: center;
        color: black;
        font-size: 250%;
    }

    h1 {
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
        cursor: pointer;
    }

    .corps h2 {
        text-align: center;
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

    textarea {
        border-color: black;
        border-width: 1px;
    }

    input {
        border-color: black;
        border-width: 1px;
        cursor: pointer;
    }

    .part {
        display: inline-flex;
        justify-content: space-around;
        align-items: center;
        margin-left:1%;
        width: 100%;
    }

    .margin {
        margin-top: 3%; 
        margin-left: 3%; 
        margin-right: 5%;
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

    .forme {
        width: 80%;
        height: 67vh;
        margin: auto;
        border-style: ridge;
        border-color: black;
        border-radius: 10px;
    }

    .forme input, textarea {
        font-size: 80%;
    }

    .forme label {
        font-size: 110%;
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

    #button {
        display: block;
        margin : auto;
        background-color: rgb(255,121,0);
        color: white;
        padding: 8px;
        font-size: 15px;
        border: none;
        margin-block-end: 2%;
        margin-right :50vh;
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

<style>
    @media (min-width: 768px) and (max-width: 991px) {
        .forme {
            width: 80%;
        }

        table,tbody,tr,td {
        font-size: 60%;

        }

        .forme input, textarea {
        font-size: 60%;
        }

        .forme label {
        font-size: 80%;
        }
    }


    @media (min-width: 992px) and (max-width: 1100px) {
        .forme {
            width: 68%;
        }
        table,tbody,tr,td {
        font-size: 60%;  
        }

    }


    @media (min-width: 1101px) and (max-width: 1299px) {

        .forme {
            width: 70%;
        }

    }
</style>