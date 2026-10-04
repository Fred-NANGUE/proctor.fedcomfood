<?php
    // Démarre la session
    session_start();

    // Vider les variables de session
    $_SESSION = [];

    // Détruire la session
    session_unset();
    session_destroy();

    // Supprimer le cookie de session
    if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
    $params["path"], $params["domain"],
    $params["secure"], $params["httponly"]
    );
    }

    // Rediriger vers la page de connexion
    header('Location:accueil.php?deconnexion=okay&page=connexion');
    exit;
?>
