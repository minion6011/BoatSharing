<?php
    require_once "main.php";

    requireLogin($conn)
?>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $method = $_POST["_method"];
        switch ($method) {
            case 'DELETE':
                $userid = $_SESSION["user_id"];
                $chatid = $_POST["chatid"];

                $sql = "
                    SELECT EXISTS (
                        SELECT 1 
                        FROM chat_participants 
                        WHERE chatid = :chatid AND userid = :userid
                    );
                ";
                $stmt = $conn -> prepare($sql);
                $stmt -> execute([
                    "userid" => $userid,
                    "chatid" => $chatid
                ]);
                $existdata = $stmt -> fetch(PDO::FETCH_OBJ);

                if ($existdata === false) {
                    http_response_code(404);
                    exit;
                }
                try {
                    // Remove from the DB
                    $sql = "DELETE FROM chats WHERE id = :chatid";
                    $stmt = $conn -> prepare($sql);
                    $stmt -> execute([
                        "chatid" => $chatid,
                    ]);

                    //var_dump(http_response_code(200));
                    header("Location: " . "account.php");
                    break;
                } catch(PDOException $e) {
                    echo $sql . "<br>" . $e->getMessage();
                    http_response_code(400);
                    exit;
                } catch (Exception $e) {
                    http_response_code(400);
                    exit;
                }
            case 'POST':
                try {
                    $boatid = $_POST["id"];
                    $userid = $_POST["userid"];
                    $currentuserid = $_SESSION['user_id'] ?? null;

                    if ($userid == $currentuserid) {
                        http_response_code(409);
                        header("Location: " . "index.php");
                        exit;
                    }

                    $sql = "
                        INSERT INTO chats (boatid) VALUES (:boatid)
                    ";
                    $stmt = $conn -> prepare($sql);
                    $stmt -> execute([
                        "boatid" => $boatid
                    ]);
                    $chatid = $conn -> lastInsertId();

                    $sql = "
                        INSERT INTO chat_participants (chatid, userid) VALUES (:chatid, :useridA), (:chatid, :useridB)
                    ";
                    $stmt = $conn -> prepare($sql);
                    $stmt -> execute([
                        "chatid" => $chatid,
                        "useridA" => $userid,
                        "useridB" => $currentuserid
                    ]);
                    header("Location: " . "chat.php?id=" . urlencode($chatid));
                    exit;
                } catch(PDOException $e) {
                    echo $e->getMessage();
                    http_response_code(400);
                    exit;
                } catch (Exception $e) {
                    http_response_code(400);
                    exit;
                }
            case 'PUT':
                $userid = $_SESSION["user_id"];
                $chatid = $_POST["chatid"];
                $content = $_POST["content"];

                $sql = "
                    SELECT EXISTS (
                        SELECT 1 
                        FROM chat_participants 
                        WHERE chatid = :chatid AND userid = :userid
                    );
                ";
                $stmt = $conn -> prepare($sql);
                $stmt -> execute([
                    "userid" => $userid,
                    "chatid" => $chatid
                ]);
                $existdata = $stmt -> fetch(PDO::FETCH_OBJ);

                if ($existdata === false) {
                    http_response_code(401);
                    exit;
                }
                try {
                    $sql = "INSERT INTO chat_messages (chatid, userid, content) VALUES (:chatid, :userid, :content)";
                    $stmt = $conn -> prepare($sql);
                    $stmt -> execute([
                        "userid" => $userid,
                        "chatid" => $chatid,
                        "content" => $content
                    ]);
                } catch(PDOException $e) {
                    //echo $sql . "<br>" . $e->getMessage();
                    http_response_code(400);
                    exit;
                }
                header("Location: " . "chat.php?id=" . urlencode($chatid));
                exit;
        }
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
    <link rel="stylesheet" href="assets/css/chat.css">

    <script src="assets/js/chat.js" type="text/javascript" defer></script>
</head>
<body>
    <?php
        include("components/navbar.php")
    ?>

    <div class="content">

        <?php
            if ($_SERVER['REQUEST_METHOD'] != 'GET') {
                header("Location: account.php");
                exit;
            }

            if (!isset($_GET['id'])) {
                header("Location: account.php");
                exit();
            }

            $chatid = $_GET["id"];
            $imgpath = $ini["Paths"]["boatimgs"];

            $sql = "
                SELECT 
                    b.name AS boatname,
                    b.img AS boatimg,
                    c.timestamp
                FROM chat_participants cp
                JOIN chats c ON cp.chatid = c.id
                JOIN boats b ON c.boatid = b.id
                WHERE cp.userid = :userid AND cp.chatid = :chatid;
            ";
            $stmt = $conn -> prepare($sql);
            $stmt -> execute([
                "userid" => $_SESSION["user_id"],
                "chatid" => $chatid,
            ]);

            $chatdata = $stmt -> fetch(PDO::FETCH_OBJ);

            if ($chatdata === false) {
                header("Location: account.php");
                exit();
            }

            $sql = "
                SELECT userid, content, timestamp FROM chat_messages WHERE chatid = :chatid;
            ";
            $stmt = $conn -> prepare($sql);
            $stmt -> execute([
                "chatid" => $chatid,
            ]);

            $messagesdata = $stmt -> fetchAll(PDO::FETCH_OBJ);
        ?>

        <div class="chat">
            <div class="controll">
                <?php
                    echo "<img src='{$imgpath}{$chatdata->boatimg}' class='ico'>"; 
                    echo "<p class='name'>{$chatdata->boatname} - {$chatid}</p>";
                ?>
            </div>

           <div class="messages" id="messages">
                <?php 
                    echo "<p class='message system'>Questo è l'inizio della vostra conversazione<br>{$chatdata->timestamp}</p>";
                    foreach ($messagesdata as $message) {
                        if ($message->userid == $_SESSION["user_id"]) {
                            echo "<p class='message self'>{$message->content}</p>";
                        } else {
                            echo "<p class='message user'>{$message->content}</p>";
                        }
                    }
                ?>
            </div>

            <form class="input" action="chat.php" method="POST">
                <input type="hidden" name="_method" value="PUT">

                <input type="text" placeholder="Invia un messaggio in chat..." name="content">
                <?php
                    echo "<input type='hidden' name='chatid' value={$_GET['id']}>";
                ?>
                <button type="submit">
                    <i class="fa fa-paper-plane"></i>
                </button>
            </form>
        </div>

    </div>

    <?php
        include("components/footer.php")
    ?>
</body>
</html>