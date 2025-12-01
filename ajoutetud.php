<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['type']; // etudiant ou formateur
    $prenom = trim($_POST['prenom']);
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!$prenom || !$nom || !$email || !$password) {
        die("Tous les champs sont requis !");
    }

    // Hasher le mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        if ($type === 'etudiant') {
            $sql = "INSERT INTO etudiant (prenom, nom, email, password) VALUES (:prenom, :nom, :email, :password)";
        } else if ($type === 'formateur') {
            $sql = "INSERT INTO formateur (prenom, nom, email, password) VALUES (:prenom, :nom, :email, :password)";
        } else {
            die("Type invalide !");
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':prenom' => $prenom,
            ':nom' => $nom,
            ':email' => $email,
            ':password' => $hashedPassword
        ]);

        echo "Inscription réussie ! <a href='login.php'>Se connecter</a>";
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}
?>