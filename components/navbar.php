<script src="assets/js/navbar.js" type="text/javascript" defer></script>
<div class="navbar">
    <a href="index.php">
        <img class="logo-adp" alt="Ancora seguita dalla scritta BoatSharing, Logo del sito">
    </a>
    <div class="links" id="nav-link">
        <a href="catalog.php">Esplora</a>
        <a href="index.php">Home</a>
        <a href="about.php">Chi siamo</a>
    </div>
    <div class="btns">
        <a href="account.php?modal=create">
            <button>
                <size>+</size> 
                Pubblica un mezzo
            </button>
        </a>
        <?php
            require_once "main.php";

            if (loggedIn($conn)) {

                $sql = "SELECT user, color FROM users WHERE id = :id";
                $stmt = $conn -> prepare($sql);
                $stmt -> execute([
                    "id" => $_SESSION["user_id"],
                ]);

                $result = $stmt -> fetch(PDO::FETCH_OBJ);

                echo "
                <a href='account.php'>
                    <img src='components/avatar.php?color=$result->color' class='account' alt='Barca a vela'>
                </a>
                ";
            } else {
                echo "
                <a href='login.php'>
                    <img src='assets/images/ui/add.svg' class='account' alt='Barca a vela'>
                </a>
                ";
            }
        ?>
    </div>
</div>