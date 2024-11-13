<?php
include 'yhteys.php';

if (!isset($_GET['opiskelijanumero'])) {
    echo "Opiskelijanumero puuttuu!";
    exit;
}

$opiskelijanumero = $_GET['opiskelijanumero'];

// Hakee opiskelijan tiedot
$stmt = $pdo->prepare("SELECT * FROM opiskelijat WHERE opiskelijanumero = ?");
$stmt->execute([$opiskelijanumero]);
$opiskelija = $stmt->fetch();

if (!$opiskelija) {
    echo "Opiskelijaa ei löytynyt.";
    exit;
}

// Haetaan kurssit
$kurssiStmt = $pdo->query("SELECT * FROM kurssit");
$kurssit = $kurssiStmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Lisää opiskelija kurssille</title>
</head>
<body>
    <h1>Lisää opiskelija kurssille</h1>
    <p>Opiskelija: <?php echo htmlspecialchars($opiskelija['etunimi']) . " " . htmlspecialchars($opiskelija['sukunimi']); ?></p>

    <form action="tallenna_kurssikirjautuminen.php" method="POST">
        <input type="hidden" name="opiskelijanumero" value="<?php echo $opiskelijanumero; ?>">
        
        <label for="kurssi_id">Valitse kurssi:</label>
        <select name="kurssi_id" id="kurssi_id">
            <?php foreach ($kurssit as $kurssi): ?>
                <option value="<?php echo $kurssi['tunnus']; ?>"><?php echo htmlspecialchars($kurssi['nimi']); ?></option>
            <?php endforeach; ?>
        </select>
        
        <button type="submit">Lisää kurssille</button>
    </form>
</body>
</html>
