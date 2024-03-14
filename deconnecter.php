<?php
    session_start();

    // supprimer tous les variables de session
    session_unset();

    // detruire la session
    session_destroy();

    header("Location: login.php");
?>