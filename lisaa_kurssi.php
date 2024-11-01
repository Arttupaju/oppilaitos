<?php
include('yhteys.php');

$opettajat = $pdo->query("SELECT tunnusnumero, etunimi, sukunimi FROM opettajat")->fetchAll();
$tilat = $pdo->query("SELECT tunnus, nimi FROM tilat")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nimi = $_POST['nimi'];
    $kuvaus = $_POST['kuvaus'];
    $alkupaiva = $_POST['alkupaiva'];
    $loppupaiva = $_POST['loppupaiva'];
    $opettaja_id = $_POST['opettaja_id'];
    $tila_id = $_POST['tila_id'];

    $stmt = $pdo->prepare("INSERT INTO kurssit (nimi, kuvaus, alkupaiva, loppupaiva, opettaja_id, tila_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nimi, $kuvaus, $alkupaiva, $loppupaiva, $opettaja_id, $tila_id]);

    header('Location: kurssit.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lisää kurssi</title>
</head>
<body>
    <h1>Lisää uusi kurssi</h1>
    <form method="post">
        <label>Nimi: <input type="text" name="nimi" required></label><br>
        <label>Kuvaus: <textarea name="kuvaus" required></textarea></label><br>
        <label>Alkupäivä: <input type="date" name="alkupaiva" required></label><br>
        <label>Loppupäivä: <input type="date" name="loppupaiva" required></label><br>
        <label>Opettaja:
            <select name="opettaja_id" required>
                <?php foreach ($opettajat as $opettaja): ?>
                    <option value="<?= $opettaja['tunnusnumero'] ?>"><?= htmlspecialchars($opettaja['etunimi'] . " " . $opettaja['sukunimi']) ?></option>
                <?php endforeach; ?>
            </select>
        </label><br>
        <label>Tila:
            <select name="tila_id" required>
                <?php foreach ($tilat as $tila): ?>
                    <option value="<?= $tila['tunnus'] ?>"><?= htmlspecialchars($tila['nimi']) ?></option>
                <?php endforeach; ?>
            </select>
        </label><br>
        <input type="submit" value="Tallenna">
    </form>
</body>
</html>
