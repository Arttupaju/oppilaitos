<?php
$pdo = new PDO("mysql:host=localhost;dbname=oppilaitos", "root", "");

$stmt = $pdo->query("SELECT kurssit.*, opettajat.etunimi AS opettaja_etunimi, opettajat.sukunimi AS opettaja_sukunimi, tilat.nimi AS tila_nimi 
                     FROM kurssit 
                     JOIN opettajat ON kurssit.opettaja_id = opettajat.tunnusnumero 
                     JOIN tilat ON kurssit.tila_id = tilat.tunnus");
$kurssit = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fi">

<head>
    <meta charset="UTF-8">
    <li><a href="index.php">Takaisin</a></li>
    <title>Kurssit</title>
</head>

<body>
    <h1>Kurssit</h1>
    <a href="lisaa_kurssi.php">Lisää uusi kurssi</a>
    <table border="1">
        <tr>
            <th>Tunnus</th>
            <th>Nimi</th>
            <th>Kuvaus</th>
            <th>Alkupäivä</th>
            <th>Loppupäivä</th>
            <th>Opettaja</th>
            <th>Tila</th>
            <th>Toiminnot</th>
        </tr>
        <?php foreach ($kurssit as $kurssi): ?>
            <tr>
                <td><?= htmlspecialchars($kurssi['tunnus']) ?></td>
                <td><?= htmlspecialchars($kurssi['nimi']) ?></td>
                <td><?= htmlspecialchars($kurssi['kuvaus']) ?></td>
                <td><?= isset($kurssi['alkupaiva']) ? htmlspecialchars($kurssi['alkupaiva']) : 'Ei määritetty' ?></td>
                <td><?= isset($kurssi['loppupaiva']) ? htmlspecialchars($kurssi['loppupaiva']) : 'Ei määritetty' ?></td>
                <td><?= htmlspecialchars($kurssi['opettaja_etunimi'] . " " . $kurssi['opettaja_sukunimi']) ?></td>
                <td><?= htmlspecialchars($kurssi['tila_nimi']) ?></td>
                <td>
                    <a href="muokkaa_kurssia.php?id=<?= $kurssi['tunnus'] ?>">Muokkaa</a> |
                    <a href="poista_kurssi.php?id=<?= $kurssi['tunnus'] ?>"
                        onclick="return confirm('Haluatko varmasti poistaa?');">Poista</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>