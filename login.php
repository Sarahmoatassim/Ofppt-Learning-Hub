<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Vérifier Étudiant
    $stmt = $pdo->prepare("SELECT * FROM etudiant WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $table = 'etudiant';
    if (!$user) {
        // Vérifier Formateur
        $stmt = $pdo->prepare("SELECT * FROM formateur WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $table = 'formateur';
    }

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        $_SESSION['type'] = $table;
        echo "Connexion réussie ! Bonjour " . htmlspecialchars($user['prenom']);
    } else {
        echo "Email ou mot de passe incorrect !";
    }
}
?>