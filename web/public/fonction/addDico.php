<?php 
    require_once('../base/init.php');
    if ( !enLigne() ){ 
        header('location: ../connexion.php');
        exit();
    }
    $verifAdmin = $_SESSION['utilisateur']['droit'];

    if ($verifAdmin == 2 || $verifAdmin == 3) {
        // Récupère ID du Fournisseur et ID du DC
        $id_dc = $_GET['id_dc'] ;
        $id_fournisseur = $_GET['id_fournisseur'] ;

        //Prepare une requete qui recupère le nom du DC en fonction de son ID
        $nom = $orange->prepare(" SELECT nom_dc FROM datacenter WHERE id_dc=$id_dc  ");

        // Ajoute un Code Dico dans la table information
        if(isset($_POST['ajouter'])){ 

            if(!empty($_POST['code_dico']) ){

                $insert = $orange->exec(" INSERT INTO information(code_dico,bandeau,cable_fo,cable_fo_disp,precablage,precablage_dispo,nom_salle,baies,patch_panel,id_dc) VALUES('$_POST[code_dico]', '$_POST[bandeau]', '$_POST[cable_fo]', '$_POST[cable_fo_disp]', '$_POST[precablage]','$_POST[precablage_dispo]','$_POST[nom_salle]','$_POST[baies]','$_POST[patch_panel]','$id_dc')  ");
                header('location: ../information.php?id_fournisseur='.$id_fournisseur.'&id_dc='.$id_dc);
            }
            else {
                $error = '<div style="color:red;text-align:center;">Veuillez entrer un code dico</div>';
            }
        }
    ?>

    <?php 
        require_once('../base/head2.php');
        require_once('../base/navbar2.php'); 
    ?>
    <body>
        <main>
            <?php
                //Execution de la requete prepare
                $nom->execute();            
                $nom_datacenter = $nom->fetchAll(PDO::FETCH_ASSOC);
            ?>
        </main>
        <section class="top">
            <a href="../information.php?id_fournisseur=<?php echo $id_fournisseur;?>&id_dc=<?php echo $id_dc;?>"><button class="dropbtn2">Retour</button></a>
            <br><br>
            <?php foreach ($nom_datacenter as $name): ?>
                <div>
                    <h1>Ajout d'un <b>Code Dico</b> au sein de <b><?= $name["nom_dc"] ?></b></h1>
                    <br><br>
                </div>
            <?php endforeach ?>
        </section>
        <?php
            if (isset($inscrip)) {
                echo $inscrip;
            } ?>
        <?php 
            if (isset($error)) {
                echo $error;
            } ?>
        <!--Formulaire pour AJOUTER un DICO -->
        <form class="form-style-7" method="post" action=""  enctype="multipart/form-data">
            <ul>
                <li>
                    <label for="name">Code Dico</label>
                    <input type="text" name="code_dico" maxlength="100">
                    <span>Entrez le numéro du code Dico</span>
                </li>

                <li>
                    <label for="name">Patch Panel</label>
                    <input type="text" name="patch_panel" maxlength="100">
                    <span>Entrez le numéro de patch panel</span>
                </li>

                <li>
                    <label for="name">Bandeau</label>
                    <input type="text" name="bandeau" maxlength="25">
                    <span>Entrez le nom du Bandeau</span>
                </li>

                <li>
                    <label for="name">Câble FO</label>
                    <input type="number" name="cable_fo" maxlength="100">
                    <span>Entrez le nombre de câble FO utilisés</span>
                </li>

                <li>
                    <label for="name">Câble FO Disponible</label>
                    <input type="number" name="cable_fo_disp" maxlength="100">
                    <span>Entrez le nombre de câble FO disponible</span>
                </li>

                <li>
                    <label for="name">Précablage</label>
                    <input type="number" name="precablage" maxlength="100">
                    <span>Entrez le nombre de précablage</span>
                </li>

                <li>
                    <label for="name">Précablage Disponible</label>
                    <input type="number" name="precablage_dispo" maxlength="100">
                    <span>Entrez le nombre de précablage disponible</span>
                </li>

                <li>
                    <label for="name">Salle</label>
                    <input type="text" name="nom_salle" maxlength="100">
                    <span>Entrez le nom de la salle</span>
                </li>

                <li>
                    <label for="name">Baies</label>
                    <input type="text" name="baies" maxlength="100">
                    <span>Entrez le nom des baies</span>
                </li>

                <li>
                    <input type="submit" name="ajouter" value="Ajouter" >
                </li>
            </ul>
        </form>
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

<!--Style du Formulaire -->
<style type="text/css">
    .form-style-7{
        max-width:65vh;
        margin: auto;
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
    }

    .firstPart {
        display: inline-flex;
        justify-content: space-around;
        align-items: center;
        margin-left:1%;
        width: 100%;
    }

    .secondPart {
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
        width: 72%;
        height: auto!important;
        margin: auto;
        border-style: ridge;
        border-color: black;
        border-radius: 10px;
    }

    .forme input {
        font-size: 80%;
    }

    .forme label {
        font-size: 100%;
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


    #button {
        display: block;
        margin : auto;
        background-color: rgb(255,121,0);
        color: white;
        padding: 8px;
        font-size: 10px;
        border: none;
        margin-top: 1%;
        margin-block-end: 2%;
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