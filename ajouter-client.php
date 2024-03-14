<?php
include_once('authorization.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/vehicule.css">
    <title>Clients</title>
</head>

<body>
    <div class="page">
        <nav class="verticale">
            <h2>Rentcar</h2>
            <ul>
                <a href="index.php">Reservations</a>
                <a href="vehicules.php">Vehicules</a>
                <a href="clients.php" class="active">Clients</a>
            </ul>
        </nav>

        <nav class="horizontale">
            <h3><?php echo $_SESSION['username'] ?></h3>
            <a href="deconnecter.php" class="primary-button">deeconnecter</a>
        </nav>

        <div class="page-container">
            <form class="ajout" method="post" action="">
                <h2>Ajouter client</h2>
                <input type="text" name="name" class="form-input" placeholder="name">
                <input type="date" name="birthdate" class="form-input" placeholder="birthdate">
                <input type="text" name="phone-number" class="form-input" placeholder="phone number">
                <input type="text" name="adress" class="form-input" placeholder="adress">
                <button class="primary-button">
                    Ajouter

                </button>
            </form>
        </div>
    </div>

</body>

</html>

<?php

if (!isset($_POST["name"])) {
    return;
}

require('database.php');

$con = connect();
$sql = 'insert into client (name,birthdate,phone_number,address) values(:name,:birthdate,:phone_number,:adress)';
$cursor = $con->prepare($sql);
$cursor->execute([
    ":name" => $_POST["name"],
    ":birthdate" => $_POST["birthdate"],
    ":phone_number" => $_POST["phone-number"],
    ":adress" => $_POST["adress"]
]);
header("Location: clients.php");
