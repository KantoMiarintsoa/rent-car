<?php
include_once('authorization.php');
require_once('database.php');
require_once('helpers.php');

$con = connect();
$find = $con->prepare("select * from reservation where id=:id");
$find->execute([
    ":id" => get_or_default("id", 0)
]);

$find_result = $find->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Rendre</title>
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
            <?php if ($find_result === false) :
                include_once("not-found.php");
            ?>
            <?php else : ?>
                <form class="rend" method="post">
                    <input type="input" name="car_state" class="form-input" placeholder="etat de la voiture">
                    <button class="primary-button">
                        recherche
                    </button>
                </form>
            <?php endif ?>
        </div>
    </div>
</body>

</html>

<?php
if (!isset($_POST["car_state"])) {
    return;
}
$today = new Datetime();
$today_str = $today->format("Y-m-d");
$cursor = $con->prepare('update reservation set is_given_back=1,car_state=:car_state,real_return_date=:real_return_date  where id=:id');
$cursor->execute([
    ":car_state" => $_POST["car_state"],
    ":real_return_date" => $today_str,
    ':id' => $_GET['id']
]);
header("Location: liste_reservation.php");
