    <?php

    //% Recuperare e mostrare i dati

    require './connect.php';

    try {
        $sql = "SELECT * FROM utenti;";
        $stmt = $conn->query($sql);
        //* Recupera tutti gli utenti e li memorizza in $users
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Errore nell'esecuzione della query: " . $e->getMessage();
        $users = [];
    }

    ?>

    <!DOCTYPE html>
    <html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Elenco Utenti</title>
    </head>
    <body>
        <?php if ($users) echo "<h1>Utenti recuperati</h1>" ?>
        <ol>
        <?php foreach ($users as $user): ?>
            <li><b>Nome:</b> <?= htmlentities($user['nome']) ?> <b>Cognome:</b> <?= htmlentities($user['cognome']) ?> <b>Email:</b> <?= htmlentities($user['email']) ?> <b>Password:</b> <?= htmlentities($user['password']) ?></li>
        <?php endforeach; ?>
        </ol>
    </body>
    </html>

