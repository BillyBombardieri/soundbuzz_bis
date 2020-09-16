<?php require_once('base/init.php'); ?>
<?php require_once('base/head.php') ?>
<?php require_once('base/navbar.php'); ?>
    
<main role="main">
<div class="container">
 
  <div class="row">
    <div class="col-md-4">
      <h2 class="text_center">Jukebox (aléatoire)</h2>
       <a href="random.php">
      <img class='img-thumbnail' src="https://images.vexels.com/media/users/3/151073/isolated/preview/83903592c7d266f29a91c94f15126594-jukebox-machine-illustration-by-vexels.png" action='www.spotify.com'}'>
      </a></p>
    </div>
    <div class="col-md-4">
      <h2 class="text_center">Les plus écoutées</h2>
      <a href="top.php">
      <img class='img-thumbnail' src="http://www.radioandmusic.com/sites/www.radioandmusic.com/files/images/biz/2014/11/01/Top-100-Songs-2014-List.jpg"}'>
      </a></p>
    </div>
    <div class="col-md-4">
      <h2 class="text_center">Playlist</h2>
      <a href="playlist.php">
      <img class='img-thumbnail' src="https://listenx.com.br/blog/wp-content/uploads/2018/10/Depositphotos_63653511_s-2015.jpg">
      </a></p>
    </div>
  </div>

  <hr>

</div> <!-- /container -->


</main>
<style>

    .middle h1 {
        margin: 0;
        text-align: center;
        color: black;
        font-size: 250%;
    }

    .middle b {
        color: rgb(255,121,0);
    }

    .middle h2 {
        margin: 0;
        text-align: center;
        color: black;
    }

    .col-md-4 {
        -ms-flex: 0 0 30%;
        flex: 0 0 30%;
        max-width: 30%;
        padding-left: 20px;
    }
    .container {
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
    }
    .img-thumbnail {
        padding: 0rem;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        max-width: 100%;
        height: auto;
        max-height: 470px;
    }
    .text_center {
        text-align: center;
        padding-right: 75px;
    }

    .row {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }

    .top a {
        position: relative;
        text-decoration : none;
        color : white;
        font-size : 15px;
    }

    .top a img {
        float :left;
        color : white;
        font-size : 15px;
        width : 13vh;
    }

    .corps {
        display: grid;
        grid-template-columns: repeat(6,16.5%);
        justify-items: center;
        align-items: center;
        margin-block-end: 3%;
    }

    .fournisseur a {
        text-decoration: none;
        text-align: center;
        min-height: 10em;
        display: table-cell;
        vertical-align: middle;
    }

    .info {
        text-align:center;
    }



    .dropbtn {
    background-color: rgb(255,121,0);
    color: white;
    padding: 13px;
    font-size: 14px;
    border: none;
    cursor: pointer;
    width : 17vh;
    margin-bottom : 3vh;
    margin-top : 2vh;
    float : right;
    margin-right : 10px;
    text-align : center;
    }

    .dropbtn2 {
    background-color: rgb(255,121,0);
    color: white;
    padding: 13px;
    font-size: 13px;
    border: none;
    cursor: pointer;
    width : 15vh;
    margin-bottom : 3vh;
    margin-top : 2vh;
    float : right;
    margin-right : 10px;
    }

    .dropdown {
    position: relative;
    display: inline-block;
    float: right;
    margin-right: 10px;
    }

    .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 100px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    }

    .dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    }

    .dropdown-content a:hover {
        background-color: #ddd;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown:hover .dropbtn {
        background-color: rgb(255,100,0);
    }

    .dropDown {
    position: relative;
    display: inline-block;
    float: left;
    margin-top: 0.5vh;
    margin-left: 5px;
    }
</style>
<?php require_once('base/footer.php');  ?>