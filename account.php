<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BoatSharing | Viaggia condividendo</title>
    <link rel="icon" href="assets/images/ui/logo.svg"/>
    
    <link rel="stylesheet" href="assets/css/style.css">

    <script src="assets/js/login.js" type="text/javascript" defer></script>
</head>
<body>
    <?php
        include("components/navbar.php")
    ?>

    <div class="content">
        <h1>Account Skibidi</h1>
    </div>

    <?php
        include("components/footer.php")
    ?>
</body>
</html>

<?php 
    require("main.php");
    checklogin();
?>