<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: connexion.html");
    exit;
}
echo "Bonjour " . htmlspecialchars($_SESSION['user']['prenom']) . " (" . $_SESSION['type'] . ")";
echo "<br><a href='logout.php'>Se déconnecter</a>";
?>