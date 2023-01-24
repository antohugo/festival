<?php

try {
// prepare select statement
$stmt = $pdo->prepare("SELECT * FROM festival");
// execute statement
$stmt->execute();
// fetch data
$users = $stmt->fetchAll();
} catch (PDOException $e) {
echo "Error: " . $e->getMessage();
}

//*create 
try {
    // check if form data is valid
    if (isset($_POST['submit']) && !empty($_POST['name']) && !empty($_POST['email'])) {
        // prepare insert statement
        $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        // bind parameters
        $stmt->bindParam(':name', $_POST['name']);
        $stmt->bindParam(':email', $_POST['email']);
        // execute statement
        $stmt->execute();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

//*update 
try {
    // check if form data is valid
    if (isset($_POST['submit']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['id'])) {
        // prepare update statement
        $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        // bind parameters
        $stmt->bindParam(':name', $_POST['name']);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':id', $_POST['id']);
        // execute statement
        $stmt->execute();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
//* delete
try {
    // check if form data is valid
    if (isset($_POST['submit']) && !empty($_POST['id'])) {
        // prepare delete statement
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        // bind parameter
        $stmt->bindParam(':id', $_POST['id']);
        // execute statement
        $stmt->execute();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    
} 














?>