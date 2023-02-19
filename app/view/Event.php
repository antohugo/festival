<?php


session_start();

//*!CSRF TOKEN

//Check if my tokens exist
if (!isset($_POST["token"]) || !isset($_SESSION["token"])) {
    $_SESSION["token"] = bin2hex(random_bytes(32));
}

if (!empty($_POST["token"]) && $_POST["token"] == $_SESSION["token"]) {
    echo "Token is valid!";
    unset($_SESSION["token"]);
} else {
    echo "Token is not valid!";
}

//*! END CSRF TOKEN

//*!Connection to the DB
try {
    $pdo = new PDO("mysql:host=localhost;dbname=festival_bdd", "ihssane", "");
    echo "Connection established";
} catch (PDOException $e) {

    echo "Error: " . $e->getMessage();
    exit();
}

//*! End connection to the DB


//*!CRUD
//*select
try {
    // prepare select statement
    $stmt = $pdo->prepare('SELECT evenement.nomEvenement, evenement.Id_eve, evenement.dateDebutEvt, evenement.dateFinEvt, groupe.Id_group, groupe.nomGroupe, scene.nomScene 
    FROM evenement 
    JOIN scene ON evenement.Id_eve = scene.Id_eve
    JOIN groupe ON scene.Id_group = groupe.Id_group
    
    ');

    // execute statement
    $stmt->execute();

    // fetch data
    $result = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


//*create 
try {
    $success = true;


    if (
        isset($_POST['insertdata']) && !empty($_POST['nomEvenement'])
        && !empty($_POST['dateDebutEvt'])
        && !empty($_POST['dateFinEvt'])
    ) {

        $stmt1 = $pdo->prepare('INSERT INTO evenement (nomEvenement, dateDebutEvt, dateFinEvt)
            VALUES (:nomEvenement, :dateDebutEvt, :dateFinEvt)');

        $date1 = date($_POST['dateDebutEvt']);
        $date2 = date($_POST['dateFinEvt']);

        $stmt1->bindParam(':nomEvenement', $_POST['nomEvenement']);
        $stmt1->bindParam(':dateDebutEvt', $date1);
        $stmt1->bindParam(':dateFinEvt', $date2);

        if (!$stmt1->execute()) {
            $success = false;
        }
    }

    if (
        isset($_POST['insertdata'])
        && !empty($_POST['nomGroupe'])


    ) {

        $stmt2 = $pdo->prepare('INSERT INTO groupe (nomGroupe) 
        VALUES (:nomGroupe)');

        $stmt2->bindParam(':nomGroupe', $_POST['nomGroupe']);
        if (!$stmt2->execute()) {
            $success = false;
        }

        ($stmt2);
    }

    echo 'Error inserting data';
    // }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

//*update

try {

    // check if form data is valid
    if (
        isset($_POST['updatedata']) && !empty($_POST['Id_eve']) && !empty($_POST['nomEvenement'])
        && !empty($_POST['dateDebutEvt'])
        && !empty($_POST['dateFinEvt'])

    ) {
        // prepare update statement
        $stmt = $pdo->prepare('UPDATE evenement
        SET evenement.nomEvenement = :nomEvenement,
            evenement.dateDebutEvt = :dateDebutEvt,
            evenement.dateFinEvt = :dateFinEvt
        WHERE evenement.Id_eve = :Id_eve');

        // bind parameters
        $stmt->bindParam(':Id_eve', $_POST['Id_eve']);
        $stmt->bindParam(':nomEvenement', $_POST['nomEvenement']);
        $stmt->bindParam(':dateDebutEvt', $_POST['dateDebutEvt']);
        $stmt->bindParam(':dateFinEvt', $_POST['dateFinEvt']);


        // execute statement
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo 'Data updated successfully';
        } else {
            echo 'Error updating data';
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

//?Update

try {

    if (
        isset($_POST['updatedata'])
        && !empty($_POST['nomGroupe'])
        && !empty($_POST['Id_group'])

    ) {
        // prepare update statement
        $stmt = $pdo->prepare('UPDATE groupe
        SET groupe.nomGroupe = :nomGroupe
        WHERE groupe.Id_group = :Id_group');

        // bind parameters
        $stmt->bindParam(':nomGroupe', $_POST['nomGroupe']);
        $stmt->bindParam(':Id_group', $_POST['Id_group']);

        // execute statement
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo 'Data updated successfully';
        } else {
            echo 'Error updating data';
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


try {

    if (
        isset($_POST['updatedata'])
        && !empty($_POST['Id_eve'])
        && !empty($_POST['Id_group'])
        && !empty($_POST['nomScene'])

    ) {
        // prepare update statement
        $stmt = $pdo->prepare('UPDATE scene
        SET scene.nomScene = :nomScene 
        WHERE scene.Id_eve = :Id_eve AND scene.Id_group = :Id_group');

        // bind parameters
        $stmt->bindParam(':Id_eve', $_POST['Id_eve']);
        $stmt->bindParam(':Id_group', $_POST['Id_group']);
        $stmt->bindParam(':nomScene', $_POST['nomScene']);
        // execute statement
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo 'Data updated successfully';
        } else {
            echo 'Error updating data';
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


//*delete
try {

    var_dump($_POST);

    $Id_eve = $_POST['Id_eve'];
    // check if form data is valid
    if (
        isset($_POST['deletedata'])
        && !empty($_POST['Id_eve'])

    ) {

        //delete the row in the evenement table
        $stmt4 = $pdo->prepare('DELETE FROM evenement WHERE Id_eve = :Id_eve');
        $stmt4->bindParam(':Id_eve', $Id_eve);
        // execute statement

        $stmt4->execute();
    }
} catch (PDOException $e) {
    echo "Error: some error " . $e->getMessage();
}
//*!End crud


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bootstrap CRUD Data Table for Database with Modal Form</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link href="../../public/style.css" rel=" stylesheet">
    <script src="../../public/script.js"></script>


</head>

<body>
    <div class="container-xl">
        <div class="table-responsive">
        </div>
        <div class="table-wrapper">
            <div class="table-title">
                <h1><b>CRUD EVENTS AND ARTISTS</b></h1>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">

                        </div>
                    </div>
                    <div class="col-sm-6">
                        <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal" data-target="#addEmployeeModal"><i class="material-icons">&#xE147;</i> <span>Add New
                                Events and Artists</span></a>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>
                            <span class="custom-checkbox">
                                <input type="checkbox" id="selectAll">
                                <label for="selectAll"></label>
                            </span>
                        </th>
                        <th>Event Number</th>
                        <th>Event Name</th>
                        <th>Start date</th>
                        <th>End date</th>
                        <th>Groupe Name</th>
                        <th>Scene Name</th>
                        <th>Group Num</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($result as $res) {
                    ?>
                        <tr>
                            <td>
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="checkbox1" name="options[]" value="1">
                                    <label for="checkbox1"></label>
                                </span>
                            </td>

                            <td><?= htmlspecialchars($res['Id_eve']) ?></td>
                            <td><?= htmlspecialchars($res['nomEvenement']) ?></td>
                            <td><?= htmlspecialchars($res['dateDebutEvt']) ?></td>
                            <td><?= htmlspecialchars($res['dateFinEvt']) ?></td>
                            <td><?= htmlspecialchars($res['nomGroupe']) ?></td>
                            <td><?= htmlspecialchars($res['nomScene']) ?></td>
                            <td><?= htmlspecialchars($res['Id_group']) ?></td>
                            <td>
                                <a href="#editEmployeeModal" class="editbtn" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit" data-target="editEmployeeModal">&#xE254;</i></a>
                                <a href="#deleteEmployeeModal" class="delete deletebtn" data-id="<?= $res['Id_eve'] ?>" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                            </td>
                        </tr>

                    <?php
                    }
                    ?>


                </tbody>
            </table>
        </div>
    </div>
    </div>
    <!-- Add Modal HTML -->
    <div id="addEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'] . '') ?>" method="POST">
                    <!-- Add CSRF token -->
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">

                    <div class="modal-header">
                        <h4 class="modal-title">Add Artists and Events</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Event Name</label>
                            <input type="text" name="nomEvenement" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Group Name</label>
                            <input type="text" name="nomGroupe" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Scene Name</label>
                            <input type="text" name="nomScene" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="datetime-local" name="dateDebutEvt" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>End Date</label>
                            <input type="datetime-local" name="dateFinEvt" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Group Id</label>
                            <input type="text" name="Id_group" class="form-control" required>
                        </div>

                    </div>
                    <div class="modal-footer">

                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <button type="submit" name="insertdata" class="btn btn-success">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'] . '') ?>" method="POST">
                    <input type="hidden" name="token" value="<?= $_SESSION["token"] ?>">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Events and artists</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Event Number</label>
                            <input type="text" class="form-control" name="Id_eve" id="Id_eve" required>
                        </div>
                        <div class="form-group">
                            <label>Event Name</label>
                            <input type="text" class="form-control" name="nomEvenement" id="nomEvenement" required>
                        </div>
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="datetime-local" class="form-control" name="dateDebutEvt" id="dateDebutEvt" required>
                        </div>
                        <div class="form-group">
                            <label>End Date</label>
                            <input type="datetime-local" class="form-control" name="dateFinEvt" id="dateFinEvt" required>
                        </div>
                        <div class="form-group">
                            <label>Group name</label>
                            <input type="text" class="form-control" name="nomGroupe" id="nomGroupe" required>
                        </div>

                        <div class="form-group">
                            <label>scene name</label>
                            <input type="text" class="form-control" name="nomScene" id="nomScene" required>
                        </div>
                        <div class="form-group">
                            <label>Group num</label>
                            <input type="text" class="form-control" name="Id_group" id="Id_group" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-success" name="updatedata" value="Edit">
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Delete Modal HTML -->
    <div id="deleteEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'] . '') ?>" method="POST">
                    <input type="hidden" name="token" value="<?= $_SESSION["token"] ?>">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Artsis and Events</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="Id_eve" id="Id_eve" value="<?= $res['Id_eve'] ?>" <p>Are you sure you want to delete these Records?</p>
                        <p class="text-warning"><small>This action cannot be undone.</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" value="1" name="type">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-danger" name="deletedata" value="Delete">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>