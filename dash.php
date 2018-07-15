<html>
<head>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <title>E-edit!</title> 
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="http://jcrop-cdn.tapmodo.com/v0.9.12/js/jquery.Jcrop.min.js"></script>

</head>
<body>
<?php
session_start();
if($_SESSION['Cd'] === NULL){
  header("location:home.html");
}
?>

<div class="title_background">
<div class="acc_title"> E-EDIT</div>
<div class="logout">LOGOUT</div>
</div>
<form id="form">
  <div class="section1">
<div class="Upload">Select Image</div> 
  <input id="file" class="file_select" value="Select File" type="file" >
  <div id="views"></div>
</div>
  
  <div class="section2">
  <div class="edit_image">Edit Image</div>
  <button class="button" id="cropbutton"  type="button">Crop</button>
  <button id="scalebutton" class="button" type="button">Scale</button>
  <button id="rotatebutton" class="button" type="button">Rotate</button>
  <button id="hflipbutton" class="button" type="button">H-flip</button>
  <button id="vflipbutton" class="button" type="button">V-flip</button>
  <br>
  <div id="views"></div>
  <h2>Submit form</h2>
  <input type="submit" value="Upload image" />
</div>
</form>
<div class="clear"></div>
<div class="view_section">View Image</div>
<Script>
var crop_max_width = 400;
var crop_max_height = 400;
var jcrop_api;
var canvas;
var context;
var image;

var prefsize;
$(".section2").css('display','none');
$("#file").change(function() {
  loadImage(this);
  $(".section2").css('display','block');
});

function loadImage(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    canvas = null;
    reader.onload = function(e) {
      image = new Image();
      image.onload = validateImage;
      image.src = e.target.result;
    }
    reader.readAsDataURL(input.files[0]);
  }
}

function dataURLtoBlob(dataURL) {
  var BASE64_MARKER = ';base64,';
  if (dataURL.indexOf(BASE64_MARKER) == -1) {
    var parts = dataURL.split(',');
    var contentType = parts[0].split(':')[1];
    var raw = decodeURIComponent(parts[1]);

    return new Blob([raw], {
      type: contentType
    });
  }
  var parts = dataURL.split(BASE64_MARKER);
  var contentType = parts[0].split(':')[1];
  var raw = window.atob(parts[1]);
  var rawLength = raw.length;
  var uInt8Array = new Uint8Array(rawLength);
  for (var i = 0; i < rawLength; ++i) {
    uInt8Array[i] = raw.charCodeAt(i);
  }

  return new Blob([uInt8Array], {
    type: contentType
  });
}

function validateImage() {
  if (canvas != null) {
    image = new Image();
    image.onload = restartJcrop;
    image.src = canvas.toDataURL('image/png');
    console.log(image.src);
  } else restartJcrop();
}

function restartJcrop() {
  if (jcrop_api != null) {
    jcrop_api.destroy();
  }
  $("#views").empty();
  $("#views").append("<canvas id=\"canvas\">");
  canvas = $("#canvas")[0];
  context = canvas.getContext("2d");
  canvas.width = image.width;
  canvas.height = image.height;
  context.drawImage(image, 0, 0);
  $("#canvas").Jcrop({
    onSelect: selectcanvas,
    onRelease: clearcanvas,
    boxWidth: crop_max_width,
    boxHeight: crop_max_height
  }, function() {
    jcrop_api = this;
  });
  clearcanvas();
  $("#formval").remove();
  //$('<input type="hidden" name="formData" value="" ')
}

function clearcanvas() {
  prefsize = {
    x: 0,
    y: 0,
    w: canvas.width,
    h: canvas.height,
  };
}

function selectcanvas(coords) {
  prefsize = {
    x: Math.round(coords.x),
    y: Math.round(coords.y),
    w: Math.round(coords.w),
    h: Math.round(coords.h)
  };
}

function applyCrop() {
  canvas.width = prefsize.w;
  canvas.height = prefsize.h;
  context.drawImage(image, prefsize.x, prefsize.y, prefsize.w, prefsize.h, 0, 0, canvas.width, canvas.height);
  validateImage();
}

function applyScale(scale) {
  if (scale == 1) return;
  canvas.width = canvas.width * scale;
  canvas.height = canvas.height * scale;
  context.drawImage(image, 0, 0, canvas.width, canvas.height);
  validateImage();
}

function applyRotate() {
  canvas.width = image.height;
  canvas.height = image.width;
  context.clearRect(0, 0, canvas.width, canvas.height);
  context.translate(image.height / 2, image.width / 2);
  context.rotate(Math.PI / 2);
  context.drawImage(image, -image.width / 2, -image.height / 2);
  validateImage();
}

function applyHflip() {
  context.clearRect(0, 0, canvas.width, canvas.height);
  context.translate(image.width, 0);
  context.scale(-1, 1);
  context.drawImage(image, 0, 0);
  validateImage();
}

function applyVflip() {
  context.clearRect(0, 0, canvas.width, canvas.height);
  context.translate(0, image.height);
  context.scale(1, -1);
  context.drawImage(image, 0, 0);
  validateImage();
}

$("#cropbutton").click(function(e) {
  applyCrop();
});
$("#scalebutton").click(function(e) {
  var scale = prompt("Scale Factor:", "1");
  applyScale(scale);
});
$("#rotatebutton").click(function(e) {
  applyRotate();
});
$("#hflipbutton").click(function(e) {
  applyHflip();
});
$("#vflipbutton").click(function(e) {
  applyVflip();
});

$("#form").submit(function(e) {
  e.preventDefault();
  name=$("#file").val();
  console.log("name",name);
  formData = new FormData($(this)[0]);
  var blob = dataURLtoBlob(canvas.toDataURL('image/png'));
  //console.log(blob);
  //---Add file blob to the form data
  formData.append("cropped_image", blob);
  $.ajax({
    url: "ajax.php",
    type: "POST",
    data: formData,
    contentType: false,
    cache: false,
    processData: false,
    success: function(data) {
      //alert(data);
      location.reload();
    },
    error: function(data) {
      alert(data);
    },
    complete: function(data) {}
  });
});
$(".view_section").click(function(){
  window.open("view.php");
});
$(".logout").click(function(){
  $('<form action="logout.php" method="POST"/>')                                
                                .appendTo($(document.body)) //it has to be added somewhere into the <body>
                                .submit();
});
</script>
</html>
</body>
</html>