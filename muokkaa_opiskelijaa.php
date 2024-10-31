<?php
$pdo = new PDO("mysql:host=localhost;dbname=oppilaitos", "root", "");

if (!isset($_GET['id'])) {
    die("Opiskelijan ID:tä ei ole määritetty.");
}

$opiskelija_id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM opiskelijat WHERE opiskelijanumero = ?");
$stmt->execute([$opiskelija_id]);
$opiskelija = $stmt->fetch();

if (!$opiskelija) {
    die("Opiskelijaa ei löydy.");
}
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Muokkaa opiskelijaa</title>
</head>
<body>
    <h1>Muokkaa opiskelijaa</h1>

    <form action="paivita_opiskelija.php" method="post">
        <input type="hidden" name="opiskelijanumero" value="<?php echo $opiskelija['opiskelijanumero']; ?>">
        <label>Etunimi: <input type="text" name="etunimi" value="<?php echo htmlspecialchars($opiskelija['etunimi']); ?>" required></label><br>
        <label>Sukunimi: <input type="text" name="sukunimi" value="<?php echo htmlspecialchars($opiskelija['sukunimi']); ?>" required></label><br>
        <label>Syntymäpäivä: <input type="date" name="syntymapaiva" value="<?php echo $opiskelija['syntymapaiva']; ?>" required></label><br>
        <label>Vuosikurssi: <input type="number" name="vuosikurssi" min="1" max="3" value="<?php echo $opiskelija['vuosikurssi']; ?>" required></label><br>
        <input type="submit" value="Päivitä">
    </form>
</body>
</html>
