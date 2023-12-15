<?php

//% Esempio semplice

/* require './connect.php'; // Importare lo script di connessione al DB

if ($_SERVER["REQUEST_METHOD"] == "POST") { //? Controllare il metodo HTTP
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];

    try {
        //? Query di inserimento dati con prepared statements
        $sql = "INSERT INTO utenti (nome, cognome, email) VALUES (:nome, :cognome, :email);";
        $stmt = $conn->prepare($sql);

        //? Binding dei parametri
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':cognome', $cognome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        //? Esecuzione della query
        $stmt->execute();

        echo "Dati inseriti con successo.";
    } catch (PDOException $e) {

        //! Gestione dell'errore
        echo "Errore nell'inserimento dei dati: " . $e->getMessage();
    }
} else {
    echo "Metodo di richiesta non valido.";
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Inserimento Dati</title>
    <style>
        .validation {
            color: red;
        }
    </style>
</head>
<body>
<h1>Creazione e salvataggio dati</h1>
<form action="create.php" method="POST">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" required>
    <br>
    <label for="cognome">Cognome:</label>
    <input type="text" id="cognome" name="cognome" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <input type="submit" value="Salva">
</form>

</body>
</html>
*/




//% Esempio sicuro
    session_start(); //* Avvia la sessione
    $created = null; //* Inizializza una variabile per il messaggio flash

    //? Controllare se esiste un messaggio flash nella sessione
    if (isset($_SESSION['created'])) {
        $created = $_SESSION['created'];
        //! Rimozione del messaggio flash dalla sessione per non mostrarlo di nuovo al refresh
        unset($_SESSION['created']);
    }

    require './connect.php'; //? Importare lo script di connessione al DB

    //? Inizializzare le variabili per i flash message di errore
    $val_nome = $val_cognome = $val_email = $val_password = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //# Sanitizzazione dei campi
        $nome = htmlspecialchars(strip_tags($_POST['nome']));
        $cognome = htmlspecialchars(strip_tags($_POST['cognome']));
        $email = htmlspecialchars(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
        $password = $_POST['password'];

        //# Validazione dei campi
        if (empty($nome)) {
            $val_nome = "<small class=\"validation\">*Il nome è richiesto.</small>";
        }

        if (empty($cognome)) {
            $val_cognome = "<small class=\"validation\">*Il cognome è richiesto.</small>";
        }

        if (empty($password)) {
            $val_password = "<small class=\"validation\">*La password è richiesta.</small>";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
        }

        if (isset($_POST['email']) && !empty($_POST['email'])) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $val_email = "<small class=\"validation\">*Formato email non valido.</small>";
            }
        } else {
            if (empty($_POST['email'])) {
                $val_email = "<small class=\"validation\">*L'email è richiesta.</small>";
            }
        }

    if (empty($val_nome) && empty($val_cognome) && empty($val_email) && empty($val_password)) {
        try {
            $sql = "INSERT INTO utenti (nome, cognome, email, password) VALUES (:nome, :cognome, :email, :password);";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':cognome', $cognome, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password_hash, PDO::PARAM_STR);
            $stmt->execute();

            //* Imposta il messaggio di successo nella sessione
            $_SESSION['created'] = "Utente creato con successo.";
            //* Reindirizza alla stessa pagina per evitare la ripetizione del form submission
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } catch (PDOException $e) {
            echo "Errore nell'inserimento dei dati: " . $e->getMessage();
        }
    }}?>
    <!DOCTYPE html>
    <html lang="it">
    <head>
        <meta charset="UTF-8">
        <title>Inserimento Dati</title>
        <style>
            .validation {
                color: red;
            }
            .flash-message {
                background-color: aquamarine;
                border: 1px solid green;
                border-radius: 5px;
                padding: .5em .8em;
            }
        </style>
    </head>
    <body>
    <h1>Creazione e salvataggio dati</h1>
    <?php if (!empty($created)): ?>
        <div class="flash-message">
            <?php echo $created; ?>
        </div>
    <?php endif; ?>

    <form action="create.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo isset($_POST['nome']) ? $_POST['nome'] : ''; ?>">
        <span class="error"><?php echo $val_nome; ?></span>
        <br>
        <label for="cognome">Cognome:</label>
        <input type="text" id="cognome" name="cognome" value="<?php echo isset($_POST['cognome']) ? $_POST['cognome'] : ''; ?>">
        <span class="error"><?php echo $val_cognome; ?></span>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <span class="error"><?php echo $val_password; ?></span>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
        <span class="error"><?php echo $val_email; ?></span>
        <br>
        <input type="submit" value="Salva">
    </form>

    </body>
    </html>
