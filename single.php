<?php

//% Recuperare e mostrare un singolo utente

require './connect.php';

$id = 10;

try {
    //? Preparazione della query SQL con un parametro
    $sql = "SELECT * FROM utenti WHERE id = :id LIMIT 1;";

    $stmt = $conn->prepare($sql);

    //? Associare il valore dell'ID al parametro nella query in modo sicuro
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    $stmt->execute();

    //* Recuperare il singolo utente
    $user = $stmt->fetch(PDO::FETCH_OBJ);

} catch (PDOException $e) {
    echo "Errore nell'esecuzione della query: " . $e->getMessage();
    $user = null;
}

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dettaglio Utente</title>
</head>
<body>
    <?php if ($user): ?>
        <h1>Dettagli Utente</h1>
        <p><b>Nome:</b> <?= htmlentities($user->nome) ?></p>
        <p><b>Cognome:</b> <?= htmlentities($user->cognome) ?></p>
        <p><b>Email:</b> <?= htmlentities($user->email) ?></p>
        <!-- Non è consigliato mostrare la password, anche se hashata -->
    <?php else: ?>
        <p>Utente non trovato.</p>
    <?php endif; ?>
</body>
</html>