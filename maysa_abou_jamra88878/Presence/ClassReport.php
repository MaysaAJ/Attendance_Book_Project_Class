<?php
require('absence.php');
//hayde bade fiha bi mede m3ayane kif ken 7oudour el saf kilo
echo "<br>";
echo"<br>";
?>
<html>
<head><title></title>
<link rel="stylesheet" href="./css/class.css" type="text/css" media="screen">

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
<label>Choose the course : </label>

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
<label>Choose the academic year :</label> <select name="year" id="year">
 <?php  $start=2016;
 $val=0;
 $dates=array();
  while(1){
  	$j=$start+1;
  	$nameFile=$start."_".$j;
  	$f=$nameFile.".xml";
  	$f="xml/".$f;
  	if(file_exists($f)){
  	 	echo'<option value="'.$val.'">'.$nameFile.'</option>';
  	 	$dates[]=$nameFile;
  	 	$val++;
  	 	$start++;
  	 }
  	 else break;
}
  	
  ?>
</select>
<input type="submit" name="display" value="Show Report"/>
<p>
  

  <?php 
    if(isset($_POST['display'])){
    	echo '<script>
 		 		var a = document.getElementById("cours");
 		 		a.options['.$_POST['cours'].'].selected = true;
  		
 		</script>';
    	
    	
    	/*$y=date("Y");//a5ad senet el yom bade fatsh fiha 3a ases esm el cours bi alb el matiere
    	//bade awl shi kl el matieres
    	$xml=new DOMDocument();
    	$m=date("n");$y=date("Y");
    	$f=$y+1;
    	$d=$y-1;
    	if($m>=10&&$m<=12)
    		$file=$y."_".$f;
    	else if($m>=1&&$m<=7)
    		$file=$d."_".$y;
    	
    	*/
    	$dateSelected=$_POST['year'];  
    	$date=$dates[$dateSelected];
    	$xmlFile=$date.".xml";
    	$xmlFile="xml/".$xmlFile;
    	$xml->load($xmlFile);
    	$root=$xml->documentElement;
    	$s=0;
    	while($s==0){
    		
    			$matieres=$root->getElementsByTagName('matiere');
    	
    			foreach($matieres as $matiere){
    				$cours=$matiere->getElementsByTagName('cours')->item(0)->textContent;
    				$coursSelected=$_POST['cours'];
    				$c=$courss[$coursSelected];
    				if($cours==$c){
   
    					$seances=$matiere->getElementsByTagName('seance');
    					$nbSeances=$seances->length;
    					echo '<table border="1" cellspacing="5"';
    					echo "<thead>
                      	<th>Name</th>
                    	<th>ID</th>";
    					foreach($seances as $seance){
    						$datese=$seance->getElementsByTagName('date')->item(0)->textContent;
    						echo'<th>Le '.$datese.'</th>';
    					}
    					echo"</thead>";
    					$etudiants=$matiere->getElementsByTagName('etudiants');
    					$nbEt=$etudiants->length;
    					for($row=0;$row<$nbEt;$row++){
    						$j=0;
    						$tab=array();
    						$nomEt=$etudiants->item($row)->textContent;//esmo
    						$nbAbs=$etudiants->item($row)->getAttribute('nbAbs');
    						$nbRet=$etudiants->item($row)->getAttribute('nbRet');
    						
    						$id=$etudiants->item($row)->getAttribute('id');
    						///bade fetlo la hyda el etudiant 3a kl el seances w tale3lo el absences dates tab3oulo
    						$seances=$matiere->getElementsByTagName('seance');
    						foreach($seances as $seance){
    							$etudiantt=$seance->getElementsByTagName('etudiant');
    							$nbEt=$etudiantt->length;
    							for($t=0;$t<$nbEt;$t++){
    							
    								$etud=$etudiantt->item($t)->textContent;
    								//$etudSelected=$_POST['student'];
    								//$e=$studentt[$etudSelected];
    								if($nomEt==$etud){
    								
    									$abs=$etudiantt->item($t)->getAttribute('Absent');
    									if($abs==1){
    									//	$s=$absence[$j];
    									//	echo "<p><label>".$s."</label>";
    										
    										//$datee=$seance->getElementsByTagName('date')->item(0)->nodeValue;
    										//echo "<label>".$datee."</label></p>";
    										
    										$tab[$j]=1;
    										$j++;
    										break;
    									}
    									else {
    										$tab[$j]=0;
    										$j++;
    										break;
    									}
    										
    							
    										
    								}
    							}//niiheyt el boucle taba3 el etudiants bi we7de seance
    						}
    	                 //bade etba3 awal row bl table 3n awal etudiant
    	                 echo"<tr>";
    	                 echo'<td>'.$nomEt.'</td><td>'.$id.'</td>';
    	                 for($e=0;$e<$nbSeances;$e++){
    	                 
    	                 	if($tab[$e]==0)
    	                 		echo'<td align="center">&#10003</td>';
    	                 	else 
    	                 		echo'<td align="center">&#10007</td>';
    	                 }
    	                 echo"</tr>";
    					}//for el etudiants
    					echo "</table>";
    					$s=1;
    					break;
    				}//if mtl el cours
    			}//for taba3 el matiere
    		
    	}//niheyt while
    	
    }
    
    
  ?>
  </p>
</form>
</body>
</html>