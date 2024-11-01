<?php
include('yhteys.php');

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM opettajat WHERE tunnusnumero = ?");
$stmt->execute([$id]);

header('Location: opettajat.php');
exit;
?>
