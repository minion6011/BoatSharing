<?php
    header('Content-Type: image/svg+xml');

    $color = isset($_GET['color']) ? preg_replace('/[^a-fA-F0-9]/', '', $_GET['color']) : '000000';

    $svg = file_get_contents('..\assets\images\ui\account.svg');

    $svg_personalizzato = str_replace('#DEFAULT_COLOR', '#' . $color, $svg);

    echo $svg_personalizzato;
?>