<?php
  //id w name li elo bzidon 3l students of the year
require('absence.php');
//hayde bade fiha bi mede m3ayane kif ken 7oudour el saf kilo
echo "<br>";
echo"<br>";
?>

<html>
<head>
<link rel="stylesheet" href="./css/modify.css" type="text/css" media="screen">
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

 <?php 

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
 $xml->load($xmlFile);
 $root=$xml->documentElement;
 // $years=$root->getElementsByTagName('year');
 $s=0;
 $y=date("Y");
 $studentt=array();
 while($s==0){
 	$valeur=0;
 	$all=$root->getElementsByTagName('students');
 	$students=$all->item(0)->getElementsByTagName('student');
 	echo'<div class="first">';
 	echo'<label>Enter name of the student : <label><select name="student" id="student">';
 	 
 	foreach($students as $student){
 		$nomStd=$student->textContent;
 		$studentt[]=$nomStd;
 		echo '<option value="'.$valeur.'">'.$nomStd.'</option>';
 		$valeur++;
 
 	}
 	echo'</select>';
 	$s=1;
 
 }
 echo"</select>";
 echo '<input type="submit" name="show" value="show ID"/>';
 echo'</div>';
 ?>
 <?php 
   if(isset($_POST['show'])){
   	 ?>
   	<script type='text/javascript'>
   	window.onload = function(){
   		 
   		var a =document.getElementById('student');
   		a.options[<?php echo $_POST['student'] ?>].selected=true;
   	  	 		 		
   	  	 		 		
   	  	 		 	 	
   	  	 	}
   	  	 	</script>
   	  	 	<p><br><br>
   	 <?php 
   	$all=$root->getElementsByTagName('students');
   	$students=$all->item(0)->getElementsByTagName('student');
    
   	foreach($students as $student){
   		$nomStd=$student->textContent;
   		$stdSelected=$_POST['student'];
   		$s=$studentt[$stdSelected];
   		if($s==$nomStd){
   		  
   			$id=$student->getAttribute('id');
   			echo'<div class="last">';
   			echo'<input type="text" name="id" value="'.$id.'" />';
   			
   		    break;
   		}
   	
   	}
   	echo'<input type="submit" name="modify" value="Modify"/>';
   	echo'</div>';
   }
 ?>
 </p>
 <?php 
    if(isset($_POST['modify'])){
    	$idposted=$_POST['id'];
    	$stdSelected=$_POST['student'];
    	$s=$studentt[$stdSelected];
    	
    	$all=$root->getElementsByTagName('students');
    	$students=$all->item(0)->getElementsByTagName('student');
    	
    	foreach($students as $student){
    		$nomStd=$student->textContent;
    		if($nomStd==$s){
    			//$id=$student->getAttribute('id');
    			//$id->value=$idposted;
    			$student->setAttribute('id',$idposted);
    			break;
    		}
    	}
    	
    	$matieres=$root->getElementsByTagName('matieres')->item(0);
    	$matiere=$matieres->getElementsByTagName('matiere');
    	foreach($matiere as $mat){
    		$etudiants=$mat->getElementsByTagName('AllEtudiants')->item(0);
    		$etudiant=$etudiants->getElementsByTagName('etudiants');
    		foreach($etudiant as $et){
    			$nomet=$et->textContent;
    			if($nomet==$s){
    				$et->setAttribute('id',$idposted);
    			}
    		}
    	}
    	// bade 3adel kmn bl matieres hayda el etudiant m3 id taba3o
    	
    	$xml->save($xmlFile);
    }
 ?>
  </form>
 </body>
 </html>
