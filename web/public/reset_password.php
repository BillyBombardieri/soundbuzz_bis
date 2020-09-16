<?php 
    require_once('base/init.php'); 
    $errormdp='';
    $inscrip = '';  
    $error = '';
    if( enLigne() ){
        header('location:accueil.php');
        exit();
    }
    if(isset($_GET['id_utilisateur'])){
        $id_utilisateur= $_GET['id_utilisateur'];

        if( $_POST ){ 
            if(!empty($_POST['mdp']) && !empty($_POST['confirm_mdp']) ) {
                if( $_POST['confirm_mdp'] == $_POST['mdp'] ) {
                    $_POST['mdp'] = password_hash( $_POST['mdp'], PASSWORD_DEFAULT );
                    $orange->exec("UPDATE utilisateur SET  mdp ='$_POST[mdp]' WHERE id_utilisateur=");
                    $inscrip .= '<div style="color:green;text-align:center;">Changement validé ! <a href="connexion.php">Cliquez ici pour vous connecter</a></div>';
                }
                else {
                    $errormdp .= '<div style="color:red;text-align:center;">Les deux mots de passe ne sont pas identiques</div>';
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
            <p><b>Entrez votre nouveau mot de passe</b></p><br><br>
            <br>
            <!-- Formulaire d'inscription -->
            <form method="post" class="form-style-7" action=""  enctype="multipart/form-data">
                <ul>
                    <li>
                        <label for="mdp">Nouveau Mot de Passe</label>
                        <input type="password" name="mdp"><br><br>
                        <span> Entrez votre mot de passe </span>
                    </li>
                    <li>
                        <label for="">Confirmer le mot de Passe</label>
                        <input type="password" name="confirm_mdp"><br><br>
                        <span> Entrez à nouveau le mot de passe</span>
                    </li>
                    <li>
                        <input type="submit" name="" value="S'inscrire">
                    </li>
            </form>
        </section>
    </body> 
    
<?php  } else { ?>
    <body class="noir">
        <div class="blanc">
            <a href="connexion.php" class="img"><img src="logo/logo-orange.png" alt=""></a>
            <p class="p_erreur"> Vous n'avez pas accès à ce contenu, veuillez cliquer sur l'image afin d'être redirigé</p>
        </div>
    </body> 
<?php } ?>
<style>
    body {
        margin: 0;
        padding: 0;
    }

    .p_erreur {
        text-align : center;
        font-size: 16px;

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