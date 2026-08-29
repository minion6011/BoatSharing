<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BoatSharing | Viaggia condividendo</title>
    <link rel="icon" href="assets/images/ui/logo.svg"/>
    
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
    <?php
        include("components/navbar.php")
    ?>

    <div class="content">
        <div class="presentation">
            <img src="assets/images/ui/presentation.jpg" alt="Molte barche e yacht in navigazione su acque blu profonde">
            <text>
                Esplora le acque con la <b>barca dei tuoi sogni. <br>
                BoatSharing</b>, il modo più facile per navigare.
            </text>
        </div>

        <div class="side-sep">
            <p class="title">In Evidenza</p>
            <a class="link" href="catalog.php">
                Vedi tutti
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
        <div class="boats">
            <?php
                require_once "main.php";

                $imgpath = $ini["Paths"]["boatimgs"];

                $sql = "SELECT * FROM boats ORDER BY id LIMIT 4";
                $result = $conn -> query($sql);

                foreach ($result->fetchAll(PDO::FETCH_OBJ) as $row) {
            ?>
                <div class='card'>
                    <img src='<?= $imgpath . $row->img; ?>' alt='Foto barca'>
                    <div class='infos'>
                        <p class='name'><?= $row->name; ?></p>

                        <div class='location'>
                            <i class='fa fa-map-marker'></i>
                            <p><?= $row->start_city; ?>, <?= $row->start_cap; ?></p>
                        </div>

                        <div class='location'>
                            <i class='fa fa-angle-double-right'></i>
                            <p><?= $row->destination; ?></p>
                        </div>
                        
                        <form action='chat.php' method='POST'>
                            <input type='hidden' name='_method' value='POST'>
                            
                            <input type='hidden' value='<?= $row->id; ?>' name='id'>
                            <input type='hidden' value='<?= $row->userid; ?>' name='userid'>

                            <button type='submit'>
                                <i class='fa fa-phone'></i>
                                Contatta
                            </button>
                        </form>
                    </div>
                </div>
            <?php
                }
            ?>
        </div>
        </div>
    </div>

    <br><br>

    <?php
        include("components/footer.php")
    ?>
</body>
</html>