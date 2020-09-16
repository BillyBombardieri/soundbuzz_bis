<?php 
    require_once('../base/init.php');
    if ( !enLigne() ){ 
        header('location:../connexion.php');
        exit();
    }
    //Récupère le niveau d'admin de la session actuelle
    $verifAdmin = $_SESSION['utilisateur']['droit'];

    //Récupère les numéros de prestation de chaque crossconnect
    $requete = $orange->prepare(" SELECT num_prestation FROM cross_connect "); 
    $requete->execute(); 
    $prestations = $requete->fetchAll(PDO::FETCH_ASSOC);

    //Compte le nombre de crossconnect
    $count = $orange->prepare("SELECT COUNT(num_prestation) FROM cross_connect");
    $count->execute();

    if ($verifAdmin == 2 || $verifAdmin == 3) {
        require_once('../base/head2.php');
        require_once('../base/navbar2.php');
        $error='';
        //Ajouter un CrossConnect en BDD
        if( isset($_POST['ajouter']) ){
            if(!empty($_POST['num_prestation']) AND !empty($_POST['type_cable']) AND !empty($_POST['hebergeur_orange']) AND !empty($_POST['nom_client']) AND !empty($_POST['hebergeur_client']) AND !empty($_POST['num_serie_cross_connect']) ){   
                $num_prestation= $_POST['num_prestation'];
                $type_cable=$_POST['type_cable'];
                $hebergeur_orange=$_POST['hebergeur_orange'];
                $patch_panel_orange=$_POST['patch_panel_orange'];
                $num_port_orange=$_POST['num_port_orange'];
                $nom_client=$_POST['nom_client'];
                $hebergeur_client=$_POST['hebergeur_client'];
                $patch_panel_client=$_POST['patch_panel_client'];
                $num_port_client=$_POST['num_port_client'];
                $num_serie_cross_connect=$_POST['num_serie_cross_connect'];
                $tht= $orange ->prepare("INSERT INTO cross_connect (num_prestation, type_cable, hebergeur_orange, patch_panel_orange, num_port_orange, nom_client, hebergeur_client, patch_panel_client, num_port_client, num_serie_cross_connect) VALUES (:num_prestation, :type_cable, :hebergeur_orange, :patch_panel_orange, :num_port_orange, :nom_client, :hebergeur_client, :patch_panel_client, :num_port_client, :num_serie_cross_connect)");
                $tht->bindParam(':num_prestation', $num_prestation);
                $tht->bindParam(':type_cable', $type_cable);
                $tht->bindParam(':hebergeur_orange', $hebergeur_orange);
                $tht->bindParam(':patch_panel_orange', $patch_panel_orange);
                $tht->bindParam(':num_port_orange', $num_port_orange);
                $tht->bindParam(':nom_client', $nom_client);
                $tht->bindParam(':hebergeur_client', $hebergeur_client);
                $tht->bindParam(':patch_panel_client', $patch_panel_client);
                $tht->bindParam(':hebergeur_orange', $hebergeur_orange);
                $tht->bindParam(':num_port_client', $num_port_client);
                $tht->bindParam(':num_serie_cross_connect', $num_serie_cross_connect);
                $tht->execute();
                
                $noerror = '<div style="color:green;text-align:center; font-weight: text-decoration: underline;">Cross Connect correctement ajouté !</div>'; 
            }
            else {
                $error .= '<div style="color:red;text-align:center; font-weight: bold; text-decoration: underline;">Veuillez remplir tout les champs</div>';
            }
        }
?>
    <body>
        <main>  
            <section class="top">
                <!-- Bouton retour -->
                <div class="dropdown">
                    <a href="../crossco.php" class="dropdown"><button class="dropbtn">Retour</button></a><br><br>
                </div>
                <br><br>
                <div>
                    <h1>Ajout d'un <b>Cross Connect</b></h1>
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
        <!-- Formulaire pour AJOUTER un CroosConnect -->
        <form class="form-style-7" method="post" action=""  enctype="multipart/form-data">
            <ul>
                <li>
                    <label for="name">Numéro de Prestation</label>
                    <input type="text" name="num_prestation" maxlength="100">
                    <span>Entrez le numéro du Cross Connect</span>
                </li>
                <li>
                    <label for="name">Type Câble</label>
                    <select type="text" name="type_cable" maxlength="100">
                        <option value="CUIVRE">CUIVRE</option>
                        <option value="FIBRE">FIBRE</option>
                    </select>
                    <span>Indiquez le type du câble</span>
                </li>
                <li>
                    <label for="name">Hébergeur Orange</label>
                    <input type="text" name="hebergeur_orange" maxlength="100">
                    <span>Entrez l'hébergeur Orange</span>
                </li>

                <li>
                    <label for="name">Patch Panel Orange</label>
                    <input type="text" name="patch_panel_orange" maxlength="100">
                    <span>Entrez le numéro du patch panel d'Orange</span>
                </li>

                <li>
                    <label for="name">Numéro de port Orange</label>
                    <input type="text" name="num_port_orange" maxlength="100">
                    <span>Entrez le numéro de port Client</span>
                </li>

                <li>
                    <label for="name">Nom Client</label>
                    <input type="text" name="nom_client" maxlength="100">
                    <span>Entrez le nom du Client</span>
                </li>

                <li>
                    <label for="name">Hébergeur Client</label>
                    <input type="text" name="hebergeur_client" maxlength="100">
                    <span>Entrez l'hébergeur Client</span>
                </li>

                <li>
                    <label for="name">Patch Panel Client</label>
                    <input type="text" name="patch_panel_client" maxlength="100">
                    <span>Entrez le numéro du patch panel Client</span>
                </li>

                <li>
                    <label for="name">Numéro de port Client</label>
                    <input type="text" name="num_port_client" maxlength="100">
                    <span>Entrez le numéro du port Client</span>
                </li>

                <li>
                    <label for="name">Numéro Série Cross Connect</label>
                    <input type="text" name="num_serie_cross_connect" maxlength="100">
                    <span>Entrez le numéro de série du cross connect</span>
                </li>
                
                <li>
                    <input type="submit" name="ajouter" value="Ajouter" >
                </li>
            </ul>
        </form>
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