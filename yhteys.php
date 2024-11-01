<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=oppilaitos", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Yhteys epäonnistui: " . $e->getMessage();
    exit;
}
?>
