<html>
<head>

<link rel="stylesheet" href="./css/style.css" type="text/css" media="screen">
<style>
  body{
    background-image: url(images/gre.jpg);
    -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  font-family: 'Roboto', sans-serif;
  }
</style>
</head>
<body>
<ul class="topnav" id="myTopnav">
  <li><a href="presence.php"><span>Presence list of the day</span></a></li>
  <li><a href="stdabsences.php"><span>Student Absences</span></a></li>
  <li><a href="ClassReport.php"><span>Class Report</span></a></li>
  <li><a href="StudentReport.php"><span>Student Report</span></a></li>
  <li><a href="AddStudents.php"><span>Add students</span></a></li>
  <li><a href="ModifyStudents.php"><span>Modify students</span></a></li>
  <li><a href="AddCorse.php"><span>Add course</span></a></li>
 <li><a href="AddCorseStudents.php"><span>Course students</span></a></li>
  <li class="icon">
    <a href="javascript:void(0);" onclick="myFunction()">&#9776;</a>
  </li>
</ul>
<script>
function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}

   
</script>
</body>
</html>
