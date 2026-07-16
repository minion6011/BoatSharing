<?php
    require_once "main.php";

    requirelogin();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BoatSharing | Viaggia condividendo</title>
    <link rel="icon" href="assets/images/ui/logo.svg"/>
    
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/account.css">

    <script src="assets/js/login.js" type="text/javascript" defer></script>
</head>
<body>
    <?php
        include("components/navbar.php")
    ?>

    <?php
        $sql = "SELECT user, color FROM users WHERE id = :id";
        $stmt = $conn -> prepare($sql);
        $stmt -> execute([
            "id" => $_SESSION["user_id"],
        ]);

        $result = $stmt -> fetch(PDO::FETCH_OBJ);
    ?>


    <div class="content">
        <div class="menu">
            <div>
                <p class="title">Account</p>
                <div class="account">
                    <img src='components/avatar.php?color=<?php echo $result->color; ?>'>
                    <?php
                        if ($result) {
                            echo "
                                <input type='text' placeholder='{$result->user}' value='{$result->user}' required>
                            ";
                        }
                    ?>
                </div>
            </div>

            <div>
                <p class="title">Le mie barche</p>
                <div class="boats">


                    <?php
                        $imgpath = $ini["Paths"]["boatimgs"];
        
                        $sql = "SELECT * FROM boats WHERE userid = :id";
                        $stmt = $conn -> prepare($sql);
                        $stmt -> execute([
                            "id" => $_SESSION["user_id"],
                        ]);

                        $result = $stmt -> fetchAll(PDO::FETCH_OBJ);

                        if ($result) {
                            //$passwordFetch = $row -> password;
                            foreach ($result as $row) {
                                echo "
                                    <div class='card'>
                                        <img src='{$imgpath}{$row->img}'>
                                        <div class='infos'>
                                            <p class='name'>{$row->name}</p>

                                            <div class='location'>
                                                <i class='fa fa-map-marker'></i>
                                                <p>{$row->start_city}, {$row->start_cap}</p>
                                            </div>

                                            <div class='location'>
                                                <i class='fa fa-angle-double-right'></i>
                                                <p>{$row->destination}</p>
                                            </div>
                                            <div class='buttons'>
                                                <button class='delete'>
                                                    <img src='assets/images/ui/delete.svg'>
                                                </button>
                                                <button class='edit'>
                                                    <img src='assets/images/ui/edit.svg'>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                ";
                            }
                        }
                    ?>          
                </div>
            </div>
        </div>
    </div>

    <?php
        include("components/footer.php")
    ?>
</body>
</html>