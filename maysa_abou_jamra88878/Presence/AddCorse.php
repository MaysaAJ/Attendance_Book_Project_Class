<?php
  //id w name li elo bzidon 3l students of the year
require('absence.php');
//hayde bade fiha bi mede m3ayane kif ken 7oudour el saf kilo
echo "<br>";
echo"<br>";
?>

<html>
<head>
<link rel="stylesheet" href="./css/add.css" type="text/css" media="screen">
 <style>
body{
    background: url(images/gre.jpg);
    -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  font-family: 'Roboto', sans-serif;
  }
  
 </style>
</head>
<body>
<form name="form1" action="" method="post">
<table align="center" cellspacing="5" cellpadding="3">
  <tr><td> <label>Code of the Corse : </label></td><td><input type="text" name="code"/></td>
 
   <tr><td><label>Description of the Corse : </label></td><td><input type="text" name="desc"/></td>
 
 </table>
 <p align="center"><input type="submit" name="save" value="Add Corse"></p>
 </form>
 <?php 
   if(isset($_POST['save'])){
   	$xml=new DOMDocument();
   	$m=date("n");$y=date("Y");
   	$f=$y+1;
   	$d=$y-1;
   	if($m>=10&&$m<=12)
   		$file=$y."_".$f;
   	else if($m>=1&&$m<=7)
   		$file=$d."_".$y;
   	
   	
   	$xmlFile=$file.".xml";
   	$xmlFile="xml/".$xmlFile;
   	if(file_exists($xmlFile)){
   		$xml->load($xmlFile);
   		$root=$xml->documentElement;
   		 
   	}
   	else {
   		$root=$xml->createElement('master');
   		$xml->appendChild($root);
   		$xml->save($xmlFile);
   	}
   	
   	
   	$s=0;$i=0;
   	$y=date("Y");
   	while($s==0){
   		
   	$code=$_POST['code'];
   	$desc=$_POST['desc'];
   	$corse = $xml->createElement("corse",$code);
   	$corse->setAttribute('Description',$desc);
   	$root->getElementsByTagName('corses')->item(0)->appendChild($corse);
   	$s=1;
   	
   	}
   	$xml->save($xmlFile);
   }
 ?>
 </body>
 </html>