
<?php
    require_once('../base/init.php'); 
    if ( !enLigne() ){ 
        header('../location:connexion.php');
        exit();
    }
    $verifAdmin = $_SESSION['utilisateur']['droit'];

    if ($verifAdmin == 2 || $verifAdmin == 3) {
        $id_fournisseur = $_GET['id_fournisseur'] ; 
        // Prépare la requête qui récupère le nom du fournisseur en fonction de son ID
        $nom = $orange->prepare(" SELECT nom_fournisseur FROM fournisseur WHERE id_fournisseur=$id_fournisseur  ");
        // Ajoute un datacenter lorsque le bouton "ajouter" est actionné et si un nom de datacenter est indiqué
        if( isset($_POST['ajouter']) ){ 
            if(isset($_POST['adresse'])){
                // Gère les problèmes d'apostrophes, virgules
                $adr = addslashes($_POST['adresse']);
            }
            if(!empty($_POST['nom_dc']) ){
                // Enregistre le nouveau datacenter
                $insert = $orange->exec(" INSERT INTO datacenter(nom_dc, adresse, ville, code_postal, MMR, liste_gerer_UPR, contact_acces, port_intranet_heberg, demande_acces, observations, id_fournisseur) VALUES('$_POST[nom_dc]', '$adr', '$_POST[ville]', '$_POST[code_postal]', '$_POST[MMR]','$_POST[liste_gerer_UPR]','$_POST[contact_acces]','$_POST[port_intranet_heberg]','$_POST[demande_acces]','$_POST[observations]', '$id_fournisseur')  ");           
                header('location: ../datacenter.php?id_fournisseur='.$id_fournisseur);
            }
            else {
                $error = '<div style="color:red;text-align:center;">Veuillez entrer un nom de datacenter</div>';
            }
        }
        require_once('../base/head2.php')
        ?>
        <body>
            <main>
                <?php 
                    require_once('../base/navbar2.php');
                    $nom->execute();            
                    $nom_fournisseur = $nom->fetchAll(PDO::FETCH_ASSOC); 
                ?>
            </main>
            <section class="top">
                <!-- Bouton retour -->
                <div class="dropdown">
                    <a href="../datacenter.php?id_fournisseur=<?php echo $id_fournisseur;?>" class="dropdown"><button class="dropbtn">Retour</button></a><br><br>
                </div>
                <br><br>
                <?php foreach ($nom_fournisseur as $name): ?>
                <div>
                    <h1>Ajout d'un <b>Datacenter</b> au sein de <b><?= $name["nom_fournisseur"] ?></b></h1>
                    <br><br>
                </div>
                <?php endforeach ?>
            </section>
            <?php
                if (isset($inscrip)){
                    echo $inscrip;
                }  
            ?>
            <?php
                if (isset($error)){
                    echo  $error;
                }
            ?>
            <!-- Formulaire pour AJOUTER un Datacenter -->
            <form class="form-style-7" method="post" action=""  enctype="multipart/form-data">
                <ul>
                    <li>
                        <label for="name">Nom Datacenter</label>
                        <input type="text" name="nom_dc" maxlength="100">
                        <span>Entrez le numéro du contrat</span>
                    </li>

                    <li>
                        <label for="name">Adresse</label>
                        <input type="text" name="adresse" maxlength="100">
                        <span>Entrez l'adresse du Datacenter</span>
                    </li>

                    <li>
                        <label for="name">Ville</label>
                        <input type="text" name="ville" maxlength="100">
                        <span>Entrez la ville du Datacenter</span>
                    </li>

                    <li>
                        <label for="name">CP</label>
                        <input type="number" name="code_postal" maxlength="100">
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
                        </textarea>
                        <span>Indiquez les différents contacts et accès</span>
                    </li>

                    <li>
                        <label for="name">Demande d'accès</label>
                        <textarea rows="4" cols="50" type="text" name="demande_acces">                
                        </textarea>
                        <span>Indiquez les demandes d'accès</span>
                    </li>

                    <li>
                        <label for="name">Observations</label>
                        <textarea rows="4" cols="50" type="text" name="observations">              
                        </textarea>
                        <span>Indiquez les différentes observations relatives au Datacenter</span>
                    </li>

                    <li>
                        <input type="submit" name="ajouter" value="Ajouter" >
                    </li>
                </ul>
            </form>
                    </div>
            </section>
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
<!-- Style global de la page -->
<style>
    .corps {
        margin-block-end: 3%;
    }

    .top h1 {
        margin: 0;
        text-align: center;
        color: black;
        font-size: 250%;
        margin-right : 16vh;
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
        float: left;
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



<?php require_once('../base/footer.php'); ?>