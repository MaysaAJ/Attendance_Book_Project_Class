<?php
require('absence.php');
//hayde bade fiha bi mede m3ayane kif ken 7oudour el saf kilo
echo "<br>";
echo"<br>";
?>
<html>
<head><title></title>
<link rel="stylesheet" href="./css/report.css" type="text/css" media="screen">

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
<form name="form3" action="" method="post">
<label>Choose The student: </label>

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
$studentt=array();
while($s==0){
	$valeur=0;
		$all=$root->getElementsByTagName('students');
		$students=$all->item(0)->getElementsByTagName('student');
        
        echo'<select name="student" id="student">';
		    foreach($students as $student){
			$nameStd=$student->textContent;
			$studentt[]=$nameStd;
			echo '<option value="'.$valeur.'">'.$nameStd.'</option>';
			$valeur++;
		    }
		$s=1;
	
}
?>

<input type="submit" name="Show" value="Show Student Report"/>
<br><br>
<?php 
  if(isset($_POST['Show'])){
  	//bade eftol 3a kl el matiere bi hayde el sene w shouf eza el etudiant li tna2a esmo msajal bl medde se3eta bjib esm el medde w kl shi 3ano am3loumet w dates li 8ab fhon min el seances
  	echo '<script>
 		 		
  		var b = document.getElementById("student");
 		 		b.options['.$_POST['student'].'].selected = true;
 		</script>';
    					
                        
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
    					while($s==0){
    						   $matieres=$root->getElementsByTagName('matiere');
    					        foreach($matieres as $matiere){
    					        	
    					        	$cours=$matiere->getElementsByTagName('cours')->item(0)->textContent;
    					        	$etudiants=$matiere->getElementsByTagName('etudiants');
    					        	$nbEt=$etudiants->length;
    					        	
    					        	for($s=0;$s<$nbEt;$s++){
    					        		//bade eftol 3a esmo eza mwjoud bi hayde el medde
    					        		$nomEt=$etudiants->item($s)->textContent;
    					        		$etudSelected=$_POST['student'];
    					        		$e=$studentt[$etudSelected];
    					        		if($e==$nomEt){
    					        		
    					        			$nbAbs=$etudiants->item($s)->getAttribute('nbAbs');
    					        			$nbRet=$etudiants->item($s)->getAttribute('nbRet');
    					        			$seances=$matiere->getElementsByTagName('seance');
    					        			$nbSea=$seances->length;
    					        			echo"<p>";
    					        			echo'<div class="float">';
    					        			echo '<table border="1" cellspacing="5"';
    					        			if($nbSea!=0)
    					        			echo'<thead><th>Dates of all Seances</th><th>'.$cours.'</th></thead>';
    					        			$j=0;
    					        			
    					        			foreach($seances as $seance){
    					        				$etudiantt=$seance->getElementsByTagName('etudiant');
    					        				$datesea=$seance->getElementsByTagName('date')->item(0)->nodeValue;
    					        				$nbEt=$etudiantt->length;
    					        				
    					        				for($t=0;$t<$nbEt;$t++){
    					        						
    					        					$etud=$etudiantt->item($t)->textContent;
    					        					if($etud==$nomEt){
    					        						
    					        						
    					        						$tab=array();
    					        						echo '<tr><td>'.$datesea.'</td>';
    					        						$abs=$etudiantt->item($t)->getAttribute('Absent');
    					        						if($abs==1){
    					                                    
    					        							$tab[0]=1;
    					        						}
    					        						else {
    					        							$tab[0]=0;
    					        						}
    					        						if($tab[0]==0)	
    					        							echo'<td>&#10003</td>';
    					        						else
    					        							echo'<td>&#10007</td>';
    					                                
    					        						break;
    					        					}
    					        				}//niiheyt el boucle taba3 el etudiants bi we7de seance
    					        			}//bdal 3el2ane bi alb el seances la shil lal student kil absences taba3o 
    					       
    					        			echo'</tr>';
    					        			echo"</table>";
    					        			echo '</div>';
    					        			echo"</p>";
    					        			
    					        			echo"<br><br>";
    					        			break;
    					        		}//eza el esm bl matieres mtl esm el telmiz li tna2a
    					        	}
    					        }
    							
    							$s=1;
    						
    					}//e5er el while
    					
  }
?>