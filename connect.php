<?php

    /* define('DB_HOST', "localhost");
    define('DB_USERNAME', "root");
    define('DB_PASSWORD', "");
    define('DB_NAME', "php_mysql");

    //% mysqli

    //? Stabilire una connessione
    $conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

    //? Controllare lo stato della connessione
    if (!$conn) {
        die("Connessione fallita: " . mysqli_connect_error());
    }
    echo "Connessione al database <b>" . DB_NAME . "</b> stabilita con successo"; */



    //% PDO
    define('DB_HOST', "127.0.0.1");
    define('DB_USERNAME', "root");
    define('DB_PASSWORD', "");
    define('DB_NAME', "php_mysql");
    define('CHARSET', "utf8mb4");

    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . CHARSET . ";";
    echo $dsn;

    //? (opzionale) Impostare attributi PDO per gli errori in modalità eccezione
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $conn = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);
        echo "Connessione al database <b>" . DB_NAME . "</b> stabilita con successo";
    } catch(PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }