<?php
if (isset($_POST['uploadForm'])) {
    
     if (empty($filterError)) {
    if ($_FILES["fileName"]["error"] > 0) {
      echo "Error: " . $_FILES["fileName"]["error"] . "<br>";
    }
    else {
      $fileName = $_FILES["fileName"]["name"];
      $fileType = $_FILES["fileName"]["type"];
      $fileContents = file_get_contents($_FILES["fileName"]["tmp_name"]);
      echo gettype($fileContents);
      /*Insert into Database*/
      include 'dbConnection.php';
      $conn = getDatabaseConnection("pictureDB");
      $binaryData = file_get_contents($_FILES["fileName"]["tmp_name"]);
      $sql = "INSERT INTO `pictures` (`fileName`,`fileType`, `fileData` ) " .
            "  VALUES ('$fileName','$fileType' ,'$fileContents' ); ";
      $stmt = $conn->prepare($sql);
      //$stmt->execute();
      $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
      echo "Here is the image you just uploaded into the database!(hover over the image)<br>";
    
    function createThumbnail(){
    $sourcefile = imagecreatefromstring(file_get_contents($_FILES["fileName"]["tmp_name"]));
    $newx = 150; $newy = 150;  //new size
    $thumb = imagecreatetruecolor($newx,$newy);
    imagecopyresampled($thumb, $sourcefile, 0,0, 0,0, $newx, $newy,     
    imagesx($sourcefile), imagesy($sourcefile));
    imagejpeg($thumb,"default_img/thumb.jpg"); //creates jpg image file called "thumb.jpg"
    
    echo "<img src='default_img/thumb.jpg' id='myImg'/>";
}
createThumbnail();
    }
}
}
?>