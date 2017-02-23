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
 [type="submit"]{
	 margin-top:10%;
	margin-left:40%;
	font-size:18pt;
	color:grey;
	}
</style>
</head>
<body>
<form name="form1" action="" method="post">
<h3 align="center">Choose students to add to this academic year :) </h3>
 

 <?php 
//   if(isset($_POST['save'])){
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
   	
   	
   	
   	$s=0;
   	$y=date("Y");
   	while($s==0){
   		
   	$st=$file."students";
   	$st="students/".$st;
   	$myfile = fopen($st.".txt", "r") or die("Unable to open file!");
   	echo '<table>';
   	echo'<thead><th>Name </th><th>ID </th><th>Add </th></thead>';
   	$f=0;
   	while(!feof($myfile)) {
   	  $d=0;
   		$m= fgets($myfile);
   		$str = explode('*', $m);
   		//echo'<tr>';
   		//echo'<td>'.$str[1].'</td>';
   		//echo'<td>'.$str[0].'</td>';
   		$students=$root->getElementsByTagName('students')->item(0);
   		$studentnb=$students->getElementsByTagName('student')->length;
   		$student=$students->getElementsByTagName('student');
   		for($w=0;$w<$studentnb;$w++){
   			if($student->item($w)->getAttribute("id")==$str[0])
   				$d++;
   		}
   		if($d==0){
   			echo'<tr>';
   			echo'<td>'.$str[1].'</td>';
   			echo'<td>'.$str[0].'</td>';
   		echo'<td>Add<input type="checkbox" name="students[]" value="'.$str[0].'"/></td>';
   		echo'</tr>';
   		}
   		$f++;
   	}
   	
   	
   echo'</table>';
   echo'<input type="submit" name="add" value="Add Students"/>';
   
   	fclose($myfile);
   	$s=1;
      
    }
    if(isset($_POST['add'])){
    	$f=$_POST['students']; // a5adt value la yali nkabaso
    	//berja3 befta7 el file w bshouf haydol el id la min w bzidon 3al database
    	$st=$file."students";
    	$st="students/".$st;
    	$students=$root->getElementsByTagName('students')->item(0);
    	$student=$students->getElementsByTagName('student');
    	$studentnb=$students->getElementsByTagName('student')->length;
    	if($studentnb>0){
    		foreach($student as $std){
    			$val=$std->getAttribute('val');
    		}
    		$valeur=$val+1;
    	}
    		else {
    			$valeur=0;
    			$xml->createElement("students");
    		}
    	$myfile = fopen($st.".txt", "r") or die("Unable to open file!");
    	while(!feof($myfile)) {
    	
    		$m= fgets($myfile);
    		$str = explode('*', $m);
    		$idFile=$str[0];
    		$nameFile=$str[1];
    		if(isChecked('students',$idFile)){
    			//add la hayda el student 3ala students m3 id taba3o w name w val 7asab eza ken wala student or be5od e5r val increment
    			$student = $xml->createElement("student",$nameFile);
    			$id = $xml->createAttribute("id");
    			$id->value=$idFile;
    			$vale = $xml->createAttribute("val");
    			$vale->value=$valeur;
    			$student->appendChild($id);$student->appendChild($vale);
    			$root->getElementsByTagName('students')->item(0)->appendChild($student);
    		    $valeur++;
    		}
    		
    	
    	}
    	$xml->save($xmlFile);
    	
    }
 // }
   	
 ?>
 <?php 
 function IsChecked($table,$value){
 	if(!empty($_POST[$table])){
 		foreach($_POST[$table] as $chVal){
 			if($chVal == $value)
 				return true;
 		}
 	}
 	return false;
 }
 
 ?>
  </form>
 </body>
 </html>