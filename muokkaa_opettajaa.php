<?php
include('yhteys.php');

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM opettajat WHERE tunnusnumero = ?");
$stmt->execute([$id]);
$opettaja = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $etunimi = $_POST['etunimi'];
    $sukunimi = $_POST['sukunimi'];
    $aine = $_POST['aine'];
    
    $stmt = $pdo->prepare("UPDATE opettajat SET etunimi = ?, sukunimi = ?, aine = ? WHERE tunnusnumero = ?");
    $stmt->execute([$etunimi, $sukunimi, $aine, $id]);
    
    header('Location: opettajat.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Muokkaa opettajaa</title>
</head>
<body>
    <h1>Muokkaa opettajaa</h1>
    <form method="post">
        <label>Etunimi: <input type="text" name="etunimi" value="<?= htmlspecialchars($opettaja['etunimi']) ?>" required></label><br>
        <label>Sukunimi: <input type="text" name="sukunimi" value="<?= htmlspecialchars($opettaja['sukunimi']) ?>" required></label><br>
        <label>Aine: <input type="text" name="aine" value="<?= htmlspecialchars($opettaja['aine']) ?>" required></label><br>
        <input type="submit" value="Tallenna">
    </form>
</body>
</html>
