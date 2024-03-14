<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>
    <div class="login-container">
        <form class="login" action="" method="post">
            <h3> Connectez vous</h3>
            <input type="text" name="username" class="form-input">
            <input type="password" class="form-input" name="password">
            <button class="primary-button">se connecter</button>
        </form>
    </div>
</body>

</html>


<?php
require_once('database.php');

if (isset($_POST["username"])) {
    $username = $_POST["username"];
    $pasword = $_POST["password"];
    $hashed_password = md5($pasword);

    //initialiser la connexion
    $con = connect();
    // préparer la commande
    $cursor = $con->prepare("SELECT id, username FROM user WHERE username=? AND password=?");
    // executer la commande en insérant les paramètres
    $cursor->execute([$username, $hashed_password]);
    // prendre le resultat
    $result = $cursor->fetch(PDO::FETCH_ASSOC);

    if ($result == false) {
        echo "mot de passe incorrect";
        return;
    }

    $_SESSION["user_id"] = $result["id"];
    $_SESSION['username'] = $result['username'];
    header("Location: index.php");
}
