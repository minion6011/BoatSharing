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

    /**
     * Return a Code based on the image status: 0, Success; 1 Empty; 2 Error
     */
    function validateImg(array|null $file, int $maxsize): int {
        // No file
        if ($file == null)
            return 1;

        $fileSize = $file['size']; // Size in bytes

        // File empty
        if ($file['error'] == UPLOAD_ERR_NO_FILE || $fileSize === 0)
            return 1;

        // Unable to upload, or max size surpassed
        if ($file['error'] !== UPLOAD_ERR_OK || $fileSize > $maxsize)
            return 2;

        // Security Check only HTTPS allowed
        if (!is_uploaded_file($file['tmp_name']))
            return 2;

        // Check if the file type is valid
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);

        $allowedMimeTypes = ['image/jpeg','image/jpg', 'image/png', 'image/webp'];
        if (!in_array($mimeType, $allowedMimeTypes, true)) {
            return 2; 
        }

        return 0;
    }

?>