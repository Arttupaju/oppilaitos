<?php
$pdo = new PDO("mysql:host=localhost;dbname=oppilaitos", "root", "");

$stmt = $pdo->query("SELECT * FROM opettajat");
$opettajat = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <li><a href="index.php">Takaisin</a></li>
    <title>Opettajat</title>
</head>
<body>
    <h1>Opettajat</h1>
    <a href="lisaa_opettaja.php">Lisää uusi opettaja</a>
    <table border="1">
        <tr><th>Tunnusnumero</th><th>Etunimi</th><th>Sukunimi</th><th>Aine</th><th>Toiminnot</th></tr>
        <?php foreach ($opettajat as $opettaja): ?>
            <tr>
                <td><?= htmlspecialchars($opettaja['tunnusnumero']) ?></td>
                <td><?= htmlspecialchars($opettaja['etunimi']) ?></td>
                <td><?= htmlspecialchars($opettaja['sukunimi']) ?></td>
                <td><?= htmlspecialchars($opettaja['aine']) ?></td>
                <td>
                    <a href="muokkaa_opettajaa.php?id=<?= $opettaja['tunnusnumero'] ?>">Muokkaa</a> | 
                    <a href="poista_opettaja.php?id=<?= $opettaja['tunnusnumero'] ?>" onclick="return confirm('Haluatko varmasti poistaa?');">Poista</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
