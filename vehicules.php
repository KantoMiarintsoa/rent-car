<?php
include_once('authorization.php');
require_once('helpers.php');
require_once('database.php');

$matricule = get_or_default("matricule", "");
$couleur = get_or_default("couleur", "");
$marque = get_or_default("marque", "");
$nombre_de_place = get_or_default("nombre_de_place", 0);

$con = connect();
$sql = "select * from car where matricule like ? and color like ? and brand like ?";
$cursor = $con->prepare($sql);
$cursor->execute([
    '%' . $matricule . '%',
    '%' . $couleur . '%',
    '%' . $marque . '%'
]);

$voitures = $cursor->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/vehicule.css">
    <title>vehicule</title>
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
            <div class="head">
                <h3>Vehicules</h3>
                <a href="ajouter-vehicule.php" class="primary-button">Ajouter</a>
            </div>

            <form class="search">
                <!-- renvoyer des info vers les serveurs -->
                <input type="text" name="matricule" class="form-input" placeholder="matriculation">
                <input type="text" name="couleur" class="form-input" placeholder="couleur">
                <input type="number" name="nombre_de_place" class="form-input" placeholder="nombre de place">
                <input type="text" name="marque" class="form-input" placeholder="marque">
                <button class="primary-button">
                    recherche
                </button>
            </form>


            <div class="vehicules">
                <?php foreach ($voitures as $voiture) : ?>
                    <a class="vehicule" href="#">
                        <img src="assets/images/car.jpg" alt="car">
                        <span><?php echo $voiture["brand"] . ' ' . $voiture["color"] ?></span>
                        <span><?php echo $voiture["places"] ?> places</span>
                    </a>
                <?php endforeach ?>
            </div>
        </div>
    </div>



</body>

</html>