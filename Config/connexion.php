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
    $conn = new PDO("mysql:host=$servername;dbname=bddtest", $username, $password);
    ?>
</body>

</html>