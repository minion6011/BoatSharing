<?php declare(strict_types=1);
    // Required
    session_start([
        'cookie_lifetime' => 0, 
        'cookie_secure' => true, 
        'cookie_httponly' => true, 
        'cookie_samesite' => 'Strict'
    ]);

    function login(int $userid) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $userid;
    }
    function checkLogin() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit;
        }
    }
    function getConfig() {
        $ini = parse_ini_file(__DIR__ . "/config.ini", true);
        if (!isset($ini)) {
            die("ini file not found");
        }
        return $ini;
    }

    // Config
    $ini = getConfig();

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
?>