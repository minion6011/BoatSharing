<?php
    require_once "main.php";

    requireLogin($conn)
?>

<?php // Post Request
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userid = $_SESSION["user_id"];

        $username = htmlspecialchars($_POST["username"], ENT_QUOTES);
        $password = $_POST["password"];
        $color_num = mb_substr($_POST["color"], 1); // #fff -> to -> fff
        $color = isset($color_num) ? preg_replace('/[^a-fA-F0-9]/', '', $color_num) : '000000';
        $id = $_SESSION["user_id"];
        
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
        
        header("Location: account.php");
        exit;
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
        include("components/modals.php")
    ?>

    <?php // Get Request
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_GET["modal"])) {
                switch ($_GET["modal"]) {
                    case "create":
                        echo "
                        <script>
                            document.addEventListener('DOMContentLoaded', () => {
                                openCreateModal();
                            });
                        </script>
                        ";
                        break;
                }
            }
        }
    ?>

    <?php
        $sql = "SELECT user, color FROM users WHERE id = :id";
        $stmt = $conn -> prepare($sql);
        $stmt -> execute([
            "id" => $_SESSION["user_id"],
        ]);

        $account = $stmt -> fetch(PDO::FETCH_OBJ);
    ?>

    <div class="content">
        <div class="menu">
            <div class="container">
                <div class="box">
                    <p class="title">Account</p>
                    <div class="account" id="account-card">
                        <form action='account.php' method='POST'>
                            <div class='ico'>
                                <img class='userico' src='components/avatar.php?color=<?= $account->color ?>'>

                                <button type='button' class='colorpicker' id='btncolor'>
                                    <input type='color' name='color' value='#<?= $account->color ?>' id='inputcolor'>
                                    <img id='svgcolor' src='assets/images/ui/ink.svg'>
                                </button>
                            </div>

                            <div class='inputs'>
                                <label for='username'>Username</label>
                                <input type='text' placeholder='<?= $account->user ?> ?>' value='<?= $account->user ?>' name='username' required>
                                
                                <label for='password'>Password</label>
                                <input type='password' placeholder='password' name='password'>
                            </div>
                            <button type='submit' name='modify'>Modifica</button>
                        </form>
                    </div>
                </div>
                

                <?php 
                    $sql = "
                        SELECT 
                            c.id AS chatid,
                            b.name AS boatname,
                            b.img AS boatimg,
                            c.timestamp
                        FROM chat_participants cp
                        JOIN chats c ON cp.chatid = c.id
                        JOIN boats b ON c.boatid = b.id
                        WHERE cp.userid = :userid;
                    ";
                    $stmt = $conn -> prepare($sql);
                    $stmt -> execute([
                        "userid" => $_SESSION["user_id"],
                    ]);

                    $chats = $stmt -> fetchAll(PDO::FETCH_OBJ);
                ?>

                <div class="box"
                    <?php 
                        if (isset($chats) && count($chats) == 0) {
                            echo " style='display: none;'";
                    } ?>
                >
                    <p class="title">Chat</p>
                    <div class="chats" id="chats-card">
                        <div class="list">
                            <?php
                                $imgpath = $ini["Paths"]["boatimgs"];

                                foreach ($chats as $row) {
                            ?>
                                <a href='chat.php?id=<?= $row->chatid; ?>'>
                                    <div class='chat'>
                                        <img class='boat' src='<?= $imgpath . $row->boatimg ?>'>
                                        <div class='texts'>
                                            <p class='name'><?= $row->boatname . ' - ' . $row->chatid ?></p>
                                            <p class='time'>Creata in data: <?= $row->timestamp ?></p>
                                            <form action='chat.php' method='POST'>
                                                <input type='hidden' name='_method' value='DELETE'>
                                                <input type='hidden' name='chatid' value='<?= $row->chatid ?>'>
                                                <button>
                                                    <img class='ico' src='assets/images/ui/delete.svg'>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </a>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box">
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
                        // To-Do: Add Paginator or limit to 100 boats
                        foreach ($boats as $row) {
                    ?>
                        <div class='card'>
                            <img src='<?= $imgpath . $row->img ?>'>
                            <div class='infos'>
                                <p class='name'><?= $row->name ?></p>

                                <div class='location'>
                                    <i class='fa fa-map-marker'></i>
                                    <p><?= $row->start_city . ", " . $row->start_cap ?></p>
                                </div>

                                <div class='location'>
                                    <i class='fa fa-angle-double-right'></i>
                                    <p><?= $row->destination ?></p>
                                </div>
                                <div class='buttons'>
                                    <button 
                                        class='delete'
                                        onclick='openDeleteModal(this)'

                                        data-id='<?= $row->id ?>'
                                    >
                                        <img src='assets/images/ui/delete.svg'>
                                    </button>
                                    <button 
                                        class='edit' 
                                        onclick='openEditModal(this)'

                                        data-id='<?= $row->id ?>' 
                                        data-name='<?= $row->name ?>' 
                                        data-img='<?= $imgpath . $row->img ?>'
                                        data-start_city='<?= $row->start_city ?>'
                                        data-start_cap='<?= $row->start_cap ?>'
                                        data-destination='<?= $row->destination ?>'
                                    >
                                        <img src='assets/images/ui/edit.svg'>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php
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