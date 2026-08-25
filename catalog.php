<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BoatSharing | Viaggia condividendo</title>
    <link rel="icon" href="assets/images/ui/logo.svg"/>
    
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/catalog.css">
</head>
<body>
    <?php
        include("components/navbar.php")
    ?>

    <div class="content">
        <form action='catalog.php' method='GET'>
            <div class="search">
                <select name="type" required>
                    <option value="name">Nome barca</option>
                    <option value="start_city">Partenza</option>
                    <option value="start_cap">CAP</option>
                    <option value="destination">Destinazione</option>
                </select>
                <input type="text" name="content" minlength="5">
                <button type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </form>

        <div class="boats">
            <?php
                require_once "main.php";

                // Search

                $searchquery = "";
                $params = [];
                $valid_methods = ["name", "start_city", "start_cap", "destination"];

                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    if (isset($_GET["type"]) && isset($_GET["content"])) {
                        if (in_array($_GET["type"], $valid_methods, true)) {
                            $searchquery = "WHERE {$_GET['type']} LIKE :content ";
                            $params[':content'] = '%' . $_GET['content'] . '%';
                        }
                    }
                }

                // Data display

                $imgpath = $ini["Paths"]["boatimgs"];

                $sql = "SELECT * FROM boats " . $searchquery . "ORDER BY id LIMIT 50";

                $stmt = $conn -> prepare($sql);
                $stmt -> execute($params);

                foreach ($stmt->fetchAll() as $row) {
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
            ?>
        </div>
    </div>

    <br><br>

    <?php
        include("components/footer.php")
    ?>
</body>
</html>