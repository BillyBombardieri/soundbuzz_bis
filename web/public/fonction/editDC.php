<?php
    require_once('../base/init.php'); 
    if ( !enLigne() ){ 

        header('location: ../connexion.php');
        exit();
    }
    $verifAdmin = $_SESSION['utilisateur']['droit'];
    if ($verifAdmin == 2 || $verifAdmin == 3) {

        $id_dc = $_GET['id_dc'] ;

        $id_fournisseur = $_GET['id_fournisseur'] ;
        //Prepare une requete qui affiche les données d'un DC selon son ID
        $requete = $orange->prepare(" SELECT * FROM datacenter WHERE id_dc=$id_dc  "); 

        //Enregistre les modifs si tout les données sont entrées
        if(isset($_POST['enregistrer'])) { 

            if(!empty($_POST['nom_dc']) ){
                $nom_dc = $orange->exec("UPDATE datacenter SET nom_dc = '$_POST[nom_dc]' WHERE id_dc=$id_dc ");
            }

            if(!empty($_POST['adresse']) ){
                $adr = addslashes($_POST['adresse']);
                $adresse = $orange->exec("UPDATE datacenter SET adresse = '$adr' WHERE id_dc=$id_dc ");
            }

            if(!empty($_POST['ville']) ){
                $vil = addslashes($_POST['ville']);
                $ville = $orange->exec("UPDATE datacenter SET ville = '$vil' WHERE id_dc=$id_dc ");
            }
            
            if(!empty($_POST['code_postal']) ){
                $code_postal = $orange->exec("UPDATE datacenter SET code_postal = '$_POST[code_postal]' WHERE id_dc=$id_dc ");
            }

            if(!empty($_POST['MMR']) ){
                $MMR = $orange->exec("UPDATE datacenter SET MMR = '$_POST[MMR]' WHERE id_dc=$id_dc ");
            }
            
            if(!empty($_POST['liste_gerer_UPR']) ){
                $UPR = $orange->exec("UPDATE datacenter SET liste_gerer_UPR = '$_POST[liste_gerer_UPR]' WHERE id_dc=$id_dc ");
            }

            if(!empty($_POST['port_intranet_heberg']) ){
                $portail = $orange->exec("UPDATE datacenter SET port_intranet_heberg = '$_POST[port_intranet_heberg]' WHERE id_dc=$id_dc ");
            }

            if(!empty($_POST['contact_acces']) ){
                $contact_acces = $orange->exec("UPDATE datacenter SET contact_acces = '$_POST[contact_acces]' WHERE id_dc=$id_dc ");
            }

            if(!empty($_POST['demande_acces']) ){
                $demande_acces = $orange->exec("UPDATE datacenter SET demande_acces = '$_POST[demande_acces]' WHERE id_dc=$id_dc ");
            }
            
            if(!empty($_POST['observations']) ){
                $observations = $orange->exec("UPDATE datacenter SET observations = '$_POST[observations]' WHERE id_dc=$id_dc ");
            }
            
        }

        //Bouton pour supprimer un DC
        if (isset($_POST['delete'])) {
            $deleteInfo = $orange->exec(" DELETE FROM information WHERE id_dc='$id_dc' ");
            $deleteDc = $orange->exec(" DELETE FROM datacenter WHERE id_dc='$id_dc' ");
            
            header('location: ../datacenter.php?id_fournisseur='.$id_fournisseur);
        }
    ?>

    <?php require_once('../base/head2.php') ?>
    <body>
        <?php require_once('../base/navbar2.php'); ?>
        <main>
            <?php
                //Execute la requete prepare
                $requete->execute(); 
                $datacenters = $requete->fetchAll(PDO::FETCH_ASSOC);
            ?>
        </main>

        <section class="top">
            <a href="../datacenter.php?id_fournisseur=<?php echo $id_fournisseur;?>&id_dc=<?php echo $id_dc;?>"><button class="dropbtn2">Retour</button></a>
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
            <table class ="dico">
                <thead>
                    <tr>
                        <th>Datacenter</th>
                        <th>Adresse</th>
                        <th>Ville</th>
                        <th>CP</th>
                        <th>MMR</th>
                        <th>Liste géré par UPR</th>
                        <th>Contact et accès</th>
                        <th>Portail intranet hébergeur</th>
                        <th>Demande d'accès</th>
                        <th>Observations</th>
                    </tr>
                </thead>
                <?php foreach ($datacenters as $datacenter): ?>
                        <div class="datacenter">
                            <?php if(!empty($datacenter["id_fournisseur"])): ?>
                                <?php $id_fournisseur = $datacenter["id_fournisseur"] ?>
                                <?php $id_dc = $datacenter["id_dc"] ?>
                                <tr>
                                    <td><?= $datacenter["nom_dc"] ?></td>
                                    <td><?= $datacenter["adresse"] ?></td>
                                    <td><?= $datacenter["ville"] ?></td>
                                    <td><?= $datacenter["code_postal"] ?></td>
                                    <td><?= $datacenter["MMR"] ?></td>
                                    <td><?= $datacenter["liste_gerer_UPR"] ?></td>
                                    <td><?= $datacenter["contact_acces"] ?></td>
                                    <td><?= $datacenter["port_intranet_heberg"] ?></td>
                                    <td><?= $datacenter["demande_acces"] ?></td>
                                    <td><?= $datacenter["observations"] ?></td>
                                </tr>
                            <?php endif ?>
                        </div>
                <?php endforeach ?>
            </table>
            <br><br>
            <!-- Formulaire pour modifier un Datacenter -->
            <form class="form-style-7" method="post" action=""  enctype="multipart/form-data">
            <ul>
                <li>
                    <label for="name">Nom Datacenter</label>
                    <input type="text" name="nom_dc" maxlength="100" value="<?= $datacenter["nom_dc"] ?>">
                    <span>Entrez le numéro du contrat</span>
                </li>

                <li>
                    <label for="name">Adresse</label>
                    <input type="text" name="adresse" maxlength="100" value="<?= $datacenter["adresse"] ?>">
                    <span>Entrez l'adresse du Datacenter</span>
                </li>

                <li>
                    <label for="name">Ville</label>
                    <input type="text" name="ville" maxlength="100" value="<?= $datacenter["ville"] ?>">
                    <span>Entrez la ville du Datacenter</span>
                </li>

                <li>
                    <label for="name">CP</label>
                    <input type="number" name="code_postal" maxlength="100" value="<?= $datacenter["code_postal"] ?>">
                    <span>Entrez le code postal du Datacenter</span>
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
                    <label for="name">MMR</label>
                    <span>OUI</span>
                    <input type="radio" name="MMR" maxlength="100" VALUE="OUI"> 
                    <span>NON</span>
                    <input type="radio" name="MMR" maxlength="100" VALUE="NON">
                </li>

                <li>
                    <label for="name">Liste géré par UPR</label>
                    <span>OUI</span>
                    <input type="radio" name="liste_gerer_UPR" maxlength="100" VALUE="OUI">
                    <span>NON</span>
                    <input type="radio" name="liste_gerer_UPR" maxlength="100" VALUE="NON">
                </li>

                <li>
                    <label for="name">Portail intranet hébergeur :</label>
                    <span>OUI</span>
                    <input type="radio" name="port_intranet_heberg" maxlength="100" VALUE="OUI">
                    <span>NON</span>
                    <input type="radio" name="port_intranet_heberg" maxlength="100" VALUE="NON">
                </li>

                <li>
                    <label for="name">Contact et Accès</label>
                    <textarea rows="4" cols="50" type="text" name="contact_acces">
                    <?php echo $datacenter["contact_acces"]; ?>                
                    </textarea>
                    <span>Indiquez les différents contacts et accès</span>
                </li>

                <li>
                    <label for="name">Demande d'accès</label>
                    <textarea rows="4" cols="50" type="text" name="demande_acces">
                    <?php echo $datacenter["demande_acces"]; ?>                
                    </textarea>
                    <span>Indiquez les demandes d'accès</span>
                </li>

                <li>
                    <label for="name">Observations</label>
                    <textarea rows="4" cols="50" type="text" name="observations">
                    <?php echo $datacenter["observations"]; ?>                
                    </textarea>
                    <span>Indiquez les différentes observations relatives au Datacenter</span>
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