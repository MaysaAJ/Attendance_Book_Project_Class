<?php
require('absence.php');
echo "<br>";
echo "<br>";
?>
<html>
<head>
<link rel="stylesheet" href="./css/stdabsences.css" type="text/css" media="screen">

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
<p>
   <label>Choose the corse : </label>
  
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
     $s=0;$i=0;
     $y=date("Y");
     $courss=array();
     while($s==0){
     	  $valeur=0;
     		$matieres=$root->getElementsByTagName('matiere');
     
     		echo'<select name="cours" id="cours">';
     		foreach($matieres as $matiere){
     			$cours=$matiere->getElementsByTagName('cours')->item(0)->textContent;
     			$all=$matiere->getElementsByTagName('AllEtudiants')->item(0);
     			$etudiants=$all->getElementsByTagName('etudiants');
     			$nb=$etudiants->length;
     			if($nb>0){
     				$courss[]=$cours;
     			
     			echo '<option value="'.$valeur.'">'.$cours.'</option>';
     			$valeur++;
     			}
     		}
     		$s=1;
     	
     }
     ?>
   </select>
   <label>Choose the student : </label>
   
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
     		echo'<select name="student" id="student">';
     		
     		foreach($students as $student){
     			$nomStd=$student->textContent;
     			$studentt[]=$nomStd;
     			echo '<option value="'.$valeur.'">'.$nomStd.'</option>';
     			$valeur++;
     			
     		}
     		$s=1;
    
     }
     echo"</select>";
    ?>
   
    <input type="submit" name="show" value="Show this Student absences "/>
    
    </p>
    <?php 
  if(isset($_POST['show'])){
  	echo '<script>
 		 		var a = document.getElementById("cours");
 		 		a.options['.$_POST['cours'].'].selected = true;
  		var b = document.getElementById("student");
 		 		b.options['.$_POST['student'].'].selected = true;
 		</script>';
     ?>
     
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
       $s=0;$i=0;$j=0;
       $y=date("Y");
       while($s==0){
     //  	$nom=$years->item($i)->getAttribute('nomY');
      // 	if($nom==$y){
       		$matieres=$root->getElementsByTagName('matiere');
       		foreach($matieres as $matiere){
       			$cours=$matiere->getElementsByTagName('cours')->item(0)->textContent;
       			$coursSelected=$_POST['cours'];
       			$c=$courss[$coursSelected];
       			if($cours==$c){
       				
       				$all=$matiere->getElementsByTagName('AllEtudiants')->item(0);
       				$etudiants=$all->getElementsByTagName('etudiants');
       				$nbEt=$etudiants->length;
       				for($i=0;$i<$nbEt;$i++){
       					$etud=$etudiants->item($i)->textContent;
       					$etudSelected=$_POST['student'];
       					$e=$studentt[$etudSelected];
       					if($e==$etud){
       						 $nbAbs=$etudiants->item($i)->getAttribute('nbAbs');
       						 $nbRet=$etudiants->item($i)->getAttribute('nbRet');
       						 echo '<div class="float">';
       						 echo '<table cellspacing="5" cellpadding="6">';
       						 echo '<thead><th>Date of Seance</th>
                    	<th>Present</th><th>En retard</th></thead>';
       						 
       						 break;
       					}
       				}
       				
       				$seances=$matiere->getElementsByTagName('seance');
       				foreach($seances as $seance){
       					
       					$etudiantt=$seance->getElementsByTagName('etudiant');
       					$nbEt=$etudiantt->length;
       					for($t=0;$t<$nbEt;$t++){
       					
       						$etud=$etudiantt->item($t)->textContent;
       						$etudSelected=$_POST['student'];
       						$e=$studentt[$etudSelected];
       						
       						if($e==$etud){
       							
       							$abs=$etudiantt->item($t)->getAttribute('Absent');
       							$datee=$seance->getElementsByTagName('date')->item(0)->nodeValue;
       							$ret=$etudiantt->item($t)->getAttribute('Retard');
       							
       							
  
       							if($ret==0)
       								$rett='Non';
       							else if($ret==1)
       								$rett='En retard';
       							
       							echo'<tbody><tr>';
       							echo'<td> On '.$datee.'</td>';
       							//echo '<td>'.$pres.'</td>';
       							if($abs==0)
       							echo '<td>&#10003</td>';
       							else if($abs==1)
       								echo '<td>&#10007</td>';
       							if($ret==0)
     		                    echo'<td>&#10007</td>';
       							else if($ret==1)
       								echo'<td>&#10003</td>';
       							echo'</tbody></tr>';
       							break;
       						
       						}
       					}//niiheyt el boucle taba3 el etudiants bi we7de seance
       				}
       				
       				//if($nbAbs==3){
       				
       					//echo "<p>This student is fired from the class !! To give him a chance you can do it in the option : Give Chance :)</p> ";
       				//}
       				
       				break;
       			}//if cours nafso li bl matiere	
       		}
       		$s=1;
      // 	}
      // 	else
       	//	$i++;
       	echo'</table>';
       	echo'</div>';
       }
       
  }
  
  
       ?>
    
  <img src="images/pres.jpg" width="300" height="500" alt="imag1" align="right"/></br>
   
 
   

 
</form>
</body>
</html>