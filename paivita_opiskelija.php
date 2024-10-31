<?php
$pdo = new PDO("mysql:host=localhost;dbname=oppilaitos", "root", "");

$stmt = $pdo->prepare("UPDATE opiskelijat SET etunimi = ?, sukunimi = ?, syntymapaiva = ?, vuosikurssi = ? WHERE opiskelijanumero = ?");
$stmt->execute([$_POST['etunimi'], $_POST['sukunimi'], $_POST['syntymapaiva'], $_POST['vuosikurssi'], $_POST['opiskelijanumero']]);

header("Location: opiskelijat.php");
exit();
