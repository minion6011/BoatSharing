<?php 
    require_once "main.php";
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BoatSharing | Viaggia condividendo</title>
    <link rel="icon" href="assets/images/ui/logo.svg"/>
    
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/about.css">
</head>
<body>
    <?php
        include("components/navbar.php")
    ?>

    <div class="content">

        <div class="text">
            <section id="chi-siamo">
                <h2><i class="fa fa-user-circle-o"></i> Chi siamo</h2>
                <p>Benvenuti su <strong>BoatSharing</strong>. Nati dall'idea di successo del car sharing, abbiamo deciso di portare la stessa filosofia in mezzo al mare. L'obiettivo è semplice: permettere a più persone, anche sconosciute tra loro, di utilizzare un'unica imbarcazione.</p>
                <br>
                <p>In questo modo non solo si abbattono drasticamente le spese, potendo dividere i costi del carburante, ma si ottimizza l'uso dei veicoli marittimi, creando una community di amanti del mare uniti dalla voglia di navigare in modo intelligente ed economico.</p>
            </section>

            <section id="la-sostenibilita">
                <h2><i class="fa fa-leaf"></i> La sostenibilità</h2>
                <p>L'iniziativa BoatSharing punta prima di tutto a essere <strong>ecologica</strong>. Ogni giorno decine di barche escono in mare mezze vuote, moltiplicando l'inquinamento acustico, le emissioni di gas di scarico e il rilascio di idrocarburi nell'acqua.</p>
                <br>
                <p>Condividendo una singola barca per più passeggeri, si riduce attivamente il numero di imbarcazioni in movimento. Meno motori accesi significa meno emissioni, meno onde anomale vicino alle coste e un rispetto maggiore per la flora e la fauna marina. Il nostro traguardo è un mare più pulito per le generazioni future.</p>
            </section>

            <section id="il-nostro-team">
                <h2><i class="fa fa-users"></i> Il nostro Team</h2>
                <p>BoatSharing è un progetto sviluppato interamente dal programmatore <strong>Vittorio Morelli</strong>. L'idea e la realizzazione della piattaforma sono nate come progetto richiesto e supervisionato dalla <strong>Professoressa Alessandra Arceri</strong>, con lo scopo di unire competenze informatiche e sensibilità ambientale.</p>
                
                <h3>Crediti e Ringraziamenti</h3>
                <p><em>Di seguito l'elenco delle risorse esterne utilizzate per la realizzazione grafica e visiva del sito:</em></p>
                <ul>
                    <li>
                        <b>
                            <a href="https://www.magnific.com/it/foto-gratuito/scatto-ipnotizzante-delle-onde-oceaniche-cristalline_17530073.htm" target="_blank" rel="noopener noreferrer">
                                Login background
                            </a>
                        </b>
                        - <i>Realizzata da wirestock</i> tramite <i>Magnific</i>.
                    </li>
                    <li>
                        <b>
                            <a href="https://www.cdt.ch/news/mondo/scoperto-un-pianeta-interamente-coperto-da-oceani-291696" target="_blank" rel="noopener noreferrer">
                                Catalog background
                            </a>
                        </b>
                        - <i>Ottenuta tramite <i>Shutterstock</i>.
                    </li>
                    <li>
                        <b>
                            <a href="https://https://hifi-filter.com/" target="_blank" rel="noopener noreferrer">
                                About Us background
                            </a>
                        </b>
                        - <i>Ottenuta tramite <i>Hifi Filter</i>.
                    </li>
                    <li>
                        <b>
                            <a href="https://inviaggio.touringclub.it/consigli-di-viaggio/dieci-immagini-spettacolari-sullitalia-dallalto" target="_blank" rel="noopener noreferrer">
                                Home Presentation
                            </a>
                        </b>
                        - <i>Ottenuta tramite <i>thinkstockphotos</i>.
                    </li>
                    <li>
                        <b>
                            <a href="https://www.istockphoto.com/it/foto/superficie-delloceano-atlantico-gm1300107681-392531317" target="_blank" rel="noopener noreferrer">
                                Account background
                            </a>
                        </b>
                        - <i>Realizzata da marc chesneau</i> tramite <i>istockphoto</i>.
                    </li>
                    <li>
                        <b>
                            <a href="https://www.pexels.com/photo/aerial-view-photo-of-an-ocean-2604991/" target="_blank" rel="noopener noreferrer">
                                Chat background
                            </a>
                        </b>
                        - <i>Realizzata da Chris Munnik</i> tramite <i>pexels</i>.
                    </li>
                    <li>
                        <b>Logo e alcune icone in vettoriale</b>
                        - <i>Realizzata da Dark Axel</i> (commissionate per lo sviluppo del sito).
                    </li>
                    <li>
                        <b>
                            <a href="https://fontawesome.com/v4/" target="_blank" rel="noopener noreferrer">
                                Icone
                            </a>
                        </b>
                        - <i>Fornite da Font Awesome</i> v4.
                    </li>
                </ul>
            </section>

            <section id="come-funziona">
                <h2><i class="fa fa-life-ring"></i> Come funziona</h2>
                <p>La piattaforma è progettata per essere intuitiva, diretta e totalmente gratuita nelle interazioni. <strong>Non sono presenti acquisti in-app</strong> o transazioni gestite dal sito.</p>
                <ol>
                    <li><b>Crea un account:</b> Registrati gratuitamente per entrare nella community di BoatSharing.</li>
                    <li><b>Metti a disposizione o cerca una barca:</b> Se sei un proprietario, puoi aggiungere la tua barca specificando itinerario e posti disponibili. Se sei un passeggero, puoi cercare l'imbarcazione perfetta per te.</li>
                    <li><b>Apri una chat:</b> Grazie al nostro sistema di messaggistica interno, gli utenti possono aprire una chat diretta con il proprietario della barca.</li>
                    <li><b>Accordati:</b> Tramite la chat, organizzerete i dettagli della partenza, l'itinerario e come dividere le spese del carburante, in totale autonomia.</li>
                </ol>
            </section>

            <section id="contattaci">
                <h2><i class="fa fa-envelope"></i> Contattaci</h2>
                <p>Per qualsiasi richiesta di assistenza tecnica, segnalazioni o informazioni generali sul progetto BoatSharing, il nostro unico canale di comunicazione è la posta elettronica.</p>
                <p>Puoi scriverci un'email al seguente indirizzo (clicca sul link per aprire il tuo client di posta):</p>
                <ul>
                    <li><b>Email Assistenza:</b> 
                    <?php 
                        echo "<a href='mailto:{$ini['Support']['email']}'>{$ini['Support']['email']}</a></li>";
                    ?>
                </ul>
                <p><small><em>Nota: Il team di supporto risponderà il prima possibile. Non sono previsti recapiti telefonici o chat di assistenza live.</em></small></p>
            </section>
        </div>
    </div>

    <br><br>

    <?php
        include("components/footer.php")
    ?>
</body>
</html>