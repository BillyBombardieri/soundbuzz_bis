<?php 
    $prenom = $_SESSION['utilisateur']['prenom'];  
    $admin = $_SESSION['utilisateur']['droit'];
?>
<header>
    <nav>
        <ul>
        <!-- Côté gauche de la Navbar -->
            <div class="gauche">
                <a href="../accueil.php"><img src="../logo/logo-orange.png" alt=""></a>
                <a href="../accueil.php"><h2 class="titre">Bonjour</h2></a>
                <a href="../accueil.php"><h2><?= $prenom ?></h2></a>
            </div>
            <!-- Côté droit de la Navbar -->
            <div class="droite">
            <?php if ($admin == 1) { ?>
                            <div class ="buttonn3">
                                <a href="../before_demande.php">Demande</a>
                            </div>
                <?php } elseif ($admin == 2) { ?>
                            <div class="buttonn3">
                                <a href="../crossco.php">CrossConnect</a>
                            </div>
                <?php } elseif ($admin == 3) { ?>
                            <div class ="buttonn2">
                                <a href="gestion_demande.php">Demande</a>
                            </div>
                            <div class ="buttonn2">
                                <a href="gestionUser.php">ADMIN</a>
                            </div>
                            <div class ="buttonn1">
                                <a href="../maListe.php">Ma Liste</a>
                            </div>
                            <div class="buttonn2">
                                <a href="../crossco.php">CrossConnect</a>
                            </div>
                <?php } ?>
                <div class="buttonn2">
                    <a href="../connexion.php?action=deconnexion">Déconnexion</a>
                </div>
            </div>
        </ul> 
    </nav>
</header>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    .buttonn3 {
    background-color: rgb(255, 121, 0); 
    border: none;
    color: black;
    padding: 16px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 19px;
    margin: 4px 2px;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
    cursor: pointer;
    width: 105px;
    height: 22px;
    margin-top: auto;
    margin-left : auto;
    }

    .buttonn3 {
    background-color: black; 
    color: black; 
    border: 2px solid rgb(255, 121, 0);
    }

    .buttonn3:hover {
    background-color: rgb(255, 121, 0);
    color: white;
    }

    .buttonn3 a {
        text-decoration : none;
        color : white;
    }

    .buttonn1 {
    background-color: rgb(255, 121, 0); 
    border: none;
    color: black;
    padding: 16px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 19px;
    margin: 4px 2px;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
    cursor: pointer;
    width: 105px;
    height: 22px;
    margin-top: auto;
    }

    .buttonn1 {
    background-color: black; 
    color: black; 
    border: 2px solid rgb(255, 121, 0);
    }

    .buttonn1:hover {
    background-color: rgb(255, 121, 0);
    color: white;
    }

    .buttonn1 a {
        text-decoration : none;
        color : white;
    }

    .buttonn2 {
    background-color: rgb(255, 121, 0); 
    border: none;
    color: black;
    padding: 16px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 19px;
    margin: 4px 2px;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
    cursor: pointer;
    width: 105px;
    height: 22px;
    margin-top: auto;
    }

    .buttonn2 {
    background-color: black; 
    color: black; 
    border: 2px solid rgb(255, 121, 0);
    }

    .buttonn2:hover {
    background-color: rgb(255, 121, 0);
    color: white;
    }

    .buttonn2 a {
        text-decoration : none;
        color : white;
    }

    header nav {
        background-color: black;
        height: 15vh;
    }

    header nav ul {
        display: grid;
        grid-template-columns: 50% 50%;
    }


    .gauche a img {
        height: 10vh;
        width: auto;
        margin-top: 2vh;
    }

    .titre {
        color: rgb(255, 121, 0);
        margin-top: 9.5vh;
        margin-right: -4%;
        margin-left: 4%;
    }

    .gauche a {
        margin-left: 2%;
        margin-right: 1%;
        text-decoration: none;
    }

    nav ul div h2 {
        color: white;
        margin-top: 9.5vh;
    }

    .droite {
        float : right;
        margin-right : 1.5vh;
    }

    .droite h2 a {
        color: white;
        text-decoration: none;
        margin-top: 8vh;
        margin-right : 6vh;
    }

    nav ul div {
        display: inline-flex;;
    }

    .profil {
        margin-left: 52%;
    }

    .deconnexion {
        margin-right: 5%;
        margin-left: 8%;
    }
</style>

<style>
    @media (min-width: 1000px) and (max-width: 1199px) {
        .gauche a img {
        height: 11vh;
        width: auto;
        margin-top: 2vh;
        }
        .profil {
        margin-left: 42%;
        }
    }

    @media (min-width: 1200px) and (max-width: 1300px) {
        .gauche a img {
        height: 11vh;
        width: auto;
        margin-top: 2vh;
        }
        .profil {
        margin-left: 50%;
        }
    }

    @media (min-width: 1400px) and (max-width: 1600px) {
        .gauche a img {
        height: 11vh;
        width: auto;
        margin-top: 2vh;
        }
        .profil {
        margin-left: 52%;
        }
    }
</style>