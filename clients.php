<?php

require_once('helpers.php');
require_once('database.php');
include_once('authorization.php');

$name = get_or_default("nom", "");


$con = connect();
$sql = "select * from client where name like ? ";
$cursor = $con->prepare($sql);
$cursor->execute([
    '%' . $name . '%',
]);

$clients = $cursor->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/client.css">
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
            <span>
                <h3><?php echo $_SESSION['username'] ?></h3>
            </span>
            <a href="deconnecter.php" class="primary-button">deconnecter</a>
        </nav>

        <div class="page-container">
            <div class="client-head">
                <form class="search">
                    <input type="text" name="nom" class="form-input" placeholder="nom">
                    <button class="primary-button">
                        Recherche
                    </button>
                </form>
                <a href="ajouter-client.php" class="primary-button">Ajouter</a>
            </div>

            <table cellspacing="0" cellpadding="0" class="list-clients">
                <?php foreach ($clients as $client) : ?>
                    <tr class="client">
                        <td><img src="assets/images/fille.png" alt=""></td>
                        <td><?php echo $client["name"] ?></td>
                        <td>age</td>
                        <td>telephone</td>
                        <td>adress</td>
                    </tr>
                <?php endforeach ?>
            </table>

</body>

</html>