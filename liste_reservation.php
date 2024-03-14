<?php

require_once('database.php');
require_once('helpers.php');
include_once('authorization.php');

$con = connect();

$client = get_or_default('client', '');
$matricule = get_or_default('car', '');
$date = get_or_default('date_reservation', null);

$sql = 'select r.*, 
        DATE_ADD(date_reservation, INTERVAL duration HOUR) as retour,
        cl.name,
        c.matricule 
        from reservation r 
        inner join client cl on cl.id=r.id_client 
        inner join car c on c.id=r.id_car 
        where is_given_back=0
        and cl.name LIKE :client_condition
        and c.matricule LIKE :car_condition';

$params = [
    ':client_condition' => '%' . $client . "%",
    ':car_condition' => '%' . $matricule . "%"
];

if ($date) {
    $params[":date_condition"] = $date;
    $sql = $sql . " and date_reservation =:date_condition";
}

$cursor = $con->prepare($sql);
$cursor->execute($params);
$reservations = $cursor->fetchAll(PDO::FETCH_ASSOC);
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
                <a href="index.php" class="active">Reservations</a>
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
                <a href="reservations.php" class="primary-button">Reserver</a>
            </div>
            <form classe="rechercher">
                <input type="date" name="date_reservation" class="form-input" placeholder="date de reservation">
                <input type="text" name="client" class="form-input" placeholder="client">
                <input type="text" name="car" class="form-input" placeholder="Matricule">

                <button class="primary-button">
                    recherche
                </button>
            </form>
            <table class="liste_reservation" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Vehicule</th>
                        <th>retard</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation) : ?>
                        <tr class="reservation">
                            <td><?php echo $reservation["name"] ?></td>
                            <td><?php echo $reservation["matricule"] ?></td>
                            <td>
                                <?php
                                $date_retour = date('Y-m-d h:i:s', strtotime($reservation['retour']));
                                $date_retour = (new DateTime())->setTimestamp(strtotime($reservation['retour']));
                                $now = new DateTime();
                                if ($now < $date_retour) {
                                    echo "Aucun retard";
                                } else {
                                    $retard = $date_retour->diff($now);
                                    if ($retard->days < 1) echo $retard->h . " h";
                                    else echo $retard->days . " j " . $retard->h . " h";
                                }
                                ?>
                            </td>
                            <td><a href=<?php echo "rendre.php?id=" . $reservation['id'] ?>>Rendre</a></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
</body>

</html>