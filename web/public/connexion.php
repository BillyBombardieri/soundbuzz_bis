<?php 
    require_once('base/init.php'); 
    $connex = '';
    //Deconnexion 
    if( isset($_GET['action']) && $_GET['action'] == 'deconnexion' ){
        session_destroy();
    }
    if( enLigne() ){

        header('location:accueil.php');
        exit();
    }
    if( $_POST ){
        $r = $orange->query("SELECT * FROM utilisateur WHERE code_alliance = '$_POST[code_alliance]' ");
        //Si il y a une correpondance d'un code alliance dans la table 'utilisateur', $r renverra '1' ligne de résultat
        if( $r->rowCount() >= 1){
            $utilisateur = $r->fetch(PDO::FETCH_ASSOC);
            if( password_verify( $_POST['mdp'], $utilisateur['mdp']) ){
                $_SESSION['utilisateur']['id_utilisateur'] = $utilisateur['id_utilisateur'];
                $_SESSION['utilisateur']['code_alliance'] = $utilisateur['code_alliance'];
                $_SESSION['utilisateur']['mail'] = $utilisateur['mail'];
                $_SESSION['utilisateur']['mdp'] = $utilisateur['mdp'];
                $_SESSION['utilisateur']['prenom'] = $utilisateur['prenom'];
                $_SESSION['utilisateur']['nom'] = $utilisateur['nom'];
                $_SESSION['utilisateur']['droit'] = $utilisateur['droit'];
                session_start();
                header('location:accueil.php');
            }
            else{
                $connex .= '<div style="color:red;text-align:center;">Mot de passe incorrect</div>';
            }
        }
        else{
            $connex .= '<div style="color:red;text-align:center;">Code Alliance non valide</div>';
        }
    }
    
    require_once('base/head.php') 
?>
<body>
    <?php require_once('base/navbar_base.php'); ?>
    <section>
        <h1>GESTION DES <b>DATACENTERS TIERS</b></h1><br>
        <p><b>Identifiez-vous</b>
        pour accéder aux informations des Datacenters Tiers</p>
        <br><br>
        <?php echo $connex; ?>
        <br>
        <!-- Formulaire de connexion -->
        <form class="form-style-7" method="post" action=""  enctype="multipart/form-data">
            <ul>
                <li>
                    <label for="">Code Alliance</label>
                    <input type="text" name="code_alliance" maxlenght="100">
                    <span>Entrez votre code Alliance</span>
                </li>

                <li>
                    <label for="" name="">Mot de Passe</label>
                    <input type="password" name="mdp" maxlenght="100">
                    <span>Entrez votre mot de passe</span>
                </li>

                <li>
                    <input type="submit" name="" value="Se connecter">  
                </li>
            </ul>
        </form><br><br><br>
        <p><a href="inscription.php">Inscription</a></p><br>
        <p><a href="forgot_password.php">Mot de passe oublié</a>
    </section>
</body>

<script type="text/javascript">
    //auto expand textarea
    function adjust_textarea(h) {
        h.style.height = "20px";
        h.style.height = (h.scrollHeight)+"px";
    }
</script>

<!-- Style du formulaire -->
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
        display: block;
        outline: none;
        border: none;
        height: 45px;
        line-height: 25px;
        font-size: 18px;
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
<!-- Style global -->
<style>
    body {
        margin: 0;
        padding: 0;
    }

    section h1 {
        margin-top: 2%;
        text-align: center;
        font-size: 300%;
    }

    section b {
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

    button {
        font-size: 70%;
    }

    p a:link, a:visited {
        background-color: black;
        color: white;
        padding: 14px 25px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
}

    p a:hover, a:active {
        background-color: rgb(255,121,0);
}
</style>
<?php require_once('base/footer.php');  ?>