<?php 
    require_once('base/init.php'); 
    $errormdp='';
    $inscrip = '';  
    $error = '';
    if( enLigne() ){
        header('location:accueil.php');
        exit();
    }
    //Verification des données saisies dans le formulaire + validation et enregistrement en BDD
    if( $_POST ){ 
        if(!empty($_POST['code_alliance'])  && !empty($_POST['mail'])) {
            $r = $orange->prepare("SELECT id_utilisateur FROM utilisateur WHERE code_alliance = '$_POST[code_alliance]' AND mail = '$_POST[mail]' ");
            $r->execute(); 
            if($r == NULL ){
                $inscrip .= '<div style="color:red;text-align:center;">Aucun Code Alliance n\'est associé à cet Email</div>';
            }
            if($r != NULL ) {
                $good_mail=$_POST['mail'];
                $r = $r->fetchAll(PDO::FETCH_ASSOC);
                $r= $r[0]["id_utilisateur"];
                // Variable pour le sujet du mail
                $subject="Reinitialisation de votre Mot de Passe";

                // Variable pour le contenu du message du mail
                $message="Merci de bien vouloir cliquer sur ce lien afin de saisir votre nouveau mot de passe : http://localhost:8080/portail/reset_password.php?id_utilisateur=".$r;
                // Envoie du mail
                 mail($good_mail, $subject, $message);
                 $inscrip .= '<div style="color:green;text-align:center;">Mail envoyé avec succès !</div>';
            }
        }
        else {
            $error .= '<div style="color:red;text-align:center;">Veuillez remplir tous les champs</div>';
        }
    }
    require_once('base/head.php') 
?>
<body>
    <?php require_once('base/navbar_base.php'); ?>
    <section class= "top">
    <div class="dropbtn2">
        <a href="connexion.php">Retour</a><br><br>
</section>
    </top>
    <section>
        <h1>GESTION DES <b>DATACENTERS TIERS</b></h1><br>
        <p><b>Réinitilisation du Mot de Passe</b></p><br><br>
        <!-- Formulaire d'inscription -->
        <form method="post" class="form-style-7" action=""  enctype="multipart/form-data">
            <ul>
                <li>
                    <label for="code_alliance">Code alliance</label>
                    <input type="text" name="code_alliance"><br><br>
                    <span> Entrez votre code alliance </span>
                </li>
                <li>
                    <label for="mail">Adresse Mail</label>
                    <input type="email" name="mail"><br><br>
                    <span> Entrez votre email </span>
                </li>
                <li>
                    <input type="submit" name="" value="Envoyer">
                </li>
        </form>
    </section>
</body>       
<style>
    body {
        margin: 0;
        padding: 0;
    }

    h1 {
        margin-top: 2%;
        text-align: center;
        font-size: 300%;
    }
    b {
        color: rgb(255,121,0);
    }

    section p {
        text-align: center;
        font-size: 130%;
    }

    .formulaire {
        text-align: center;
        font-size: 150%;
    }

    .formulaire input {
        font-size: 50%;
    }



    p a {
        text-align: center;
        font-size: 90%;
    }

    .top a {
        text-decoration: none;
        color: white;
        font-size: 15px;
    }

    .dropbtn2 {
    background-color: rgb(255,121,0);
    color: white;
    padding: 13px;
    border: none;
    cursor: pointer;
    width: 16vh;
    margin-left : 30px;
    margin-top : 13px;
    text-align : center;
    padding-bottom : unset;
    position: relative;
    display: inline-block;
    }
</style>

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
        height: 14px;
        padding: 2px 5px 2px 5px;
        color: black;
        font-size: 16px;
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

<?php require_once('base/footer.php');  ?>