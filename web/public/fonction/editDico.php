<?php 
    require_once('../base/init.php');
    if ( !enLigne() ){ 

        header('location: ../connexion.php');
        exit();
    }
    $verifAdmin = $_SESSION['utilisateur']['droit'];
    if ($verifAdmin == 2 || $verifAdmin == 3) {

        $informations=array();

        //Recupere et stock les ID du fournisseur, DC et DICO
        $id_info = $_GET['id_info'] ;
        $id_fournisseur = $_GET['id_fournisseur'];
        $id_dc = $_GET['id_dc'];

        $requete = $orange->prepare(" SELECT * FROM information WHERE id_info=$id_info  "); 

        if(isset($_POST['enregistrer'])) {

            if(!empty($_POST['code_dico']) ){
                $code_dico = $orange->exec("UPDATE information SET code_dico = '$_POST[code_dico]' WHERE id_info=$id_info ");
            }

            if(!empty($_POST['patch_panel']) ){
                $patch_panel = $orange->exec("UPDATE information SET patch_panel = '$_POST[patch_panel]' WHERE id_info=$id_info ");
            }

            if(!empty($_POST['bandeau']) ){
                $nom_cable = $orange->exec("UPDATE information SET bandeau = '$_POST[bandeau]' WHERE id_info=$id_info ");
            }
            
            if(!empty($_POST['nom_salle']) ){
                $nom_salle = $orange->exec("UPDATE information SET nom_salle = '$_POST[nom_salle]' WHERE id_info=$id_info ");
            }

            if(!empty($_POST['baies']) ){
                $baies = $orange->exec("UPDATE information SET baies = '$_POST[baies]' WHERE id_info=$id_info ");
            }
            
            if(!empty($_POST['precablage']) ){
                $precablage = $orange->exec("UPDATE information SET precablage = '$_POST[precablage]' WHERE id_info=$id_info ");
            }
            
            if(!empty($_POST['precablage_dispo']) ){
                $precablage_dispo = $orange->exec("UPDATE information SET precablage_dispo = '$_POST[precablage_dispo]' WHERE id_info=$id_info ");
            }
            if(!empty($_POST['cable_fo']) ){
                $cable_fo = $orange->exec("UPDATE information SET cable_fo = '$_POST[cable_fo]' WHERE id_info=$id_info ");
            }
            if(!empty($_POST['cable_fo_disp']) ){
                $cable_fo_disp = $orange->exec("UPDATE information SET cable_fo_disp = '$_POST[cable_fo_disp]' WHERE id_info=$id_info ");
            }

        }
        //Supprime un DICO en fonction de l'ID du DC
        if (isset($_POST['delete'])) {

            $delete = $orange->exec(" DELETE FROM information WHERE id_info='$id_info' ");
            
            header('location: ../information.php?id_fournisseur='.$id_fournisseur.'&id_dc='.$id_dc);
        }
        ?>

        <?php require_once('../base/head2.php') ?>
        <body>
            <?php require_once('../base/navbar2.php'); ?>
            <main>
                <?php
                    $requete->execute();
                    $informations = $requete->fetchAll(PDO::FETCH_ASSOC);
                ?>
            </main>
            <section class="top">
                <a href="../information.php?id_fournisseur=<?php echo $id_fournisseur;?>&id_dc=<?php echo $id_dc;?>"><button class="dropbtn2">Retour</button></a>
                <div class="dropdown">
                    <form method="post">
                        <input type="submit" name="delete" class="dropbtn" value="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce code dico ?')">
                    </form>
                </div>
                <br><br>
                <h1>Modification d'un <b>Code dico</b></h1>
                <br><br>
            </section>
            <section class="corps">
                <h2>Actuellement :</h2>
                <table class= "dico">
                    <thead>
                        <tr>
                            <th>Code dico</th>
                            <th>Patch Panel</th>
                            <th>Bandeau</th>    
                            <th>Câble Fibre Optique</th>
                            <th>Câble FO disponible</th>
                            <th>Précâblage</th>
                            <th>Précâblage disponible</th>
                            <th>Nom de salle</th>
                            <th>Baies</th>
                        </tr>
                    </thead>
                    <?php foreach ($informations as $information): ?>
                    <div class="information">
                        <?php if(!empty($information["id_info"])): ?>
                        <?php $id_info = $information["id_info"] ?>
                            <tr>  
                                <td><?= $information["code_dico"] ?></td> 
                                <td><?= $information["patch_panel"] ?></td>           
                                <td><?= $information["bandeau"] ?></td>    
                                <td><?= $information["cable_fo"] ?></td>
                                <td><?= $information["cable_fo_disp"] ?></td>
                                <td><?= $information["precablage"] ?></td>
                                <td><?= $information["precablage_dispo"] ?></td>
                                <td><?= $information["nom_salle"] ?></td>
                                <td><?= $information["baies"] ?></td>
                            </tr>
                        <?php endif ?>
                    </div>
                    <?php endforeach ?>
                </table>
                <br>
            <!-- Formulaire de modification d'un DICO -->
            <form class="form-style-7" method="post" action=""  enctype="multipart/form-data">
                <ul>
                    <li>
                        <label for="name">Code Dico</label>
                        <input type="text" name="code_dico" maxlength="100" value="<?= $information["code_dico"] ?>">
                        <span>Modifiez le numéro du code Dico</span>
                    </li>

                    <li>
                        <label for="name">Patch Panel</label>
                        <input type="text" name="patch_panel" maxlength="100" value="<?= $information["patch_panel"] ?>">
                        <span>Modifiez le numéro du Patch Panel</span>
                    </li>

                    <li>
                        <label for="name">Bandeau</label>
                        <input type="text" name="bandeau" maxlength="25" value="<?= $information["bandeau"] ?>">
                        <span>Modifiez le nom du Bandeau</span>
                    </li>

                    <li>
                        <label for="name">Câble FO</label>
                        <input type="number" name="cable_fo" maxlength="100" value="<?= $information["cable_fo"] ?>">
                        <span>Modifiez le nombre de câble FO utilisés</span>
                    </li>

                    <li>
                        <label for="name">Câble FO Disponible</label>
                        <input type="number" name="cable_fo_disp" maxlength="100" value="<?= $information["cable_fo_disp"] ?>">
                        <span>Modifiez le nombre de câble FO disponible</span>
                    </li>

                    <li>
                        <label for="name">Précablage</label>
                        <input type="number" name="precablage" maxlength="100" value="<?= $information["precablage"] ?>">
                        <span>Modifiez le nombre de précablage</span>
                    </li>

                    <li>
                        <label for="name">Précablage Disponible</label>
                        <input type="number" name="precablage_dispo" maxlength="100" value="<?= $information["precablage_dispo"] ?>">
                        <span>Modifiez le nombre de précablage disponible</span>
                    </li>

                    <li>
                        <label for="name">Salle</label>
                        <input type="text" name="nom_salle" maxlength="100" value="<?= $information["nom_salle"] ?>">
                        <span>Modifiez le nom de la salle</span>
                    </li>

                    <li>
                        <label for="name">Baies</label>
                        <input type="text" name="baies" maxlength="100" value="<?= $information["baies"] ?>">
                        <span>Modifiez le nom des baies</span>
                    </li>

                    <li>
                        <input type="submit" name="enregistrer" value="Enregistrer" >
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
        </body>

        <?php
    }   
    elseif ($verifAdmin == 1) { 
        ?>
        <body class="noir">
            <div class="blanc">
                <a href="../accueil.php" class="img"><img src="../logo/logo-orange.png" alt=""></a>
                <p class="p_erreur"> Vous n'avez pas accès à ce contenu, veuillez cliquer sur l'image afin d'être redirigé</p>
            </div>
        </body> 
    <?php
    } 
    ?>


<!-- Style du Formulaire -->
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

</body>
<!-- Style global -->
<style>
    .corps {
        margin-block-end: 3%;
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
        font-size: 160%;
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

    #button {
        display: block;
        margin : auto;
        background-color: rgb(255,121,0);
        color: white;
        padding: 8px;
        font-size: 13px;
        border: none;
        margin-top: 1%;
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