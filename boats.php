<?php
    require_once "main.php";

    requireLogin($conn)
?>

<?php

    $method = $_POST["_method"];
    $data = $_POST;

    switch ($method) {
        case 'POST':
            // Gestisci inserimento
            break;
        case 'PUT':
            // Aggiunta dati
            break;
        case 'PATCH': // Edit
            // Checks if the image is empty
            $imgStatus = validateImg($_FILES["img"], $ini["DB"]["maximagesize"]);

            if ($imgStatus == 2) {
                http_response_code(400); // Code: 431 or 415
                break;
            }

            $ext = pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION);

            $id = $_POST["id"];
            $userid = $_SESSION["user_id"];

            $name = htmlspecialchars($_POST["name"], ENT_QUOTES);
            $start_city = htmlspecialchars($_POST["start_city"], ENT_QUOTES);
            $start_cap = htmlspecialchars($_POST["start_cap"], ENT_QUOTES);
            $destination = htmlspecialchars($_POST["destination"], ENT_QUOTES);

            if ($imgStatus == 0) {
                $imgpath = $ini["Paths"]["boatimgs"];
                
                // Get old image name
                $sql = "SELECT img FROM boats WHERE id = :id";
                $stmt = $conn -> prepare($sql);
                $stmt -> execute([
                    "id" => $id,
                ]);
                $result = $stmt -> fetch(PDO::FETCH_OBJ);

                // Deletes old image
                $oldImg = $imgpath . $result->img;
                
                if (file_exists($oldImg)) {
                    unlink($oldImg);
                }

                // Uploads image
                $img = bin2hex(random_bytes(16)) . '.' . $ext; // Random name

                if (!move_uploaded_file($_FILES["img"]['tmp_name'], $imgpath . $img)) {
                    http_response_code(422);
                    break;
                }

                // Updates DB
                $sql = "UPDATE boats SET name = :name, img = :img, start_city = :start_city, start_cap = :start_cap, destination = :destination WHERE id = :id AND userid = :userid";
                $stmt = $conn -> prepare($sql);
                $stmt -> execute([
                    "id" => $id,
                    "userid" => $userid,

                    "name" => $name,
                    "img" => $img,
                    "start_city" => $start_city,
                    "start_cap" => $start_cap,
                    "destination" => $destination
                ]);
            } else { // No image
                $sql = "UPDATE boats SET name = :name, start_city = :start_city, start_cap = :start_cap, destination = :destination WHERE id = :id AND userid = :userid";
                $stmt = $conn -> prepare($sql);
                $stmt -> execute([
                    "id" => $id,
                    "userid" => $userid,

                    "name" => $name,
                    "start_city" => $start_city,
                    "start_cap" => $start_cap,
                    "destination" => $destination
                ]);
            }
            
            //var_dump(http_response_code(200));
            header("Location: " . "account.php");
            break;
        case 'DELETE':
            // Gestisci eliminazione
            break;
        default:
            http_response_code(405); // Method Not Allowed
            break;
    }
?>