<?php
require_once('database.php');
include_once('authorization.php');

$con = connect();
$sql = "select * from car";
$cursor = $con->prepare($sql);
$cursor->execute([]);

$voitures = $cursor->fetchAll(PDO::FETCH_ASSOC);

$client_cursor = $con->prepare("select* from client");

$client_cursor->execute();

$clients = $client_cursor->fetchAll();

// tester si c'est une requete poste
if (isset($_POST["date_reservation"])) {
    $sql = 'insert into resercvation (date,duration) values(:date,:duration)';
    $cursor = $con->prepare('select * from reservation where id_car=:id_car &&  date_reservation BETWEEN :date_reservation AND DATE_ADD(date_reservation, INTERVAL duration HOUR);');
    $date_reservation = $_POST["date_reservation"] . " " . $_POST["temps"];
    $cursor->execute([
        ":id_car" => $_POST["id_car"],
        ":date_reservation" => $date_reservation,
    ]);
    $reservation = $cursor->fetchAll(PDO::FETCH_ASSOC);

    var_dump($reservation);

    // si il y a deja une reservation pour cette date
    if ($reservation === false) {
        $error = "Il y a déjà une reservation pour cette date";
    } else {
        $sql = 'insert into reservation (date_reservation,duration,id_client,id_car) values(:date_reservation,:duration,:id_client,:id_car)';
        $cursor = $con->prepare($sql);
        $cursor->execute([
            ":date_reservation" => $date_reservation,
            ":duration" => $_POST['duration'],
            ":id_client" => $_POST['id_client'],
            ":id_car" => $_POST['id_car'],
        ]);

        header("Location:reservations.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/reservation.css">
    <title>Réservations</title>
</head>

<body>
    <div class="page">
        <nav class="verticale">
            <h2>Rentcar</h2>
            <ul>
                <a href="index.php">Reservations</a>
                <a href="vehicules.php">Vehicules</a>
                <a href="clients.php">Clients</a>
            </ul>
        </nav>

        <nav class="horizontale">
            <span>
                <h3><?php echo $_SESSION['username'] ?></h3>
            </span>
            <a href="deconnecter.php" class="primary-button">deconnecter</a>
        </nav>

        <div class="page-container">
            <div class="first">
                <h3>Reservations</h3>
                <a href="" class="primary-button">Ajouter</a>
            </div>

            <form class="reserver" method='post'>

                <label for="date_reservation">Date reservation</label>
                <input type="date" name="date_reservation" class="form-input" placeholder="date de reservation" id="date_reservation">

                <label for="temps">Temps</label>
                <input type="time" id="temps" name="temps" class="form-input" placeholder="temps">

                <input type="number" name="duration" class="form-input" placeholder="duration">


                <select name="id_car">
                    <?php foreach ($voitures as $voiture) : ?>
                        <option value=<?php echo $voiture["id"] ?>>
                            <?php echo $voiture["matricule"] ?>
                        </option>
                    <?php endforeach ?>
                </select ?>

                <select name="id_client">
                    <?php foreach ($clients as $client) : ?>
                        <option value=<?php echo $client['id'] ?>> <?php echo $client["name"]; ?> </option>
                    <?php endforeach ?>
                </select>

                <button class="primary-button">
                    Reserver
                </button>

            </form>
        </div>
</body>

</html>