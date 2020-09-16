<?php 
    require_once('../base/init.php');
    if ( !enLigne() ){ 

        header('../location:connexion.php');
        exit();
    }
    $verifAdmin = $_SESSION['utilisateur']['droit'];
    if ($verifAdmin == 3) {
        
        $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];
        //Prepare la requete qui recupere tout les DC d'un fournisseur selon son ID
        $requete = $orange->prepare(" SELECT * FROM utilisateur"); 
?>
<?php require_once('../base/head2.php') ?>
<body>
    <?php require_once('../base/navbar2.php'); ?>
    <main>
        <?php
            $requete->execute(); 
            $users = $requete->fetchAll(PDO::FETCH_ASSOC);
        ?>
    </main>
    <section class="top">
        <div class="dropdown">
            <a href="../accueil.php" class="dropdown"><button class="dropbtn">Accueil</button></a><br><br>
        </div>
        </section>
        <br><br>
        <section class="middle">
            <div>
                <h1>Liste des utilisateurs :</h1>
                <br><br>
            </div>
        </div>
    </section><br><br>

    <section class="corps">
        <table class= "dico">
            <thead>
                <tr>
                    <th>Code Alliance</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Adresse Mail</th>
                    <th>ADMIN</th>
                <?php if ($verifAdmin == 0 || $verifAdmin == 3){ ?>
                    <th>Edit</th>
                <?php } ?>
                </tr>
            </thead>
            <!-- Tableau d'affichage -->
            <?php foreach ($users as $user): ?>
                <div class="datacenter">
                    <?php if(!empty($user["id_utilisateur"])): ?>
                        <?php $id_utilisateur = $user["id_utilisateur"] ?>
                        <?php $id_utilisateur= $user["id_utilisateur"] ?>
                        <tr>
                            <td><?= $user["code_alliance"] ?></td>
                            <td><?= $user["nom"] ?></td>
                            <td><?= $user["prenom"] ?></td>
                            <td><?= $user["mail"] ?></td>
                            <td><?= $user["droit"] ?></td>
                            <?php if ($verifAdmin == 3){ ?>    
                                <td><a href="editUser.php?id_utilisateur=<?php echo $id_utilisateur;?>?&admin=<?php echo $user["droit"];?>?&code_alliance=<?php echo $user["code_alliance"];?>"><img src="../img/edit.png" alt="" width="22px" height="auto"></a></td>
                            <?php } ?>
                        </tr>
                    <?php endif ?>
                </div>
            <?php endforeach ?>
        </table>
    </section>
</body>

<?php
} elseif ($verifAdmin == 1) { ?>
    <body class="noir">
        <div class="blanc">
            <a href="../accueil.php" class="img"><img src="../logo/logo-orange.png" alt=""></a>
            <p class="p_erreur"> Vous n'avez pas accès à ce contenu, veuillez cliquer sur l'image afin d'être redirigé</p>
        </div>
    </body> 
<?php } ?>
<style>
    .corps {
        margin-block-end: 3%;
    }
    .top {
        margin-bottom : 25px;
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
    }

    .middle h1 {
        margin: 0;
        text-align: center;
        color: black;
        font-size: 250%;
    }

    .middle b {
        color: rgb(255,121,0);
    }

    .middle a {
        text-decoration: none;
        color: black;
    }

    .dico {
        border-collapse: collapse;
        width: 80%;
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

    th.thObs {
        padding : 5vh;
    }

    td {
        font-family:sans-serif;
        font-size:85%;
        border:1px solid #6495ed;
        padding:5px;
        text-align:center;
    }

    td a {
        font-size: 150%;
    }
    .dropbtn {
        background-color: rgb(255,121,0);
        color: white;
        padding: 13px;
        font-size: 13px;
        border: none;
        cursor: pointer;
        margin-bottom: 1vh;
        width : 15vh;
    }
    .dropdown {
        position: relative;
        display: inline-block;
        margin-top: 0.5vh;
        margin-left: 5px;
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
</style>
<?php require_once('../base/footer2.php');  ?>