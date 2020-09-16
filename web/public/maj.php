<?php 
    require_once('base/init.php');
    if ( !enLigne() ){ 
        header('location:connexion.php');
        exit();
    }  
    $admin = $_SESSION['utilisateur']['droit'];
?>
<?php if ($admin == 2 || $admin == 3) { 
    require_once('base/head.php');
    require_once('base/navbar.php');
    ?>
    <body>    
        <section class="top">
            <div class="dropdown">
                <a href="accueil.php" class="dropdown"><button class="dropbtn">Retour</button></a><br><br>
            </div>
            <h1>Mise à jour des Informations</h1>
            <form class="form-style-7" method="post" enctype="multipart/form-data">
                <ul>
                    <li>
                        <label for="name">Mettre à Jour les</label>
                        <select name="choix">
                            <option value="crossconnect">CrossConnects</option>
                            <option value="datacenter">Datacenters</option>
                            <option value="dico">Codes Dico</option>
                        </select>
                        <span>CrossConnect / Datacenters / Code Dico</span>
                    </li>
                    <li>
                        <label for="url">Télécharger le fichier Excel</label>
                        <input type="file" id="fichier" name="fichier" accept=".xlsx, .xls" maxlength="100">
                        <span>Téléchargez le fichier au format xlsx ou xls</span>
                    </li>
                    <li>
                        <input type="submit" name="enregistrer" value="Enregistrer" >
                    </li>
                </ul>
            </form>
        </section>
        <?php
            //Verifie l'extension et la taille du PDF
            if(isset($_FILES['fichier']['name'])) {
                $dossier = 'trash/';
                $fichier = basename($_FILES['fichier']['name']);
                $taille = filesize($_FILES['fichier']['tmp_name']);
                $extensions = array('.xlsx', '.xls');
                $extension = strrchr($_FILES['fichier']['name'], '.'); 
                //Début des vérifications de sécurité...
                if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
                {
                    $erreur_file = 'Vous devez uploader un fichier de type xlsx ou xls !';
                }
                if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
                {
                    //On formate le nom du fichier ici...
                    $fichier = strtr($fichier, 
                        'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
                        'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                    $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
                    if(move_uploaded_file($_FILES['fichier']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
                    {
                    }
                    else //Sinon (la fonction renvoie FALSE).
                    {
                        $erreur_upload = 'Echec de l\'upload !';
                    }
                }
            }

            //Boucle pour les CrossConnect
            if (isset($_POST['choix'])){
                if ($_POST['choix']=="crossconnect" && isset($_FILES['fichier']['name'])){
                    //Traitement du fichier + insertion en BDD
        
                    //Suppression du fichier a la fin du traitement
                    $nomfichier=$_FILES['fichier']['name'];
                    unlink ("/trash/$nomfichier");
                }
            }


            //Boucle pour les Datacenters
            if (isset($_POST['choix'])){
                if ($_POST['choix']=="datacenter" && isset($_FILES['fichier']['name'])){
                //Traitement du fichier + insertion en BDD

                //Suppression du fichier a la fin du traitement
                $nomfichier=$_FILES['fichier']['name'];
                unlink ("/trash/$nomfichier");
                }
            }

            
            //Boucle pour les Codes Dico
            if (isset($_POST['choix'])){
                if ($_POST['choix']=="dico" && isset($_FILES['fichier']['name'])){
                //Traitement du fichier + insertion en BDD

                //Suppression du fichier a la fin du traitement
                $nomfichier=$_FILES['fichier']['name'];
                unlink ("/trash/$nomfichier");
                }
            }

        ?>
    </body>
            <?php } elseif ($admin == 1) { ?>
                <body class="noir">
                    <div class="blanc">
                        <a href="accueil.php" class="img"><img src="logo/logo-orange.png" alt=""></a>
                        <p class="p_erreur"> Vous n'avez pas accès à ce contenu, veuillez cliquer sur l'image afin d'être redirigé</p>
                    </div>
                </body> 
            <?php } ?>
<!-- Style du Formulaire -->
<style type="text/css">
    .form-style-7{
        max-width:65vh;
        margin:57px auto;
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
        cursor: pointer;
    }

    .corps h2 {
        text-align: center;
    }

    table {
    border:3px solid #6495ed;
    border-collapse:collapse;
    width:30%;
    margin:auto;
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

    .margin1 {
        margin-top: 3%; 
        margin-left: 3%; 
        margin-right: 5%;
        content : '*Obligatoire'
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
        text-align : center;
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
        font-size: 15px;
        border: none;
        margin-block-end: 2%;
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
<?php require_once('base/footer.php');?>