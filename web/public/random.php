<?php require_once('base/init.php'); ?>
<?php require_once('base/head.php') ?>
<?php require_once('base/navbar.php'); ?>
<?php 
$prepare = $soundbuzz->prepare("SELECT * FROM music ORDER by rand() limit 1");
$prepare->execute();
$random_song = $prepare->fetchAll(PDO::FETCH_ASSOC);
?>

<h1 id="title_page">Jukebox</h1>

<table id="games_list" class="table" cellpadding="0" cellspacing="0" border="0">
  <thead class="thead-dark" >
    <tr>
        <th scope="col">
             Titre
        </th>
        <th scope="col">
            Artiste
        </th>
        <th scope="col">
            Genre
        </th>
        <th scope="col">
            Date de sortie
        </th>
        <th scope="col">
           Durée du morceau
        </th>
        <th scope="col">
            Ajouter à une playlist
        </th>

    </tr>
  </thead>
    <tbody class="thead-light">
        <?php foreach ($random_song as $random): ?>
            <div class="music">         
                <?php if(!empty($random["id_music"])): ?>
                    <tr>
                        <td class="text_center"><?php echo $random["titre_morceau"]; ?></td>
                        <td class="text_center"><?php echo $random["artiste"]; ?></td>
                        <td class="text_center"><?php echo $random["genre"]; ?></td>
                        <td class="text_center"><?php echo $random["date_creation"]; ?></td>
                        <td class="text_center"><?php echo $random['duree_morceau']; ?></td>
                    </tr> 
                    <?php endif ?> 
            </div>
            </tr>
        <?php endforeach ?> 
    </tbody>
</table> 


<audio controls="controls">
  <source src="musics/11-XS.mp3" type="audio/mp3" />
  Votre navigateur n'est pas compatible
</audio>

<style>

.table {
  width: 100%;
  margin-bottom: 1rem;
  color: #212529;
}

.table th,
.table td {
  padding: 0.75rem;
  vertical-align: top;
  border-top: 1px solid #dee2e6;
}

.text_center {
        text-align: center;
        padding-right: 75px;
}


.table thead th {
  vertical-align: bottom;
  border-bottom: 2px solid #dee2e6;
}

.table tbody + tbody {
  border-top: 2px solid #dee2e6;
}

.table-sm th,
.table-sm td {
  padding: 0.3rem;
}

.table-bordered {
  border: 1px solid #dee2e6;
}

.table-bordered th,
.table-bordered td {
  border: 1px solid #dee2e6;
}

.table-bordered thead th,
.table-bordered thead td {
  border-bottom-width: 2px;
}
</style>