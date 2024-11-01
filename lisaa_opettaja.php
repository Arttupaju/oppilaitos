<?php
include('yhteys.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $etunimi = $_POST['etunimi'];
    $sukunimi = $_POST['sukunimi'];
    $aine = $_POST['aine'];
    
    $stmt = $pdo->prepare("INSERT INTO opettajat (etunimi, sukunimi, aine) VALUES (?, ?, ?)");
    $stmt->execute([$etunimi, $sukunimi, $aine]);
    
    header('Location: opettajat.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lisää opettaja</title>
</head>
<body>
    <h1>Lisää opettaja</h1>
    <form method="post">
        <label>Etunimi: <input type="text" name="etunimi" required></label><br>
        <label>Sukunimi: <input type="text" name="sukunimi" required></label><br>
        <label>Aine: <input type="text" name="aine" required></label><br>
        <input type="submit" value="Tallenna">
    </form>
</body>
</html>
