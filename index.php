<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BoatSharing | Viaggia condividendo</title>
    <link rel="icon" href="assets/imgs/logo.svg"/>
    
    <link rel="stylesheet" href="style.css">
    <script src="main.js" type="text/javascript" defer></script>
</head>
<body>
    <?php
        include("components/navbar.html")
    ?>

    <div class="content">
        <div class="presentation">
            <img src="assets/imgs/presentation.jpg">
            <text>
                Esplora le acque con la <b>barca dei tuoi sogni. <br>
                BoatSharing</b>, il modo più facile per navigare
            </text>
        </div>

        <div class="side-sep">
            <p class="title">In Evidenza</p>
            <a href="test.html" class="link">
                Vedi tutti
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
        <div class="boats">

            <div class="card">
                <img src="assets/boats/template1.jpg">
                <div class="infos">
                    <p class="name">Barca a motore</p>

                    <div class="location">
                        <i class="fa fa-map-marker"></i>
                        <p>Palermo, 90121</p>
                    </div>

                    <div class="location">
                        <i class="fa fa-angle-double-right"></i>
                        <p>Brindisi</p>
                    </div>

                    <button>
                        <i class="fa fa-phone"></i>
                        Contatta
                    </button>
                </div>
            </div>

            <div class="card">
                <img src="assets/boats/template2.jpg">
                <div class="infos">
                    <p class="name">Barca a vela</p>

                    <div class="location">
                        <i class="fa fa-map-marker"></i>
                        <p>Napoli, 80020</p>
                    </div>

                    <div class="location">
                        <i class="fa fa-angle-double-right"></i>
                        <p>Fossa delle marianne</p>
                    </div>

                    <button>
                        <i class="fa fa-phone"></i>
                        Contatta
                    </button>
                </div>
            </div>

            <div class="card">
                <img src="assets/boats/template3.jpg">
                <div class="infos">
                    <p class="name">Mini Yatch</p>

                    <div class="location">
                        <i class="fa fa-map-marker"></i>
                        <p>Genova, 16100</p>
                    </div>

                    <div class="location">
                        <i class="fa fa-angle-double-right"></i>
                        <p>Livorno</p>
                    </div>

                    <button>
                        <i class="fa fa-phone"></i>
                        Contatta
                    </button>
                </div>
            </div>
        </div>
    </div>

    <br><br>

    <?php
        include("components/footer.html")
    ?>
</body>
</html>