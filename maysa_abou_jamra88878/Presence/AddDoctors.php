

<html>
<head>
<style>
  body{
    background: url(images/gre.jpg);
    -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  font-family: 'Roboto', sans-serif;
  }</style>
</head>
<body>
<form name="form1" action="" method="post">
<table>
  <tr><td> <label>Name of the doctor: </label></td><td><input type="text" name="doctor"/></td>
 
   <tr><td><label>His password : </label></td><td><input type="text" name="pass"/></td>
 
 </table>
 <p align="center"><input type="submit" name="save" value="Add Doctor"></p>
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
   		//$nom=$years->item($i)->getAttribute('nomY');
   	  //bade zid esmo w id 3ala student , id houwe atribut bi albo
   	 // if($nom==$y){
   	$doctor=$_POST['doctor'];
   	$pass=$_POST['pass'];
   	$docteur = $xml->createElement("docteur");
   	$nom = $xml->createElement("nom",$doctor);
   	$pass = $xml->createElement("password",$pass);
   	$docteur->appendChild($nom);$docteur->appendChild($pass);
   	$root->getElementsByTagName('docteurs')->item(0)->appendChild($docteur);
   	$s=1;
  
   	}
   	$xml->save($xmlFile);
   }
 ?>
 </body>
 </html>
