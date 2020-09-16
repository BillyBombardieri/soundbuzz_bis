<?php 
    require_once('../base/init.php'); 
    if ( !enLigne() ){ 

    header('location: ../connexion.php');
    exit();
    }
 
    $verifAdmin = $_SESSION['utilisateur']['droit'];
    if ($verifAdmin == 2 || $verifAdmin == 3) {
        $prestation = $_GET['num_prestation'];
        //Prepare une requete qui affiche les données d'un DC selon son ID
        $requete = $orange->prepare(" SELECT * FROM cross_connect WHERE num_prestation='$prestation'"); 

        //Enregistre les modifs si tout les données sont entrées
        if(isset($_POST['enregistrer'])) { 

            if(!empty($_POST['type_cable']) ){
                $type_cable = $orange->exec("UPDATE cross_connect SET type_cable = '$_POST[type_cable]' WHERE num_prestation='$prestation' ");
            }

            if(!empty($_POST['hebergeur_orange']) ){
                $hebergeur_orange = $orange->exec("UPDATE cross_connect SET hebergeur_orange = '$_POST[hebergeur_orange]' WHERE num_prestation='$prestation' ");
            }
            
            if(!empty($_POST['patch_panel_orange']) ){
                $patch_panel_orange = $orange->exec("UPDATE cross_connect SET patch_panel_orange = '$_POST[patch_panel_orange]' WHERE num_prestation='$prestation' ");
            }

            if(!empty($_POST['num_port_orange']) ){
                $num_port_orange = $orange->exec("UPDATE cross_connect SET num_port_orange = '$_POST[num_port_orange]' WHERE num_prestation='$prestation' ");
            }

            if(!empty($_POST['nom_client']) ){
                $nom_client = $orange->exec("UPDATE cross_connect SET nom_client = '$_POST[nom_client]' WHERE num_prestation='$prestation' ");
            }
            
            if(!empty($_POST['hebergeur_client']) ){
                $hebergeur_client = $orange->exec("UPDATE cross_connect SET hebergeur_client = '$_POST[hebergeur_client]' WHERE num_prestation='$prestation' ");
            }
            
            if(!empty($_POST['patch_panel_client']) ){
                $patch_panel_client = $orange->exec("UPDATE cross_connect SET patch_panel_client = '$_POST[patch_panel_client]' WHERE num_prestation='$prestation' ");
            }

            if(!empty($_POST['num_port_client']) ){
                $num_port_client = $orange->exec("UPDATE cross_connect SET num_port_client = '$_POST[num_port_client]' WHERE num_prestation='$prestation' ");
            }
            
            if(!empty($_POST['num_serie_cross_connect']) ){
                $num_serie_cross_connect = $orange->exec("UPDATE cross_connect SET num_serie_cross_connect = '$_POST[num_serie_cross_connect]' WHERE num_prestation='$prestation' ");
            }
            
        }

        //Bouton pour supprimer un CrossCo
        if (isset($_POST['delete'])) {
            $deleteCt = $orange->exec(" DELETE FROM cross_connect WHERE num_prestation='$prestation' ");
            header('location: ../crossco.php');
        }
    ?>

    <?php require_once('../base/head2.php') ?>
    <body>
        <?php require_once('../base/navbar2.php'); ?>
        <main>
            <?php
                //Execute la requete prepare
                $requete->execute(); 
                $prestations = $requete->fetchAll(PDO::FETCH_ASSOC);
            ?>
        </main>

        <section class="top">
            <a href="../crossco.php"><button class="dropbtn2">Retour</button></a>
            <div class="dropdown">
                <form method="post">
                    <!-- Bouton graphique supprimer -->
                    <input type="submit" name="delete" class="dropbtn" value="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce Cross Connect ? Cette action est irréversible et entraînera la suppression définitive de celui-ci')">
                </form>
            </div>
            <br><br>
            <h1>Modification du <b>Cross Connect</b></h1>
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
                        <th>Numéro de Prestation</th>
                        <th>Type Câble</th>
                        <th>Hébergeur Orange</th>
                        <th>Patch Panel Orange</th>
                        <th>Numéro de Port Orange</th>
                        <th>Nom du Client</th>
                        <th>Hébergeur Client</th>
                        <th>Patch Panel Client</th>
                        <th>Numéro de Port Client</th>
                        <th>Numéro de série du Cross Connect</th>
                    </tr>
                </thead>
                <?php foreach ($prestations as $presta): ?>
                        <div class="contrat">
                            <?php if(!empty($presta["num_prestation"])): ?>
                                <?php $prestation = $presta["num_prestation"] ?>
                                <tr>
                                    <td><?= $presta["num_prestation"] ?></td>
                                    <td><?= $presta["type_cable"] ?></td>
                                    <td><?= $presta["hebergeur_orange"] ?></td>
                                    <td><?= $presta["patch_panel_orange"] ?></td>
                                    <td><?= $presta["num_port_orange"] ?></td>
                                    <td><?= $presta["nom_client"] ?></td>
                                    <td><?= $presta["hebergeur_client"] ?></td>
                                    <td><?= $presta["patch_panel_client"] ?></td>
                                    <td><?= $presta["num_port_client"] ?></td>
                                    <td><?= $presta["num_serie_cross_connect"] ?></td>
                                </tr>
                            <?php endif ?>
                        </div>
                <?php endforeach ?>
            </table>
            <br><br>
            <!-- Formulaire pour modifier un CrossConnect -->
            <form class="form-style-7" method="post" action=""  enctype="multipart/form-data">
            <ul>

                <li>
                    <label for="name">Type de Câble</label>
                    <select type="text" name="type_cable" maxlength="100">
                    <?php
                        $cable = $presta["type_cable"];
                        $listeCable=array('','CUIVRE','FIBRE');
                        echo '<option>'.$cable.'</option>';
                        for($i=0; $i<=sizeof($listeCable); $i++)
                        {
                            if($listeCable[$i] != $cable) {
                                if($listeCable[$i] != $listeCable[0]) { ?>
                                    <option value="<?= $i ?>"><?php echo ($listeCable[$i]); ?></option> 
                                    <?php
                                }
                            }
                        }
                    ?>
                    </select>
                    <span>Indiquez le type du câble</span>
                </li>

                <li>
                    <label for="name">Hébergeur Orange</label>
                    <input type="text" name="hebergeur_orange" maxlength="100" value="<?= $presta["hebergeur_orange"] ?>">
                    <span>Entrez l'hébergeur Orange</span>
                </li>

                <li>
                    <label for="name">Patch Panel Orange</label>
                    <input type="text" name="patch_panel_orange" maxlength="100" value="<?= $presta["patch_panel_orange"] ?>">
                    <span>Entrez le numéro du patch panel d'Orange</span>
                </li>

                <li>
                    <label for="name">Numéro de port Orange</label>
                    <input type="text" name="num_port_orange" maxlength="100" value="<?= $presta["num_port_orange"] ?>">
                    <span>Entrez le numéro de port Client</span>
                </li>

                <li>
                    <label for="name">Nom Client</label>
                    <input type="text" name="nom_client" maxlength="100" value="<?= $presta["nom_client"] ?>">
                    <span>Entrez le nom du Client</span>
                </li>

                <li>
                    <label for="name">Hébergeur Client</label>
                    <input type="text" name="hebergeur_client" maxlength="100" value="<?= $presta["hebergeur_client"] ?>">
                    <span>Entrez l'hébergeur Client</span>
                </li>

                <li>
                    <label for="name">Patch Panel Client</label>
                    <input type="text" name="patch_panel_client" maxlength="100" value="<?= $presta["patch_panel_client"] ?>">
                    <span>Entrez le numéro du patch panel Client</span>
                </li>

                <li>
                    <label for="name">Numéro de port Client</label>
                    <input type="text" name="num_port_client" maxlength="100" value="<?= $presta["num_port_client"] ?>">
                    <span>Entrez le numéro du port Client</span>
                </li>

                <li>
                    <label for="name">Numéro Série Cross Connect</label>
                    <input type="text" name="num_serie_cross_connect" maxlength="100" value="<?= $presta["num_serie_cross_connect"] ?>">
                    <span>Entrez le numéro de série du cross connect</span>
                </li>
                <li>
                    <input type="submit" name="enregistrer" value="Enregistrer" >
                </li>
            </ul>
        </form>
        </section>

    <!-- Feuille de style -->
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
    width : 17vh;
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
    width : 17vh;
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