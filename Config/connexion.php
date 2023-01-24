<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="cours.css">
</head>

<body>
    <?php
    $servername = 'localhost';
    $username = 'root';
    $password = 'root';

    //On établit la connexion
    try {
        $pdo = new PDO("mysql:host=hostname;dbname=database", "username", "password");
        // connection successful
        echo "Connection established";
    } catch (PDOException $e) {
        // connection failed
        echo "Error: " . $e->getMessage();
        exit();
    }
    ?>
</body>

</html>