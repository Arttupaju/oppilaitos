<?php
include('yhteys.php');

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM kurssit WHERE tunnus = ?");
$stmt->execute([$id]);

header('Location: kurssit.php');
exit;
?>
