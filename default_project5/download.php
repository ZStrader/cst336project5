<?php
 include 'dbConnection.php';
 $conn = getDatabaseConnection("pictureDB");
 
 $sql= "SELECT email_address, timestamp, caption FROM pictures";
 
$stmt = $conn->prepare($sql);
$stmt->execute();
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($records);
?>