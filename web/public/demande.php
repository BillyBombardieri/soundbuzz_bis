<?php 
    require_once('base/init.php');
    if ( !enLigne() ){ 
        header('location:connexion.php');
        exit();
    } 
    //recupere tout les DC liés à leur fournisseurs
    $requete = $orange->prepare(" SELECT * FROM datacenter, fournisseur WHERE datacenter.id_fournisseur=fournisseur.id_fournisseur"); 
    $requete->execute(); 
    $nomdcs = $requete->fetchAll(PDO::FETCH_ASSOC);

    //recupere tout les mails des Admins de niveau 3
    $requete = $orange->prepare(" SELECT mail FROM utilisateur WHERE droit=3"); 
    $requete->execute(); 
    $mailsAdminNV3 = $requete->fetchAll(PDO::FETCH_ASSOC);
    
    //On récupère le niveau de droit d'admin de l'utilisateur de la session
    $admin = $_SESSION['utilisateur']['droit'];

    // On récupère l'ID, le mail et le nom de l'utilisateur de la session
    $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur']; 
    $mail_user = $_SESSION['utilisateur']['mail']; 
    $nom_user = $_SESSION['utilisateur']['nom'];
?>
<?php if ($admin == 1) { 
    require_once('base/head.php');
    require_once('base/navbar.php');
    ?>
    <body>    
        <section class="top">
            <div class="dropbtn3">
                <a href="fonction/view_demande.php">Voir Demande</a>
            </div>
            <div class="dropdown">
                <a href="before_demande.php" class="dropdown"><button class="dropbtn">Retour</button></a><br><br>
            </div>
            <h1>Réalisation d'une demande</h1>
            <form class="form-style-7-7" method="post">
                <ul class="form-style-7-7">
                    <li class="form-style-7-7">
                        <label for="name" class="form-style-7-7">Type de demande</label>
                        <select name="choix">
                            <option value="accesdc">Accès Datacenter</option>
                            <option value="question">Autre demande ou question</option>
                        </select>
                        <span class="form-style-7-7">Indiquez votre type de demande</span>
                    </li>
                    <li class="form-style-7-7">
                    <a href="demande2.php"><button class="dropbtn2" name="valider">Valider le choix de demande</button></a>
                    </li>
                </ul>
            </form>
            <?php 
            if (isset($_POST['valider'])){ ?>
                <form class="form-style-7" method="post">
                    <ul>
                        <?php
                        // Si le choix est une demande d'accès à un DC
                        if ($_POST['choix'] == "accesdc"){
                        ?>
                        <li>
                            <label for="name">Nom Datacenter</label>
                            <select name="nomdc">
                            <?php
                                // Boucle qui génère tout les choix possible de DC associé à son fournisseur
                                foreach($nomdcs as $nom)
                                { 
                                    if(!empty($nom['nom_dc'])){
                                        ?>
                                    <option value="<?= $nom['nom_dc'].",". $nom['nom_fournisseur'] ?>"><?php echo ($nom['nom_dc']." / ".$nom['nom_fournisseur']); ?></option> 
                                <?php
                                    } 
                                }
                                ?>
                            </select>
                            <span>Indiquez le nom du Datacenter</span>
                        </li>
                        <li>
                            <label for="name">Nom</label>
                            <input type="text" name="nom">
                            <span> Entrez le nom du technicien </span>
                        </li>
                        <li>
                            <label for="name">Prénom</label>
                            <input type="text" name="prenom">
                            <span> Entrez le prénom du technicien</span>
                        </li>
                        <li>
                            <label for="name">Adresse Mail</label>
                            <input type="email" name="mail">
                            <span> Entrez le mail du technicien </span>
                        </li>
                        <li>
                            <label for="name">Téléphone</label>
                            <input type="text" name="tel">
                            <span> Entrez le numéro de téléphone du technicien </span>
                        </li>
                        <?php
                        }
                        // Formulaire si le choix est une question
                        if ($_POST['choix'] == "question"){
                        ?>
                        <li>
                            <label for="name">Sujet de la question</label>
                            <input type="text" name="question_sujet"></input>
                            <span>Entrez le sujet de la question</span>
                        </li>
                        <li>
                            <label for="name">Question / Demande diverses</label>
                            <textarea rows="4" cols="50" type="text" name="question_demande"></textarea>
                            <span>Entrez une question claire et synthétique</span>
                        </li>
                        <?php
                        }
                        ?>
                        <li>
                            <input type="submit" name="enregistrer" value="Envoyer" >
                        </li>
                    </ul>
                </form>
            <?php
            }
            // Si c'est pour un accès DC :
            if (isset($_POST['enregistrer']) && isset($_POST['tel'])){
                // On rcupère le select 
                $nomFour=$_POST['nomdc'];

                // On récupère la date exact afin de la stocker en BDD
                $date= date('Y-m-d H:i');
                $type= "Accès DC";
                $statut= "En cours de traitement";

                // On cut le string en deux grâce à la virgule afin de récupèrer séparément le nom du Dc et le nom du fournisseur
                $good_array= explode(",", $nomFour);
                $good_Four=$good_array[1];
                $good_DC=$good_array[0];

                // On récupère l'ID de l'admin en charge du Fournisseur en question
                $prepare = $orange->prepare(" SELECT id_utilisateur FROM fournisseur WHERE nom_fournisseur='$good_Four' ");
                $prepare->execute();
                $idAdmin = $prepare->fetchAll(PDO::FETCH_ASSOC);
                // On stock l'ID dans un string
                foreach ($idAdmin as $idAdmi){
                    $good_id=$idAdmi['id_utilisateur'];
                };

                // On récupère le mail de l'admin en question grâce à l'ID
                $prepare = $orange->prepare(" SELECT mail FROM utilisateur WHERE id_utilisateur=$good_id ");
                $prepare->execute();
                $mailAdmin = $prepare->fetchAll(PDO::FETCH_ASSOC); 
                // Puis on le stock
                foreach ($mailAdmin as $mailAdmi){
                    $good_mail=$mailAdmi['mail'];
                };

                // Variable pour le sujet du mail
                $subject="Accès du DC : ".$good_DC." de ".$good_Four;

                // Variable pour le contenu du message du mail
                $message="Pour le technicien suivant : ".$_POST['nom']." ".$_POST['prenom']."\n Mail du Technicien : ".$_POST['mail']."\n Numéro de téléphone : "
                                                        .$_POST['tel']."\n Demande réalisé par : ".$_SESSION['utilisateur']['nom']." ".$_SESSION['utilisateur']['prenom']."\n Pour prendre en charge la demande, merci de cliquer sur ce lien : gestiondatacenter.com.intraorange/fonction/one_demande.php?date=".$date;
                // Envoie du mail
                if($mailAdmin!=NULL){
                    mail($good_mail, $subject, $message);
                }
                // Envoie le mail à tout les admins de niveau 3 si le DC correspond à un DC non attribué à une liste d'admin
                if($mailAdmin==NULL){
                    foreach ($mailsAdminNV3 as $mailAdminNV3){
                        $mailto= $mailAdminNV3['mail'];                
                        mail($mailto, $subject, $message);
                    }
                }

                //Insertion en BDD de la demande
                $tht= $orange ->prepare("INSERT INTO demande (mail_demande, nom_user, sujet_mail, type_demande, statut, date, id_utilisateur) VALUES (:mail_demande, :nom_user, :sujet_mail, :type_demande, :statut, :date, :id_utilisateur)");
                $tht->bindParam(':mail_demande', $mail_user);
                $tht->bindParam(':nom_user', $nom_user);
                $tht->bindParam(':sujet_mail', $subject);
                $tht->bindParam(':type_demande', $type);
                $tht->bindParam(':statut', $statut);
                $tht->bindParam(':date', $date);
                $tht->bindParam(':id_utilisateur', $id_utilisateur);
                $tht->execute();
            }
            //Si c'est pour une question :
            if (isset($_POST['enregistrer']) && isset($_POST['question_demande'])){ 

                // On récupère la date exact afin de la stocker en BDD
                $date= date('Y-m-d H:i');
                $type= "Question/Demande";
                $statut= "En cours de traitement";

                // Variable pour le sujet du mail
                $subject= $_POST['question_sujet'];

                // Variable pour le contenu du message du mail
                $message= $_POST['question_demande']."\n Pour prendre en charge la demande, merci de cliquer sur ce lien : gestiondatacenter.com.intraorange/fonction/one_demande.php?date=".$date;

                // Envoie du mail
                foreach ($mailsAdminNV3 as $mailAdminNV3){
                    $mailto= $mailAdminNV3['mail'];                
                    mail($mailto, $subject, $message);
                }
                //Insertion en BDD de la demande
                $tht= $orange ->prepare("INSERT INTO demande (mail_demande, nom_user, sujet_mail, type_demande, statut, date, id_utilisateur) VALUES (:mail_demande, :nom_user, :sujet_mail, :type_demande, :statut, :date, :id_utilisateur)");
                $tht->bindParam(':mail_demande', $mail_user);
                $tht->bindParam(':nom_user', $nom_user);
                $tht->bindParam(':sujet_mail', $subject);
                $tht->bindParam(':type_demande', $type);
                $tht->bindParam(':statut', $statut);
                $tht->bindParam(':date', $date);
                $tht->bindParam(':id_utilisateur', $id_utilisateur);
                $tht->execute();
            }
            ?>
        </section>
    </body>
<?php } elseif ($admin == 2 || $admin == 3) { ?>
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
        margin:15px auto;
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
    } 
    .form-style-7 textarea {
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        width: 100%;
        display: block;
        outline: none;
        border: none;
        height: 100px;
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
        font-size: 12px;
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
        color: white;
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

    .dropbtn3 {
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
<style type="text/css">
    .dropbtn2 {
        background-color: rgb(255,121,0);
        color: white;
        padding: 13px;
        font-size: 13px;
        border: none;
        cursor: pointer;
        margin-bottom: 1vh;
        width : 17vh;
        <?php if(isset($_POST['valider'])){ ?>
        display:none;    
        <?php } ?>
     }
    .form-style-7-7{
        max-width:65vh;
        margin:0px auto;
        margin-top: 15px;
        background:#fff;
        border-radius:2px;
        padding:20px;
        font-family: Georgia, "Times New Roman", Times, serif;
        <?php if(isset($_POST['valider'])){ ?>
        display:none;    
        <?php } ?>
    }
    .form-style-7-7 h1{
        display: block;
        text-align: center;
        padding: 0;
        margin: 0px 0px 20px 0px;
        color: black;
        font-size:x-large;
        <?php if(isset($_POST['valider'])){ ?>
        display:none;    
        <?php } ?>
    }
    .form-style-7-7 ul{
        list-style:none;
        padding:0;
        margin:0;
        <?php if(isset($_POST['valider'])){ ?>
        display:none;    
        <?php } ?>	
    }
    .form-style-7-7 li{
        display: block;
        padding: 9px;
        border:1px solid black;
        margin-bottom: 30px;
        border-radius: 3px;
        <?php if(isset($_POST['valider'])){ ?>
        display:none;    
        <?php } ?>
    }
    .form-style-7-7 li:last-child{
        border:none;
        margin-bottom: 0px;
        text-align: center;
        <?php if(isset($_POST['valider'])){ ?>
        display:none;    
        <?php } ?>
    }
    .form-style-7-7 li > label{
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
        <?php if(isset($_POST['valider'])){ ?>
        display:none;    
        <?php } ?>
    }
    .form-style-7-7 input[type="text"],
    .form-style-7-7 input[type="date"],
    .form-style-7-7 input[type="datetime"],
    .form-style-7-7 input[type="email"],
    .form-style-7-7 input[type="number"],
    .form-style-7-7 input[type="search"],
    .form-style-7-7 input[type="time"],
    .form-style-7-7 input[type="url"],
    .form-style-7-7 input[type="file"],
    .form-style-7-7 input[type="password"],
    .form-style-7-7 textarea,
    .form-style-7-7 select 
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
        <?php if(isset($_POST['valider'])){ ?>
        display:none;    
        <?php } ?>
    } 
    .form-style-7-7 li > span{
        background: rgb(255,121,0);
        display: block;
        padding: 3px;
        margin: 0 -9px -9px -9px;
        text-align: center;
        color: black;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11px;
        margin-top: 3px;
        <?php if(isset($_POST['valider'])){ ?>
        display:none;    
        <?php } ?>
    }
    .form-style-7-7 textarea{
        resize:none;
    }
    .form-style-7-7 input[type="submit"],
    .form-style-7-7 input[type="button"]{
        background:black;
        border: none;
        padding: 10px 20px 10px 20px;
        border-bottom: 3px solid rgb(255,121,0);
        border-radius: 3px;
        color: white;
        <?php if(isset($_POST['valider'])){ ?>
        display:none;    
        <?php } ?>
    }
    .form-style-7-7 input[type="submit"]:hover,
    .form-style-7-7 input[type="button"]:hover{
        background: rgb(255,121,0);
        color:white;
        <?php if(isset($_POST['valider'])){ ?>
        display:none;    
        <?php } ?>
    }
</style>
<?php require_once('base/footer.php');?>