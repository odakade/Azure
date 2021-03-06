<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['url'])) {
        $url = $_POST['url'];
    } else {
        header("Location: analisa.php");
    }
} else {
    header("Location: analisa.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Azure Cognitive Service</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script language="javascript">
        document.getElementById('analisa_btn').click(); 
    </script>
    <style type="text/css">
  .topnav {
  background-color: #333;
  overflow: hidden;
}

/* Style the links inside the navigation bar */
.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

/* Change the color of links on hover */
.topnav a:hover {
  background-color: #ddd;
  color: black;
}

/* Add a color to the active/current link */
.topnav a.active {
  background-color: #4CAF50;
  color: white;
}
</style>
</head>
<body>
 <div class="topnav">
  <a href="http://arcosapp.azurewebsites.net/">Registri</a>
  <a class="active" href="http://arcosapp.azurewebsites.net/analisa.php">Analisa Gambar</a>
</div> 
<script type="text/javascript">
    function processImage() {
        
        var subscriptionKey = "741771bd722a49c3a4174c5514248901";
 
        var uriBase =
            "https://arcosvision.cognitiveservices.azure.com/vision/v2.0/analyze";
 
        var params = {
            "visualFeatures": "Categories,Description,Color",
            "details": "",
            "language": "en",
        };
 
        var sourceImageUrl = document.getElementById("inputImage").value;
        document.querySelector("#sourceImage").src = sourceImageUrl;
 
        // Make the REST API call.
        $.ajax({
            url: uriBase + "?" + $.param(params),
 
            // Request headers.
            beforeSend: function(xhrObj){
                xhrObj.setRequestHeader("Content-Type","application/json");
                xhrObj.setRequestHeader(
                    "Ocp-Apim-Subscription-Key", subscriptionKey);
            },
 
            type: "POST",
 
            // Request body.
            data: '{"url": ' + '"' + sourceImageUrl + '"}',
        })
 
        .done(function(data) {
            // Show formatted JSON on webpage.
            $("#responseTextArea").val(JSON.stringify(data, null, 2));
            $("#desc").text(data.description.captions[0].text);
        })
 
        .fail(function(jqXHR, textStatus, errorThrown) {
            // Display error message.
            var errorString = (errorThrown === "") ? "Error. " :
                errorThrown + " (" + jqXHR.status + "): ";
            errorString += (jqXHR.responseText === "") ? "" :
                jQuery.parseJSON(jqXHR.responseText).message;
            alert(errorString);
        });
    };
</script>
 
<h1>Selamat Datang di Azure Cognitive Service</h1>
<br><br>
<input type="text" name="inputImage" id="inputImage"
    value="<?php echo $url ?>" readonly />
<button id="analisa_btn" onclick="processImage()" class="w3-button w3-purple" >Analisa</button>
<a href="http://arcosapp.azurewebsites.net/analisa.php" class="w3-button w3-purple">Gambar Lainnya</a>
<br><br>
<script language="javascript">
document.getElementById('analyze_btn').click(); 
</script>
<div id="wrapper" style="width:1020px; display:table;">
    <div id="imageDiv" style="width:420px; display:table-cell;">
        <br><br>
        <img id="sourceImage" width="400" />
        <h3 id="desc"></h3>
    </div>
</div>
</body>
</html>
