<?php
$pdo = new PDO("mysql:host=localhost;dbname=oppilaitos", "root", "");

$kurssi_id = $_GET['id'];

$stmt = $pdo->prepare("SELECT kurssit.*, opettajat.etunimi AS opettaja_etunimi, opettajat.sukunimi AS opettaja_sukunimi, tilat.nimi AS tila_nimi 
                       FROM kurssit 
                       JOIN opettajat ON kurssit.opettaja_id = opettajat.tunnusnumero 
                       JOIN tilat ON kurssit.tila_id = tilat.tunnus 
                       WHERE kurssit.tunnus = ?");
$stmt->execute([$kurssi_id]);
$kurssi = $stmt->fetch();

$stmt = $pdo->prepare("SELECT opiskelijat.etunimi, opiskelijat.sukunimi, opiskelijat.vuosikurssi 
                       FROM kirjautumiset 
                       JOIN opiskelijat ON kirjautumiset.opiskelija_id = opiskelijat.opiskelijanumero 
                       WHERE kirjautumiset.kurssi_id = ?");
$stmt->execute([$kurssi_id]);
$opiskelijat = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Kurssin Tiedot</title>
</head>
<body>
    <h1>Kurssi: <?= htmlspecialchars($kurssi['nimi']) ?></h1>
    <p>Kuvaus: <?= htmlspecialchars($kurssi['kuvaus']) ?></p>
    <p>Alkupäivä: <?= htmlspecialchars($kurssi['alkupäivä']) ?></p>
    <p>Loppupäivä: <?= htmlspecialchars($kurssi['loppupäivä']) ?></p>
    <p>Opettaja: <?= htmlspecialchars($kurssi['opettaja_etunimi'] . " " . $kurssi['opettaja_sukunimi']) ?></p>
    <p>Tila: <?= htmlspecialchars($kurssi['tila_nimi']) ?></p>

    <h2>Ilmoittautuneet opiskelijat</h2>
    <table border="1">
        <tr><th>Etunimi</th><th>Sukunimi</th><th>Vuosikurssi</th></tr>
        <?php foreach ($opiskelijat as $opiskelija): ?>
            <tr>
                <td><?= htmlspecialchars($opiskelija['etunimi']) ?></td>
                <td><?= htmlspecialchars($opiskelija['sukunimi']) ?></td>
                <td><?= htmlspecialchars($opiskelija['vuosikurssi']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
