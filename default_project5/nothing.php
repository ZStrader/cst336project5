<?php
if (isset($_POST['uploadForm'])) {
    if ($_FILES["fileName"]["error"] > 0) {
      echo "Error: " . $_FILES["fileName"]["error"] . "<br>";
    }
    else {
      echo "Upload: " . $_FILES["fileName"]["name"] . "<br>";
      echo "Type: " . $_FILES["fileName"]["type"] . "<br>";
      echo "Size: " . ($_FILES["fileName"]["size"] / 1024) . " KB<br>";
      echo "Stored in: " . $_FILES["fileName"]["tmp_name"];
    }  
} //endIf form submission
?>

<form method="POST" enctype="multipart/form-data">
  Select file: <input type="file" name="fileName" /> <br />
  <input type="submit"  name="uploadForm" value="Upload File" />
</form>