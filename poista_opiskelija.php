<?php
$pdo = new PDO("mysql:host=localhost;dbname=oppilaitos", "root", "");

if (!isset($_GET['id'])) {
    die("Opiskelijan ID:tä ei ole määritetty.");
}

$opiskelija_id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM opiskelijat WHERE opiskelijanumero = ?");
$stmt->execute([$opiskelija_id]);

header("Location: opiskelijat.php");
exit();
?>
