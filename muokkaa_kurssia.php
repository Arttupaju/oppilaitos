<?php
include('yhteys.php');

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM kurssit WHERE tunnus = ?");
$stmt->execute([$id]);
$kurssi = $stmt->fetch();

$opettajat = $pdo->query("SELECT tunnusnumero, etunimi, sukunimi FROM opettajat")->fetchAll();
$tilat = $pdo->query("SELECT tunnus, nimi FROM tilat")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nimi = $_POST['nimi'];
    $kuvaus = $_POST['kuvaus'];
    $alkupaiva = $_POST['alkupaiva'];
    $loppupaiva = $_POST['loppupaiva'];
    $opettaja_id = $_POST['opettaja_id'];
    $tila_id = $_POST['tila_id'];

    $stmt = $pdo->prepare("UPDATE kurssit SET nimi = ?, kuvaus = ?, alkupaiva = ?, loppupaiva = ?, opettaja_id = ?, tila_id = ? WHERE tunnus = ?");
    $stmt->execute([$nimi, $kuvaus, $alkupaiva, $loppupaiva, $opettaja_id, $tila_id, $id]);

    header('Location: kurssit.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Muokkaa kurssia</title>
</head>
<body>
    <h1>Muokkaa kurssia</h1>
    <form method="post">
        <label>Nimi: <input type="text" name="nimi" value="<?= htmlspecialchars($kurssi['nimi']) ?>" required></label><br>
        <label>Kuvaus: <textarea name="kuvaus" required><?= htmlspecialchars($kurssi['kuvaus']) ?></textarea></label><br>
        <label>Alkupäivä: <input type="date" name="alkupaiva" value="<?= htmlspecialchars($kurssi['alkupäivä']) ?>" required></label><br>
        <label>Loppupäivä: <input type="date" name="loppupaiva" value="<?= htmlspecialchars($kurssi['loppupäivä']) ?>" required></label><br>
        <label>Opettaja:
            <select name="opettaja_id" required>
                <?php foreach ($opettajat as $opettaja): ?>
                    <option value="<?= $opettaja['tunnusnumero'] ?>" <?= $opettaja['tunnusnumero'] == $kurssi['opettaja_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($opettaja['etunimi'] . " " . $opettaja['sukunimi']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label><br>
        <label>Tila:
            <select name="tila_id" required>
                <?php foreach ($tilat as $tila): ?>
                    <option value="<?= $tila['tunnus'] ?>" <?= $tila['tunnus'] == $kurssi['tila_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($tila['nimi']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label><br>
        <input type="submit" value="Tallenna">
    </form>
</body>
</html>
