<?php
require('absence.php');
echo "<br>";
echo "<br>";
?>
<html>
<head><title></title>
<link rel="stylesheet" href="./css/presence.css" type="text/css" media="screen">
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
<select name="cours" id="cours">
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
//$years=$root->getElementsByTagName('year');
$s=0;$i=0;
$courss=array();
while($s==0){
//	$nom=$years->item($i)->getAttribute('nomY');
	//if($nom==$y){
		$matieres=$root->getElementsByTagName('matiere');
        $valeur=0;
        
		foreach($matieres as $matiere){
			$cours=$matiere->getElementsByTagName('cours')->item(0)->textContent;
			$all=$matiere->getElementsByTagName('AllEtudiants')->item(0);
			$etudiants=$all->getElementsByTagName('etudiants');
			$nb=$etudiants->length;
			if($nb>0){
				$courss[]=$cours;
			?>
			<option value="<?php echo $valeur ; ?>"><?php echo $cours ;?></option>;
			
			<?php 
			$valeur++;
			}
		}
		$s=1;
	//}
//	else 
	//	$i++;
}
?>
 
</select>
<label>Enter the date : </label>
<input type="date" name="presenceDay" value="<?php echo isset($_POST['presenceDay']) ? $_POST['presenceDay'] : '' ?>"/>
<input type="submit" name="display" value="Display Students" />

