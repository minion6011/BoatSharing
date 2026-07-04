<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BoatSharing | Viaggia condividendo</title>
    <link rel="icon" href="assets/images/ui/logo.svg"/>
    
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php
        include("components/navbar.php")
    ?>

    <div class="content">
        <div class="presentation">
            <img src="assets/images/ui/presentation.jpg">
            <text>
                Esplora le acque con la <b>barca dei tuoi sogni. <br>
                BoatSharing</b>, il modo più facile per navigare
            </text>
        </div>

        <div class="side-sep">
            <p class="title">In Evidenza</p>
            <a class="link">
                Vedi tutti
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
        <div class="boats">
            <?php
                $ini = parse_ini_file("config.ini", true);

                $servername = $ini["DB"]["servername"];
                $dbname = $ini["DB"]["dbname"];

                $username = $ini["DB"]["username"];
                $password = $ini["DB"]["password"];
                
                $imgpath = $ini["Paths"]["boatimgs"];


                // Create connection
                $conn = mysqli_connect($servername, $username, $password, $dbname);

                if (!$conn) {
                    //die("Connection failed: " . mysqli_connect_error());
                    die();
                }

                $sql = "SELECT * FROM `boats`";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "
                            <div class='card'>
                                <img src='{$imgpath}{$row['img']}'>
                                <div class='infos'>
                                    <p class='name'>{$row['name']}</p>

                                    <div class='location'>
                                        <i class='fa fa-map-marker'></i>
                                        <p>{$row['start_city']}, {$row['start_cap']}</p>
                                    </div>

                                    <div class='location'>
                                        <i class='fa fa-angle-double-right'></i>
                                        <p>{$row['destination']}</p>
                                    </div>

                                    <input type='hidden' value='{$row['userid']}' name='userid'>

                                    <button>
                                        <i class='fa fa-phone'></i>
                                        Contatta
                                    </button>
                                </div>
                            </div>
                        ";
                    }
                } else {
                    echo "Error creating table: " . mysqli_error($conn);
                }

                mysqli_close($conn);
            ?>
        </div>
    </div>

    <br><br>

    <?php
        include("components/footer.php")
    ?>
</body>
</html>