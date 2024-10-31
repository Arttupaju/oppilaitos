<?php
$pdo = new PDO("mysql:host=localhost;dbname=oppilaitos", "root", "");
$stmt = $pdo->prepare("INSERT INTO opiskelijat (etunimi, sukunimi, syntymapaiva, vuosikurssi) VALUES (?, ?, ?, ?)");
$stmt->execute([$_POST['etunimi'], $_POST['sukunimi'], $_POST['syntymapaiva'], $_POST['vuosikurssi']]);

header("Location: opiskelijat.php");
?>
