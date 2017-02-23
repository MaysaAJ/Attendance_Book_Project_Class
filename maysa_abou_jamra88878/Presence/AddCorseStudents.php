<?php
 
require('absence.php');
//hayde bade fiha bi mede m3ayane kif ken 7oudour el saf kilo
echo "<br>";
echo"<br>";
  ?>
  
  <html>
<head><title></title>
<link rel="stylesheet" href="./css/courseStd.css" type="text/css" media="screen">
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
<label>Choose the course students: </label>

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
$coursarr=array();
while($s==0){
	    $valeur=0;
		$corses=$root->getElementsByTagName('corses');
		//bade el string
		$corse=$corses->item(0)->getElementsByTagName('corse');
        echo'<select name="cours" id="cours">';
        
		foreach($corse as $courss){
			$cours=$courss->textContent;
			$coursarr[]=$cours;
			echo '<option value="'.$valeur.'">'.$cours.'</option>';
			$valeur++;
		}
		$s=1;
	
}
?>
 
</select>
<input type="submit" name="display" value="Show Students "/>
<?php 
  if(isset($_POST['display'])){
  	 //awal shi bade shouf eza hayda houwe matiere abl , eza la2 bade e5la2 matiere bzida 3al year,bade emro2 3a kl el matieres bi alb hyde el sene w shouf eza cours fi mtl li na2yto bl select
  	echo '<script>
 		 		var a = document.getElementById("cours");
 		 		a.options['.$_POST['cours'].'].selected = true;
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
  	$s=0;$i=0;$f=0;
  	$y=date("Y");
  	while($s==0){
  		
  			$matieree=$root->getElementsByTagName('matieres')->item(0);
  			$matieres=$matieree->getElementsByTagName('matiere');
  			//bade el string
  			foreach($matieres as $matiere){
  				//be5od esm el cours mino
  				$cours=$matiere->getElementsByTagName('cours')->item(0)->textContent;
  				$coursSelected=$_POST['cours'];
  				$c=$coursarr[$coursSelected];
  				if($cours==$c){
  					$f++;
  					//fi she8l bade eftol 3l students w 3l etudiant bi alb el matiere
  					$all=$root->getElementsByTagName('students');
  					$students=$all->item(0)->getElementsByTagName('student');
  					echo '<table cellspacing="5" cellpadding="4">';
  					echo'<thead><th>Name </th><th>ID </th><th>Add </th></thead>';
  					foreach($students as $student){
  						$idEtudiant=$student->getAttribute('id');
  						$nometu=$student->textContent;
  						$val=$student->getAttribute('val');
  						$j=0;
  						$all=$matiere->getElementsByTagName('AllEtudiants')->item(0);
  						$etudiants=$all->getElementsByTagName('etudiants');
  						foreach($etudiants as $etudiant){
  							$idett=$etudiant->getAttribute('id');
  							if($idEtudiant==$idett){
  								$j++;
  								break;
  							}
  						}
  						if($j==0){ //hayda el etudiant msh mnzed abl 3al medde
  							echo '<tr>';
  							echo'<td>'.$nometu.'</td><td>'.$idEtudiant.'</td><td>Add <input type="checkbox" name="students[]" value="'.$val.'" /></td>';
  							echo '</tr>';
  						}
  					}
  					echo '</table>';
  					echo '<p><input type="submit" name="add" value="Add Students"/></p>';
  					break;
  				}
  			}
  			if($f==0){
  				//ye3ne hayde el cours msh mnzed 3le abl students fa bde e5la2o ka matiere jdide
  				$mat=$xml->createElement("matiere");
  				$coursPostee=$_POST['cours'];
  				$new=$coursarr[$coursPostee];
  				$corse=$xml->createElement("cours",$new);
  				$all=$xml->createElement('AllEtudiants');
  				$mat->appendChild($corse);
  				$mat->appendChild($all);
  				$root->getElementsByTagName('matieres')->item(0)->appendChild($mat);
  				$xml->save($xmlFile);
  				$p=0;
  				//bade bi alba cours w bade etudiants
  				//bade o3rod kl el students min hyde el sene 
  				echo'<table>';
  				$all=$root->getElementsByTagName('students');
  				$students=$all->item(0)->getElementsByTagName('student');
  				foreach($students as $student){
  					$nomEt=$student->textContent;
  					$id=$student->getAttribute('id');
  					$val=$student->getAttribute('val');
  					echo '<tr>';
  					echo'<td>'.$nomEt.'</td><td>'.$id.'</td><td>Add <input type="checkbox" name="students[]" value="'.$val.'" /></td>';
  					echo '</tr>';
  					$p++;
  				}
  				echo'</table>';
  				if($p!=0)
  					echo'<p><input type="submit" name="add" value="Add Students"/></p>';
  			}
  			
  			
  			$s=1;
  			
  		
  	}
  	
  }
  if(isset($_POST['add'])){
  	$xml=new DOMDocument();
  	$xml->load($xmlFile);
  	$root=$xml->documentElement;
  	
  	$s=0;$i=0;
  	$y=date("Y");
  	//lal te3dil
  	while($s==0){
  		
  			
  			$matieree=$root->getElementsByTagName('matieres')->item(0);
  			
  			$matieres=$matieree->getElementsByTagName('matiere');
  	
  			foreach($matieres as $matiere){
  				$cours=$matiere->getElementsByTagName('cours')->item(0)->textContent;
  				$coursSelected=$_POST['cours'];
  				$c=$coursarr[$coursSelected];
  				if($cours==$c){
  				
  					$students=$root->getElementsByTagName('students')->item(0);
  					$studentt=$students->getElementsByTagName('student');
  					$nbEt=$studentt->length;
  					for($row=0;$row<$nbEt;$row++){
  						$nometu=$studentt->item($row)->textContent;
  						$idd=$studentt->item($row)->getAttribute('id');
  						$val=$studentt->item($row)->getAttribute('val');//valeur bl xml momken 1 la 17 msln
  						
  						if(IsChecked('students',$val)) {   // hayda makbous ye3ne present ye3ne lezm 3abe attribut absent=0
  							$all=$matiere->getElementsByTagName('AllEtudiants')->item(0);
  							$etudiant = $xml->createElement("etudiants",$nometu);
  							$id=$xml->createAttribute('id');
  							$id->value= $idd;
  							$abs = $xml->createAttribute('nbAbs');
  							$abs->value='0';
  							$ret = $xml->createAttribute('nbRet');
  							$ret->value='0';
  							$vall=$xml->createAttribute('val');
  							$vall->value=$val;
  							$etudiant->appendChild($id);
  							$etudiant->appendChild($abs);
  							$etudiant->appendChild($ret);
  							$etudiant->appendChild($vall);
  							$all->appendChild($etudiant);
  							
  						} // eza houwe kabstelo add
  							
  					} // for taba3 el  students taba3 hayde el sene
  					$s=1;
  					break;
  				}// if el cours mtl li na2yne
  					
  					
  			} // niheyet el foreach el kbire taba3 el matieres
  	
  	}
  	
  	
  
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