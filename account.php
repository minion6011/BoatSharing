<?php
    require_once "main.php";

    requireLogin($conn)
?>

<?php // Post Request
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userid = $_SESSION["user_id"];
        //requireLogin($conn);
        $username = htmlspecialchars($_POST["username"], ENT_QUOTES);
        $password = $_POST["password"];
        $color_num = mb_substr($_POST["color"], 1); // #fff -> to -> fff
        $color = isset($color_num) ? preg_replace('/[^a-fA-F0-9]/', '', $color_num) : '000000';
        $id = $_SESSION["user_id"];
        // To-Do: Add controll for $username, %color
        if (empty($password)) {
            $sql = "UPDATE users SET user = :user, color = :color WHERE id = :id";
            $stmt = $conn -> prepare($sql);
            $stmt -> execute([
                "user" => $username,
                "color" => $color,
                "id" => $id
            ]);
        } else {
            $sql = "UPDATE users SET user = :user, password = :password, color = :color WHERE id = :id";
            $stmt = $conn -> prepare($sql);
            $stmt -> execute([
                "user" => $username,
                "password" => password_hash($password, PASSWORD_DEFAULT), // https://bcrypt-generator.com/
                "color" => $color,
                "id" => $id
            ]);
        }
        
        header("Location: " . "account.php");
    }
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

    <script src="assets/js/account.js" type="text/javascript" defer></script>
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
                <form action='account.php' method='POST'>
                    <div class="account">
                        <?php
                            echo "
                                <div class='ico'>
                                    <img class='userico' src='components/avatar.php?color={$result->color}'>

                                    <button type='button' class='colorpicker' id='btncolor'>
                                        <input type='color' name='color' value='#{$result->color}' id='inputcolor'>
                                        <img id='svgcolor' src='assets/images/ui/ink.svg'>
                                    </button>
                                </div>

                                <div class='inputs'>
                                    <label for='username'>Username</label>
                                    <input type='text' placeholder='{$result->user}' value='{$result->user}' name='username' required>
                                    
                                    <label for='password'>Password</label>
                                    <input type='password' placeholder='password' name='password'>
                                </div>
                                <button type='submit' name='modify'>Modifica</button>
                            ";
                        ?>
                    </div>
                </form>
            </div>

            <div>
                <?php
                    $imgpath = $ini["Paths"]["boatimgs"];
        
                    $sql = "SELECT * FROM boats WHERE userid = :userid";
                    $stmt = $conn -> prepare($sql);
                    $stmt -> execute([
                        "userid" => $_SESSION["user_id"],
                    ]);

                    $boats = $stmt -> fetchAll(PDO::FETCH_OBJ);
                    if (isset($boats) && count($boats) > 0) {
                        echo "<p class='title'>Le mie barche</p>";
                    }
                ?>    

                <div class="boats">

                    <?php
                        foreach ($boats as $row) {
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
                                            <button 
                                                class='edit' 
                                                onclick='openEditModal(this)'

                                                data-id='{$row->id}' 
                                                data-name='{$row->name}' 
                                                data-img='{$imgpath}{$row->img}'
                                                data-start_city='{$row->start_city}'
                                                data-start_cap='{$row->start_cap}'
                                                data-destination='{$row->start_city}'
                                            >
                                                <img src='assets/images/ui/edit.svg'>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                    ?>        

                </div>
            </div>
        </div>
    </div>

    <?php
        include("components/modals.php")
    ?>

    <?php
        include("components/footer.php")
    ?>
</body>
</html>