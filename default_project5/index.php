<?php
if (isset($_POST['uploadForm'])) {
    
     if (empty($filterError)) {
    if ($_FILES["fileName"]["error"] > 0) {
      echo "Error: " . $_FILES["fileName"]["error"] . "<br>";
    }
    else {
      $email = $_FILES["fileName"]["name"];
      $fileType = $_FILES["fileName"]["type"];
      $fileContents = file_get_contents($_FILES["fileName"]["tmp_name"]);
      //echo gettype($fileContents);
      
      include 'dbConnection.php';
      $conn = getDatabaseConnection("pictureDB");
      $binaryData = file_get_contents($_FILES["fileName"]["tmp_name"]);
      $sql = "INSERT INTO `pictures` (`email_address`,`caption`, `media` ) " .
            "  VALUES ('$email','$caption' ,'$media' ); ";
      $stmt = $conn->prepare($sql);
      //$stmt->execute();
      $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
      echo "Here is the image you just uploaded!<br>";
    
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

<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  
  <script>
  $(document).ready(function(){

        $('#file').bind('change', function() {
            var a=(this.files[0].size);
            if(a > 10000000) {
                alert('Image size too large: ' + (a/1000000) + "MB");
            }
        });
        
        $('#caroView').on('click', function(e){
            $('#myList').hide();
            $('#myCarousel').show();
        });
        
        $('#newList').on('click', function(e) {
            console.log("new");
            $('#myList').show();
            $('#myCarousel').hide();
        });
        
        $('#listView').on('click', function(e){
            $('#myCarousel').hide();
            
            $.ajax({
                    type: "GET",
                    url: "download.php",
                    dataType: "json",
                    success: function(data, status){
                        console.log(data);
                        $("#tableList").append("<tr><th>Email</th><th>Caption</th><th>Timestamp</th></tr>")
                        data.forEach(function(key){
                            $("#tableList").append("<tr><td>" + key.email_address + "</td><td>" + 
                            key.caption + "</td><td>" + key.timestamp + "</td></tr>");
                            
                        });
                        //$('#listView').hide();
                        //$('#buttonDiv').append("<button id='newList'>List View</button>");
                    }
                });
        });
  });
  
  
  
</script>
  
  <style>

   
   p.header_title {
            font-family: Tangerine, sans-serif;
            color: black;
            font-size: 60px;
            font-weight: bold;
            padding: 0px;
        }

        a.header_intro {
            font-family: Courier, serif, sans-serif;
            color: black;
            font-size: 36px;
            padding: 10px;
        }

        p.footer {
            font-family: Verdana, serif, sans-serif;
            color: black;
        }
        
        table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
   
   input[type=submit],input[type=file] {
     
     background-color: white;
            border: none;
            color: rgb(125,153,195);
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            
            font-size: 16px;
            
            border-radius: 30px;
            
   }
   
   input:hover{
     background-color: #00b8e6;
            color: white;
   }
   
   html{
       color: white;
       background-color:  rgb(125,153,195) ;
   }
   
  </style>
</head>
<title> Project 5: File Upload</title>
<body>
    <header>
        <p class="header_title"> Upload an image! (10MB or below)</p>
    </header>
  <center>
      
<form method="POST" enctype="multipart/form-data">
  Select file: <input id="file" type="file" name="fileName" /> <br />
  <input type="submit" name="uploadForm" value="Upload File" />
</form>
<div id="buttonDiv">
<button id="listView">List view</button>

<button id="caroView">Carousel view</button>
</div>
<br>
<div id="myList">
    <table id="tableList">
        
    </table>
</div>
<div id="myCarousel" class="carousel slide" style="width: 500px; height: 350px; margin: 0 auto" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <a href="default_img/fun1.jpg" target="new">
                    <img src="default_img/fun1.jpg" style="width: 500px; height: 350px;">
                    </a>
                </div>

                <div class="item">
                    <a href="default_img/fun2.jpg" target="new">
                    <img src="default_img/fun2.jpg" style="width: 500px; height: 350px;">
                    </a>
                </div>

                <div class="item">
                    <a href="default_img/fun3.jpg" target="new">
                    <img src="default_img/fun3.jpg" style="width: 500px; height: 350px;">
                    </a>
                </div>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
        </div>
</center>
<footer>
    <p>Footer</p>
</footer>
</body>