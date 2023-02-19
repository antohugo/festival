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
    $password = '';

    //On établit la connexion
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=bdd_festival", "root", "");
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