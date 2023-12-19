<?php

//% Eliminare l'utente con ID 1

require './connect.php';
$id = 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        //? Preparazione della query SQL di eliminazione
        $sql = "DELETE FROM utenti WHERE id = :id";
        $stmt = $conn->prepare($sql);

        //? Associare l'ID al parametro
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "<p>Utente 1 eliminato con successo!</p>";
        } else {
            echo "<p>L'utente con ID 1 non è stato trovato o non è stato possibile eliminarlo.</p>";
        }

    } catch (PDOException $e) {
        echo "Errore nell'eliminazione dell'utente: " . $e->getMessage();
    }
}?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elimina Utente 1</title>
</head>
<body>
    <h1>Elimina Utente 1</h1>

    <form action="" method="POST">
        <button type="submit">Elimina Utente 1</button>
    </form>
</body>
</html>