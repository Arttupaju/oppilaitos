<?php
include 'yhteys.php';

if (isset($_POST['opiskelijanumero']) && isset($_POST['kurssi_id'])) {
    $opiskelijanumero = $_POST['opiskelijanumero'];
    $kurssi_id = $_POST['kurssi_id'];

    // Lisää merkintä kurssikirjautumiset-tauluun
    $stmt = $pdo->prepare("INSERT INTO kurssikirjautumiset (opiskelija_id, kurssi_id) VALUES (:opiskelija_id, :kurssi_id)");
    $stmt->execute([
        'opiskelija_id' => $opiskelijanumero,
        'kurssi_id' => $kurssi_id
    ]);

    echo "Opiskelija lisättiin kurssille onnistuneesti.";
    echo "<br><a href='opiskelijat.php'>Takaisin opiskelijalistaukseen</a>";
} else {
    echo "Opiskelijanumero tai kurssi puuttuu.";
}
?>
