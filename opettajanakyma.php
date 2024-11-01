<?php
$pdo = new PDO("mysql:host=localhost;dbname=oppilaitos", "root", "");

$opettaja_id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM opettajat WHERE tunnusnumero = ?");
$stmt->execute([$opettaja_id]);
$opettaja = $stmt->fetch();

$stmt = $pdo->prepare("SELECT kurssit.*, tilat.nimi AS tila_nimi 
                       FROM kurssit 
                       JOIN tilat ON kurssit.tila_id = tilat.tunnus 
                       WHERE kurssit.opettaja_id = ?");
$stmt->execute([$opettaja_id]);
$kurssit = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Opettajan Tiedot</title>
</head>
<body>
    <h1>Opettaja: <?= htmlspecialchars($opettaja['etunimi'] . " " . $opettaja['sukunimi']) ?></h1>
    <p>Aine: <?= htmlspecialchars($opettaja['aine']) ?></p>

    <h2>Kurssit</h2>
    <table border="1">
        <tr><th>Nimi</th><th>Alkupäivä</th><th>Loppupäivä</th><th>Tila</th></tr>
        <?php foreach ($kurssit as $kurssi): ?>
            <tr>
                <td><?= htmlspecialchars($kurssi['nimi']) ?></td>
                <td><?= htmlspecialchars($kurssi['alkupäivä']) ?></td>
                <td><?= htmlspecialchars($kurssi['loppupäivä']) ?></td>
                <td><?= htmlspecialchars($kurssi['tila_nimi']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
