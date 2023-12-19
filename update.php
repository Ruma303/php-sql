<?php

//% Aggiornare un singolo utente

    require './connect.php';
    $id = 1;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = $_POST['nome'] ?? '';
        $cognome = $_POST['cognome'] ?? '';
        $email = $_POST['email'] ?? '';

        try {
            //? Preparazione query SQL di aggiornamento
            $sql = "UPDATE utenti SET nome = :nome, cognome = :cognome, email = :email WHERE id = :id";

            $stmt = $conn->prepare($sql);

            //? Associazione dei valori ai parametri
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':cognome', $cognome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();
            echo "<p>Utente aggiornato con successo!</p>";

        } catch (PDOException $e) {
            echo "Errore nell'aggiornamento dell'utente: " . $e->getMessage();
        }
    }?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiorna Utente</title>
</head>
<body>
    <h1>Aggiorna Utente</h1>

    <form action="" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <br>
        <label for="cognome">Cognome:</label>
        <input type="text" id="cognome" name="cognome" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <button type="submit">Invia</button>
    </form>
</body>
</html>