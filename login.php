<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BoatSharing | Viaggia condividendo</title>
    <link rel="icon" href="assets/images/ui/logo.svg"/>
    
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/login.css">

    <script src="assets/js/login.js" type="text/javascript" defer></script>
</head>
<body>
    <?php
        include("components/navbar.php")
    ?>

    <div class="content">
        <div class="login">
            <div class="title" style="--text-color: #ffffff;">
                <img src="assets/images/ui/logo.svg" class="logo">
                <p>Accedi a BoatSharing</p>
            </div>
            <form action="login.php" method="POST">
                <input type="hidden" value="login" id="action-type" name="action">
                <?php
                    if (isset($_GET["redirect"])) {
                        $redirect = htmlspecialchars($_GET["redirect"]);
                        echo "<input type='hidden' value='{$redirect}' name='redirect'>";
                    }
                ?>
                <input type="text" placeholder="Nome utente" name="username" required>
                <input type="password" placeholder="Password" name="password" required>
                <button type="submit" id="action-submit" name="account">ACCEDI</button>
            </form>
            <?php
                require_once "main.php";

                if (isset($_GET["error"])) {
                    switch ($_GET["error"]) {
                        case "exist":
                            $msg = "Esiste già un account con quel nome";
                            break;
                        case "notfound":
                            $msg = "Nessun utente trovato";
                            break;
                        case "password":
                            $msg = "Password Errata";
                            break;
                        default:
                            $msg = "Errore sconosciuto";
                            break;
                    }
                    echo "<p class='error'>{$msg}</p>";
                }


                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (!loggedIn($conn)) {
                        $action = htmlspecialchars($_POST["action"], ENT_QUOTES);
                        $username = htmlspecialchars($_POST["username"], ENT_QUOTES);
                        $password = $_POST["password"];
                        
                        switch ($action) {
                            case "login":
                                $sql = "SELECT id, password FROM users WHERE user = :user";
                                $stmt = $conn -> prepare($sql);
                                $stmt -> execute([
                                    "user" => $username,
                                ]);

                                $row = $stmt -> fetch(PDO::FETCH_OBJ);

                                if ($row) {
                                    $passwordFetch = $row -> password;
                                    if (!password_verify($password, $passwordFetch)) {
                                        header("Location: " . "login.php?error=password");
                                        exit;
                                    }
                                    $id = $row -> id;
                                } else {
                                    header("Location: " . "login.php?error=notfound");
                                    exit;
                                }

                                break;
                            case "register":
                                try {
                                    $sql = "INSERT INTO users (user, password) VALUES (:user, :password)";
                                    $stmt = $conn -> prepare($sql);
                                    $stmt -> execute([
                                        "user" => $username,
                                        "password" => password_hash($password, PASSWORD_DEFAULT) // https://bcrypt-generator.com/
                                    ]);
                                    //$id = $stmt -> fetch(PDO::FETCH_OBJ) -> id;
                                    $id = $conn -> lastInsertId();
                                } catch(PDOException $e) {
                                    //echo $sql . "<br>" . $e->getMessage();
                                    header("Location: " . "login.php?error=exist");
                                    exit;
                                }
                                break;
                        }

                        if (isset($id)) {
                            login($id);
                            $location = "index.php";
                            if (isset($_POST["redirect"]))
                                $location = $_POST["redirect"];
                            header("Location: " . $location);
                            exit;
                        }
                    }
                }
            ?>
            <a class="forgot">Password Dimenticata?</a>
            <p class="action" id="action-change">Non hai un account? <a onclick="changeAction()">Registrati</a></p>
        </div>
    </div>
    <?php
        include("components/footer.php")
    ?>
</body>
</html>