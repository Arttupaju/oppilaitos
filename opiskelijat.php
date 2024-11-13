<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Opiskelijat</title>
</head>
<body>
    <li><a href="index.php">Takaisin</a></li>
    <h1>Opiskelijat</h1>
    
    <?php
    $pdo = new PDO("mysql:host=localhost;dbname=oppilaitos", "root", "");
    $stmt = $pdo->query("SELECT * FROM opiskelijat");

    echo "<table border='1'>";
    echo "<tr><th>Opiskelijanumero</th><th>Etunimi</th><th>Sukunimi</th><th>Vuosikurssi</th><th>Toiminnot</th></tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr>";
        echo "<td>{$row['opiskelijanumero']}</td>";
        echo "<td>{$row['etunimi']}</td>";
        echo "<td>{$row['sukunimi']}</td>";
        echo "<td>{$row['vuosikurssi']}</td>";
        echo "<td>
            <a href='muokkaa_opiskelijaa.php?id={$row['opiskelijanumero']}'>Muokkaa</a> |
            <a href='poista_opiskelija.php?id={$row['opiskelijanumero']}'>Poista</a> |
            <a href='kurssikirjautumiset.php?id={$row['opiskelijanumero']}'>Näytä kurssikirjautumiset</a> |
        </td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>

    <h2>Lisää opiskelija</h2>
    <form action="lisaa_opiskelija.php" method="post">
        <label>Etunimi: <input type="text" name="etunimi" required></label><br>
        <label>Sukunimi: <input type="text" name="sukunimi" required></label><br>
        <label>Syntymäpäivä: <input type="date" name="syntymapaiva" required></label><br>
        <label>Vuosikurssi: <input type="number" name="vuosikurssi" min="1" max="3" required></label><br>
        <input type="submit" value="Lisää">
    </form>
</body>
</html>
