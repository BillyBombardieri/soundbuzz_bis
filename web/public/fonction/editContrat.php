<?php 
    require_once('../base/init.php'); 
    if ( !enLigne() ){ 

    header('location: ../connexion.php');
    exit();
    }
 
    $verifAdmin = $_SESSION['utilisateur']['droit'];
    if ($verifAdmin == 2 || $verifAdmin == 3) {
        
        $id_fournisseur = $_GET['id_fournisseur'] ;
        $numero = $_GET['num_contrat'];
        //Prepare une requete qui affiche les données d'un DC selon son ID
        $requete = $orange->prepare(" SELECT * FROM contrat WHERE num_contrat='$numero'"); 

        //Enregistre les modifs si tout les données sont entrées
        if(isset($_POST['enregistrer'])) { 

            if(!empty($_POST['fas']) ){
                $f = addslashes($_POST['fas']);
                $fas = $orange->exec("UPDATE contrat SET fas = '$f' WHERE num_contrat='$numero' ");
            }

            if(!empty($_POST['recurrent_mensuel']) ){
                $recu = addslashes($_POST['recurrent_mensuel']);
                $recurrent_mensuel = $orange->exec("UPDATE contrat SET recurrent_mensuel = '$recu' WHERE num_contrat='$numero' ");
            }
            
            if(!empty($_FILES['contrat_pdf']['name']) ){
                $pdf=$_FILES['contrat_pdf']['name'];
                $contrat_pdf = $orange->exec("UPDATE contrat SET contrat_pdf = '$pdf' WHERE num_contrat='$numero' ");
            }

            if(!empty($_POST['date_debut']) ){
                $date_debut = $orange->exec("UPDATE contrat SET date_debut = '$_POST[date_debut]' WHERE num_contrat='$numero' ");
            }
            
            if(!empty($_POST['date_fin']) ){
                $date_fin = $orange->exec("UPDATE contrat SET date_fin = '$_POST[date_fin]' WHERE num_contrat='$numero' ");
            }
            
        }

        //Bouton pour supprimer un DC
        if (isset($_POST['delete'])) {
            $deleteCt = $orange->exec(" DELETE FROM contrat WHERE num_contrat='$numero' ");
            header('location: ../contrat.php?id_fournisseur='.$id_fournisseur);
        }
?>

<?php require_once('../base/head2.php') ?>
<body>
    <?php require_once('../base/navbar2.php'); ?>
    <main>
        <?php
            //Execute la requete prepare
            $requete->execute(); 
            $contrats = $requete->fetchAll(PDO::FETCH_ASSOC);
        ?>
    </main>

    <section class="top">
        <a href="../contrat.php?id_fournisseur=<?php echo $id_fournisseur;?>"><button class="dropbtn2">Retour</button></a>
        <div class="dropdown">
            <form method="post">
                <!-- Bouton graphique supprimer -->
                <input type="submit" name="delete" class="dropbtn" value="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce DataCenter ? Cette action est irréversible et entraînera la suppression des codes Dico liés à celui-ci.')">
            </form>
        </div>
        <br><br>
        <h1>Modification du <b>Datacenter</b></h1>
        <br><br>
    </section>
    <section class="corps">
        <?php
            if (isset($echo)){
                echo $succes;
            } 
        ?>
        <h2>Actuellement :</h2>
        <table class= "dico">
            <thead>
                <tr>
                    <th>Numéro contrat</th>
                    <th>FAS</th>
                    <th>Récurrent mensuel</th>
                    <th>Date de Début</th>
                    <th>Date de Fin</th>
                    <th>Contrat version PDF</th>
                </tr>
            </thead>
            <?php foreach ($contrats as $contrat): ?>
                    <div class="contrat">
                        <?php if(!empty($contrat["id_fournisseur"])): ?>
                            <?php $id_fournisseur = $contrat["id_fournisseur"] ?>
                            <tr>
                                <td><?= $numero ?></td>
                                <td><?= $contrat["fas"] ?></td>
                                <td><?= $contrat["recurrent_mensuel"] ?></td>
                                <td><?= $contrat["date_debut"] ?></td>
                                <td><?= $contrat["date_fin"] ?></td>
                                <td><?= $contrat["contrat_pdf"] ?></td>
                            </tr>
                        <?php endif ?>
                    </div>
            <?php endforeach ?>
        </table>
        <br><br>
        <!-- Formulaire pour modifier un contrat -->
        <form class="form-style-7" method="post" action=""  enctype="multipart/form-data">
        <ul>

            <li>
                <label for="name">FAS</label>
                <input type="number" name="fas" maxlength="100" value="<?= $contrat["fas"] ?>">
                <span>Entrez les frais d'accès aux services</span>
            </li>

            <li>
                <label for="name">Récurrent Mensuel</label>
                <input type="number" name="recurrent_mensuel" maxlength="100" value="<?= $contrat["recurrent_mensuel"] ?>">
                <span>Entrez le récurrent mensuel</span>
            </li>

            <li>
                <label for="name">Date de Début</label>
                <input type="date" name="date_debut" maxlength="100" value="<?= $contrat["date_debut"] ?>">
                <span>Entrez la date de début</span>
            </li>

            <li>
                <label for="name">Date de Fin</label>
                <input type="date" name="date_fin" maxlength="100" value="<?= $contrat["date_fin"] ?>">
                <span>Entrez la date de fin</span>
            </li>

            <li>
                <label for="name">Télécharger le PDF</label>
                <input type="file" id="contrat_pdf" name="contrat_pdf" accept=".pdf" maxlength="100">
                <span>Entrez le contrat en version PDF</span>
            </li>

            <li>
                <input type="submit" name="enregistrer" value="Enregistrer" >
            </li>
        </ul>
    </form>
    </section>
    <?php
        //Verifie l'extension et la taille du PDF
        if(isset($_FILES['contrat_pdf']['name'])) {
            $dossier = '../pdf/';
            $fichier = basename($_FILES['contrat_pdf']['name']);
            $taille_maxi = 100000;
            $taille = filesize($_FILES['contrat_pdf']['tmp_name']);
            $extensions = array('.pdf');
            $extension = strrchr($_FILES['contrat_pdf']['name'], '.'); 
            //Début des vérifications de sécurité...
            if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
            {
                $erreur = 'Vous devez uploader un fichier de type pdf !';
            }
            if($taille>$taille_maxi)
            {
                $erreur = 'Le fichier est trop gros...';
            }
            if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
            {
                //On formate le nom du fichier ici...
                $fichier = strtr($fichier, 
                    'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
                    'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
                if(move_uploaded_file($_FILES['contrat_pdf']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
                {
                }
                else //Sinon (la fonction renvoie FALSE).
                {
                    echo 'Echec de l\'upload !';
                }
            }
            else
            {
                echo $erreur;
            }
        }
    ?>
</body>
<script type="text/javascript">
    //auto expand textarea
    function adjust_textarea(h) {
        h.style.height = "20px";
        h.style.height = (h.scrollHeight)+"px";
    }
</script>

<?php
} elseif ($verifAdmin == 1) { ?>
    <body class="noir">
        <div class="blanc">
            <a href="../accueil.php" class="img"><img src="../logo/logo-orange.png" alt=""></a>
            <p class="p_erreur"> Vous n'avez pas accès à ce contenu, veuillez cliquer sur l'image afin d'être redirigé</p>
        </div>
    </body> 
<?php } ?>


<!-- Style du Formualire -->
<style type="text/css">
    .form-style-7{
        max-width:65vh;
        margin:5px auto;
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
    .form-style-7 input[type="textarea"],
    .form-style-7 input[type="search"],
    .form-style-7 input[type="time"],
    .form-style-7 input[type="url"],
    .form-style-7 input[type="file"],
    .form-style-7 input[type="password"],
    .form-style-7 input[type="radio"],
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
        height : 15vh;
    }
    .form-style-7 input[type="submit"],
    .form-style-7 input[type="button"]{
        background:black;
        border: none;
        padding: 10px 20px 10px 20px;
        border-bottom: 3px solid rgb(255,121,0);
        border-radius: 3px;
        color: white;
    }
    .form-style-7 input[type="submit"]:hover,
    .form-style-7 input[type="button"]:hover{
        background: rgb(255,121,0);
        color:white;
    }
</style>
<!-- Style Global-->
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

    .top h2 {
        margin: 0;
        text-align: center;
        color: black;
        font-size: 180%;
    }

    .top b {
        color: rgb(255,121,0);
    }

    .top a {
        text-decoration: none;
        color: black;
    }

    .corps h2 {
        text-align: center;
    }

    .dico {
        border-collapse: collapse;
        width: 50%;
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
    }

    textarea {
        border-color: black;
        border-width: 1px;
    }

    input {
        border-color: black;
        border-width: 1px;
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
    width : 15vh;
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
        width: 55%;
        height: auto!important;
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

    #button {
        display: block;
        margin : auto;
        background-color: rgb(255,121,0);
        color: white;
        padding: 8px;
        font-size: 13px;
        border: none;
        margin-block-end: 2%;
    }


    .dropbtn {
    background-color: rgb(255,0,0);
    color: white;
    padding: 13px;
    font-size: 13px;
    border: none;
    cursor: pointer;
    width : 15vh;
    }

    .dropdown {
    position: relative;
    display: inline-block;
    float: right;
    margin-top: 1vh;
    margin-right: 10px;
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
<?php require_once('../base/footer.php'); ?>