<?php
include_once('authorization.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- key : index ? -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/vehicule.css">
    <title>ajouter vehicule</title>
</head>

<body>
    <div class="page">
        <nav class="verticale">
            <h2>Rentcar</h2>
            <ul>
                <a href="index.php">Reservations</a>
                <a href="vehicules.php" class="active">Vehicules</a>
                <a href="clients.php">Clients</a>
            </ul>
        </nav>

        <nav class="horizontale">
            <h3><?php echo $_SESSION['username'] ?></h3>
            <a href="deconnecter.php" class="primary-button">deconnecter</a>
        </nav>

        <div class="page-container">
            <form class="ajout" method="post">
                <h2>Ajout vehicule</h2>
                <!-- renvoyer des info vers les serveurs -->
                <input type="text" name="matricule" class="form-input" placeholder="matriculation">
                <input type="text" name="couleur" class="form-input" placeholder="couleur">
                <input type="number" name="nombre_de_place" class="form-input" placeholder="nombre de place">
                <input type="text" name="marque" class="form-input" placeholder="marque">
                <button class="primary-button">
                    Ajouter
                </button>
            </form>

        </div>
    </div>
</body>

</html>

<?php

if (!isset($_POST["couleur"])) {
    return;
}
require_once('database.php');
$con = connect();
$sql = 'insert into car(matricule,color,brand,places) values(:matriculation,:couleur,:marque,:nombre_de_place)';
$cursor = $con->prepare($sql);
$cursor->execute([
    ":couleur" => $_POST["couleur"],
    ":matriculation" => $_POST["matricule"],
    ":marque" => $_POST["marque"],
    ":nombre_de_place" => $_POST["nombre_de_place"]
]);
header("Location: vehicules.php");
