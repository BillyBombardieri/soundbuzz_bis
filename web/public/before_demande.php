<?php 
    require_once('base/init.php');
    if ( !enLigne() ){ 
        header('location:connexion.php');
        exit();
    } 
    //recupere tout les crossconnect
    $requete = $orange->prepare(" SELECT nom_dc, nom_fournisseur FROM datacenter, fournisseur WHERE datacenter.id_fournisseur=fournisseur.id_fournisseur"); 
    $requete->execute(); 
    $nomdcs = $requete->fetchAll(PDO::FETCH_ASSOC); 
    $admin = $_SESSION['utilisateur']['droit'];
    $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur']; 
    
    if ($admin == 1 || $admin == 3) { 
        require_once('base/head.php');
        require_once('base/navbar.php');

        ?>
    <body>    
        <section class="top">
            <div class="dropdown">
                <a href="accueil.php" class="dropdown"><button class="dropbtn">Retour</button></a><br><br>
            </div>
        </section>
        <section class="centre">
            <?php if ($admin == 1) { ?>
                <div class ="button1">
                    <a href="demande.php">Créer une Demande</a>
                </div>
                <div class ="button1">
                    <a href="fonction/view_demande.php">Voir mes Demandes</a>
                </div>
            <?php } elseif ($admin == 3) { ?>
                <div class ="button1">
                    <a href="fonction/gestion_demande.php">Gérer les Demandes</a>
                </div>
            <?php } ?>
        </section>
    </body>
    <?php } elseif ($admin == 2) { ?>
        <body class="noir">
            <div class="blanc">
                <a href="accueil.php" class="img"><img src="logo/logo-orange.png" alt=""></a>
                <p class="p_erreur"> Vous n'avez pas accès à ce contenu, veuillez cliquer sur l'image afin d'être redirigé</p>
            </div>
        </body> 
<?php } ?>
<!-- Style Global -->
<style>
.button1 {
  background-color: rgb(255,121,0);
  border: none;
  color: white;
  padding: 16px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 25px;
  transition-duration: 0.5s;
  cursor: pointer;
  height: 4vh;
}

.button1 {
  background-color: white; 
  color: black; 
  border: 2px solid rgb(255,121,0);
  width: 30vh;
  text-align: center;
}

.button1:hover {
  background-color: rgb(255,121,0);
  color: white;
}

.button1 a {
    text-decoration : none;
    color : black;
}
.centre {
    float : none;
    margin-top: 15px;
    margin-right : auto;
    margin-left: auto;
}
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
<?php require_once('base/footer.php');?>