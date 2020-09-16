<?php 
    require_once('../base/init.php');
    if ( !enLigne() ){ 
        header('location:../connexion.php');
        exit();
    }
    $verifAdmin = $_SESSION['utilisateur']['droit'];

    if ($verifAdmin == 2 || $verifAdmin == 3) {
        require_once('../base/head2.php');
        require_once('../base/navbar2.php');
        $error='';
        //Recupere et Stock l'ID fournisseur
        $id_fournisseur = $_GET['id_fournisseur'] ;

        //Ajouter un Contrat
        if( isset($_POST['ajouter']) ){ 
            if ($_POST['date_debut'] > $_POST['date_fin']) {
                $error .= '<div style="color:red;text-align:center; font-weight: bold; text-decoration: underline;">Date début supérieur à date de fin</div>';
            }
            elseif(!empty($_POST['num_contrat']) AND !empty(($_FILES['contrat_pdf']['name'])) AND !empty($_POST['fas']) AND !empty($_POST['recurrent_mensuel']) AND !empty($_POST['date_debut']) AND !empty($_POST['date_fin']) ){
                if ($_POST['date_debut'] < $_POST['date_fin']) {    
                    $numContrat= $_POST['num_contrat'];
                    $fas=$_POST['fas'];
                    $rm=$_POST['recurrent_mensuel'];
                    $pdf=$_FILES['contrat_pdf']['name'];
                    $dateDeb=$_POST['date_debut'];
                    $dateFin=$_POST['date_fin'];
                    $tht= $orange ->prepare("INSERT INTO contrat (num_contrat, fas, recurrent_mensuel, contrat_pdf, date_debut, date_fin,id_fournisseur) VALUES (:num_contrat, :fas, :recurrent_mensuel, :contrat_pdf, :date_debut, :date_fin, :id_fournisseur)");
                    $tht->bindParam(':num_contrat', $numContrat);
                    $tht->bindParam(':fas', $fas);
                    $tht->bindParam(':recurrent_mensuel', $rm);
                    $tht->bindParam(':contrat_pdf', $pdf);
                    $tht->bindParam(':date_debut', $dateDeb);
                    $tht->bindParam(':date_fin', $dateFin);
                    $tht->bindParam(':id_fournisseur', $id_fournisseur);
                    $tht->execute();
                    
                    $noerror = '<div style="color:green;text-align:center; font-weight: text-decoration: underline;">Contrat correctement ajouté !</div>'; 
                }
            }
            else {
                $error .= '<div style="color:red;text-align:center; font-weight: bold; text-decoration: underline;">Veuillez remplir tout les champs</div>';
            }
        }
    ?>
    <body>
        <main>  
            <section class="top">
                <div class="dropdown">
                    <a href="../contrat.php?id_fournisseur=<?php echo $id_fournisseur;?>" class="dropdown"><button class="dropbtn">Retour</button></a><br><br>
                </div>
                <br><br>
                <div>
                    <h1>Ajout d'un <b>Contrat</b></h1>
                    <br><br>
                </div>
            </section>
        <?php
            if (isset($noerror)){
                echo $noerror;
            }  
        ?>
        <?php
            if (isset($error)){
                echo  $error;
            }
        ?>
        <!-- Formulaire pour AJOUTER un Contrat -->
        <form class="form-style-7" method="post" action=""  enctype="multipart/form-data">
            <ul>
                <li>
                    <label for="name">Numéro de Contrat</label>
                    <input type="text" name="num_contrat" maxlength="100">
                    <span>Entrez le numéro du contrat</span>
                </li>
                <li>
                    <label for="email">FAS</label>
                    <input type="number" name="fas" maxlength="100">
                    <span>Entrez les frais d'accès aux services</span>
                    <script type="text/javascript">
                        function test1(str) {
                            str = alltrim(str);
                            return /^[-+]?[0-9]+(\.[0-9]+)?$/.test(str);
                        }
                        function test2(str) {
                            str = alltrim(str);
                            return /^[-+]?\d+(\.\d+)?$/.test(str);
                        }
                        function test3(str) {
                            str = alltrim(str);
                            return /^[-+]?\d{3,5}(\.\d{1,3})?$/.test(str);
                        }
                    </script>
                </li>
                <li>
                    <label for="url">RM</label>
                    <input type="number" name="recurrent_mensuel" maxlength="100">
                    <span>Entrez le récurrent mensuel</span>
                    <script type="text/javascript">
                        function test1(str) {
                            str = alltrim(str);
                            return /^[-+]?[0-9]+(\.[0-9]+)?$/.test(str);
                        }
                        function test2(str) {
                            str = alltrim(str);
                            return /^[-+]?\d+(\.\d+)?$/.test(str);
                        }
                        function test3(str) {
                            str = alltrim(str);
                            return /^[-+]?\d{3,5}(\.\d{1,3})?$/.test(str);
                        }
                    </script>
                </li>

                <li>
                    <label for="name">Date Début</label>
                    <input type="date" name="date_debut" maxlength="100">
                    <span>Entrez la date de début de contrat</span>
                </li>

                <li>
                    <label for="name">Date Fin</label>
                    <input type="date" name="date_fin" maxlength="100">
                    <span>Entrez la date de fin de contrat</span>
                </li>

                <li>
                    <label for="url">Télécharger le PDF</label>
                    <input type="file" id="contrat_pdf" name="contrat_pdf" accept=".pdf" maxlength="100">
                    <span>Télécharger le contrat au format PDF</span>
                </li>
                <li>
                    <input type="submit" name="ajouter" value="Ajouter" >
                </li>
            </ul>
        </form>
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

    <?php require_once('../base/footer2.php'); ?>

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