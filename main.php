<?php declare(strict_types=1);
    // Session
    session_start([
        'cookie_lifetime' => 0, 
        'cookie_secure' => true, 
        'cookie_httponly' => true, 
        'cookie_samesite' => 'Strict'
    ]);

    // Config
    $ini = parse_ini_file(__DIR__ . "/config.ini", true);
    if (!isset($ini)) {
        die("ini file not found");
    }

    // DB
    $servername = $ini["DB"]["servername"];
    $dbname = $ini["DB"]["dbname"];

    $username = $ini["DB"]["username"];
    $password = $ini["DB"]["password"];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
    

    function login(int $userid) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $userid;
    }

    function requireLogin(PDO $conn) {
        if (!loggedIn($conn)) {
            header('Location: login.php');
            exit;
        }
    }

    function loggedIn(PDO $conn): bool {
        if (empty($_SESSION['user_id']))
            return false;
        
        $stmt = $conn->prepare("SELECT 1 FROM users WHERE id = :id");
        $stmt->execute([
            "id" => $_SESSION['user_id']
        ]);
        
        $result = (bool) $stmt->fetchColumn();

        if (!$result) // reset
            $_SESSION['user_id'] = null;

        return $result;
    }
?>