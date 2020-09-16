<?php 
    require_once('../base/init.php');
    require_once('../PHPExcel/Classes/PHPExcel.php');
    if ( !enLigne() ){ 
        header('location:../connexion.php');
        exit();
    }
    //Récupère le niveau d'admin de la session actuelle
    $verifAdmin = $_SESSION['utilisateur']['droit'];

    if ($verifAdmin == 2 || $verifAdmin == 3) {
        require_once('../base/head2.php');
        require_once('../base/navbar2.php');

        $requete= $orange ->prepare("SELECT DISTINCT site_crossco FROM telehouse");
        $requete->execute();
        $all_site_crossco = $requete->fetchAll(PDO::FETCH_ASSOC);

        $nbCrossco= $orange ->prepare("SELECT COUNT(reference_crossco) FROM telehouse");
        $nbCrossco->execute();
        $nbCrossco = $nbCrossco->fetchAll(PDO::FETCH_ASSOC);
        $nbCrossco = $nbCrossco[0]["COUNT(reference_crossco)"];
?>
<body>
<main>
    <?php require_once('../base/navbar2.php');?>   
    <section class="top">
        <div class="dropdown">
            <a href="telehouse.php" class="dropdown"><button class="dropbtn">Retour</button></a><br><br>
        </div>
        <br><br>
        <div>
            <h1>Nombre global de Cross Connects Téléhouse : <?php echo($nbCrossco) ?></b></h1>
        </div><br><br>
    </section>
</main>
</body>
<?php    
$dataPoints1 = array();
$dataPoints2 = array();
    foreach($all_site_crossco as $site_crossco){ 

        $site_crossco= $site_crossco['site_crossco'];

        $cuivre= $orange ->prepare("SELECT COUNT(type_cable) FROM telehouse WHERE type_cable='cuivre' AND site_crossco='$site_crossco' ");
        $cuivre->execute();
        $cuivre = $cuivre->fetchAll(PDO::FETCH_ASSOC);
        $cuivre= $cuivre[0]["COUNT(type_cable)"];

        $fibre= $orange ->prepare("SELECT COUNT(type_cable) FROM telehouse WHERE type_cable='fibre' AND site_crossco='$site_crossco' ");
        $fibre->execute();
        $fibre = $fibre->fetchAll(PDO::FETCH_ASSOC);
        $fibre= $fibre[0]["COUNT(type_cable)"];

        $dataPoints1[] = array("label"=> $site_crossco, "y"=> $cuivre);
        $dataPoints2[] = array("label"=> $site_crossco, "y"=> $fibre);
    }   
?>

<html>
<head>  
<script>
    window.onload = function () {
        
    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        theme: "light2",
        title:{
            text: "Nombre de Cross Connects par site"
        },
        axisY:{
            includeZero: true
        },
        legend:{
            cursor: "pointer",
            verticalAlign: "center",
            horizontalAlign: "right",
            itemclick: toggleDataSeries
        },
        data: [{
            type: "column",
            name: "Cuivre",
            indexLabel: "Cuivre - {y}",
            yValueFormatString: "#,##0.##",
            showInLegend: true,
            dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
        },{
            type: "column",
            name: "Fibre",
            indexLabel: "Fibre - {y}",
            yValueFormatString: "#,##0.##",
            showInLegend: true,
            dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart.render();
        
    function toggleDataSeries(e){
        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        }
        else{
            e.dataSeries.visible = true;
        }
        chart.render();
    }
        
    }
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; max-width: 1300px; margin: 0px auto;"></div>
<script src="../canvasjs.min.js"></script>
</body>
</html>  
<?php                        
} elseif ($verifAdmin == 1) { ?>
    <body class="noir">
        <div class="blanc">
            <a href="../accueil.php" class="img"><img src="../logo/logo-orange.png" alt=""></a>
            <p class="p_erreur"> Vous n'avez pas accès à ce contenu, veuillez cliquer sur l'image afin d'être redirigé</p>
        </div>
    </body> 
<?php } ?>

<!-- Style du formulaire -->
<style type="text/css">
    .form-style-7{
        max-width:65vh;
        margin:50px auto;
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
        margin-right : 16vh;
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
        cursor: pointer;
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
        width: 80%;
        height: 67vh;
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
        font-size: 15px;
        border: none;
        margin-block-end: 2%;
        margin-right :50vh;
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
<?php require_once('../base/footer2.php');