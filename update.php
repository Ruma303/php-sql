<?php

//% Recuperare e mostrare un singolo utente

require './connect.php';
$user = null;

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    try {
        $sql = "UPDATE utenti SET nome = :Gianluca WHERE condizione = :condizione;";
        $stmt = $conn->prepare($sql);

        // Sostituisci 'nuovo_valore' e 'condizione' con i valori o le condizioni specifiche
        $stmt->bindParam(':nuovo_valore', $nuovoValore);
        $stmt->bindParam(':condizione', $condizione);

        $stmt->execute();
        echo "Record aggiornato con successo.";
    } catch(PDOException $e) {
        echo "Errore nell'aggiornamento dei dati: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ricerca Utente</title>
</head>
<body>
    <h1>Ricerca Utente per ID</h1>

    <form action="" method="GET">
        <label for="id">Inserisci ID dell'utente:</label>
        <input type="number" id="id" name="id" required>
        <button type="submit">Cerca</button>
    </form>

    <?php if ($user): ?>
        <h2>Dettagli Utente</h2>
        <p><b>ID:</b> <?= htmlentities($user->id) ?></p>
        <p><b>Nome:</b> <?= htmlentities($user->nome) ?></p>
        <p><b>Cognome:</b> <?= htmlentities($user->cognome) ?></p>
        <p><b>Email:</b> <?= htmlentities($user->email) ?></p>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])): ?>
        <p>Utente non trovato.</p>
    <?php endif; ?>
</body>
</html>