<?php 

  //abl ma a3ml aya shi lama ekbos display lezm e5od el cours w 3a aseso o3rod el list des etudiants
  if(isset($_POST['display'])){
  	echo '<h1 align="center">Enter the list of students present today &#9997 </h1>';
  	echo '<script>
 		 		var a = document.getElementById("cours");
 		 		a.options['.$_POST['cours'].'].selected = true;
 		</script>';
  
  	$y=date("Y");//a5ad senet el yom bade fatsh fiha 3a ases esm el cours bi alb el matiere
  	//bade awl shi kl el matieres
  	$xml=new DOMDocument();
  
  	$xml->load($xmlFile);
  	$root=$xml->documentElement;
  	//$years=$root->getElementsByTagName('year');
  	$s=0;$i=0;
  	while($s==0){
  		//$nom=$years->item($i)->getAttribute('nomY');
  		//if($nom==$y){
  			$matieres=$root->getElementsByTagName('matiere');
  			 
  			foreach($matieres as $matiere){
  				$cours=$matiere->getElementsByTagName('cours')->item(0)->textContent;
  	            $coursSelected=$_POST['cours'];
  	            $c=$courss[$coursSelected];
  				if($cours==$c){
  					echo '<table cellspacing="5"';
  					 $etudiants=$matiere->getElementsByTagName('etudiants');
  					 $nbEt=$etudiants->length;
  					for($row=0;$row<$nbEt;$row++){
  						//bade o3rod el tolab ma3 asemiyon w checkboxes
  						$nomEt=$etudiants->item($row)->textContent;//esmo
  						$val=$etudiants->item($row)->getAttribute('val');
  						
  						
  						echo "<tr>";
  						echo'<td>'.$nomEt.'</td><td><input type="checkbox" name="students[]" value="'.$val.'"/>Present</td><td><input type="checkbox" name="retards[]" value="'.$val.'"/>En Retard</td>';
  						echo "</tr>";
  						
  						
  					}//for el etudiants
  					echo "</table>";
  					$s=1;
  					break;
  				}//if mtl el cours
  			}//for taba3 el matiere
  	//	}//eza ken mtl hyde el sene
  	//	else
  		//	$i++;
  	}//niheyt while	
  
  	   
 
  	
  	echo '<input type="submit" name="save" value="Save"/>';			
  }
  
  if(isset($_POST['save'])){
  	?>
  
  	<script type='text/javascript'>
  	window.onload = function(){
  	
  		var a =document.getElementById('cours');
  		a.options[<?php echo $_POST['cours'] ?>].selected=true;
  	 		 		
  	 		 		
  	 		 	 	
  	 	}
  	 	</script>
  	 <?php
  	$xml=new DOMDocument();
  	$xml->load($xmlFile);
  //	$rootTag = $xml->getElementsByTagName("master")->item(0);
  	$seance = $xml->createElement("seance");
  	
  	$root=$xml->documentElement;
  	//$years=$root->getElementsByTagName('year');
  	$s=0;$i=0;
  	$y=date("Y");
  	//lal te3dil
  	while($s==0){
  	//	$nom=$years->item($i)->getAttribute('nomY');
  	//	if($nom==$y){
  			$matieres=$root->getElementsByTagName('matiere');
  			 
  			foreach($matieres as $matiere){
  				$cours=$matiere->getElementsByTagName('cours')->item(0)->textContent;
  				$coursSelected=$_POST['cours'];
  				$c=$courss[$coursSelected];
  				if($cours==$c){
  					$etudiants=$matiere->getElementsByTagName('etudiants');
  					$nbEt=$etudiants->length;
  					for($row=0;$row<$nbEt;$row++){
  						$nomEtudiant =$etudiants->item($row)->textContent;//esmo
  						$val=$etudiants->item($row)->getAttribute('val');//valeur bl xml momken 1 la 17 msln 
  						$absence = 0; $retard = 0;
  						//bade 7otolo el attributs
  						//abl ma foout ef7as eza makbouse aw la2 bade shouf eza hayda el etudiant 3ndo out 1 krmel ma fout zedlo absent w eshya w houwe asesan msh bl saf sar
  						
  						
  							
  								$etudiant = $xml->createElement("etudiant",$nomEtudiant);
  								$abs = $xml->createAttribute('Absent');
  								$ret = $xml->createAttribute('Retard');
  								
  							if(IsChecked('students',$val)) {   // hayda makbous ye3ne present ye3ne lezm 3abe attribut absent=0
  	
  								$abs->value='0';
  								 
  								// 3am bef7as el retards
  								if(IsChecked('retards',$val)){
  									$ret->value="1";
  									$retard=1;
  	
  								}
  								else { // eza
  									$ret->value="0";
  									 
  	
  								}
  							} // eza houwe 7ader
  							else { // iza houwe 8ayeb akid retard lezm koun 0
  								$abs->value='1';
  								$absence=1;
  								$ret->value='0';
  								$retard=0;
  							}
  						
  							
  						$etudiant->appendChild($abs);
  						$etudiant->appendChild($ret);
  						//bade emro2 3a ma7al ma cours mtl li mna2yino w shouf el datechance taba3 kl etudiant w zido 3a kl etudiiant hon
  						
  						
  						$seance->appendChild($etudiant); // zedt el etudiant ma3 kl el attribut 3al seance
  						$nbAbs = $matiere->getElementsByTagName('etudiants')->item($row)->getAttribute('nbAbs');
  						$nbRet = $matiere->getElementsByTagName('etudiants')->item($row)->getAttribute('nbRet');
  						if($absence==1){
  							
  							$a = $nbAbs + 1;
  							$matiere->getElementsByTagName('etudiants')->item($row)->setAttribute('nbAbs',$a);
  	
  						}
  						else if($retard==1){
  							
  							$r = $nbRet + 1;
  							$matiere->getElementsByTagName('etudiants')->item($row)->setAttribute('nbRet',$r);
  	
  						}
  						$nbAbs = $matiere->getElementsByTagName('etudiants')->item($row)->getAttribute('nbAbs');
  						$nbRet = $matiere->getElementsByTagName('etudiants')->item($row)->getAttribute('nbRet');
  						
  					
  				} // for taba3 el seacne etudiant
  					$s=1;
  					break;
  				}// if el cours mtl li na2yne
  				 
  				 
  			} // niheyet el foreach el kbire
  		//}// fin de if nafs el year
  	//	else
  		//	$i++;
  	}
  	$nomDocteur = $_COOKIE['name'];
  	$docteur = $xml->createElement("nom",$nomDocteur);
  	$seance->appendChild($docteur);
  	$time = strtotime($_POST['presenceDay']);
  	if ($time != false){
  		$today = date('Y-m-d', $time);
  		
  	}
  	else{
  		$today=date("Y-m-d");
  		// fix it.
  	}
  	//$today = date("Y-m-d");
  	$date = $xml->createElement("date",$today);
  	$seance->appendChild($date);
    $s=0;$i=0;
  	while($s==0){
  		//$nom=$years->item($i)->getAttribute('nomY');
  		//if($nom==$y){
  			$matieres=$root->getElementsByTagName('matiere');
  			
  			foreach($matieres as $matiere){
  				$cours=$matiere->getElementsByTagName('cours')->item(0)->textContent;
  				$coursSelected=$_POST['cours'];
  				$c=$courss[$coursSelected];
  				if($cours==$c){
  				
  			$matiere->appendChild($seance);
  			$s=1;
  			break;
  				}
  			}
  			
  		//}
  		//else $i++;
  	}
  //	$rootTag->appendChild($seance);
  	$xml->save($xmlFile);
  	
 
  }
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