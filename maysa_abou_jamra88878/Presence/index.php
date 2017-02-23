<html>
<head><title></title>
<link rel="stylesheet" href="./css/index.css" type="text/css" media="screen">
<style>
   @import url(http://fonts.googleapis.com/css?family=Roboto:400,100);
  
body {
  background: url(images/gre.jpg) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  font-family: 'Roboto', sans-serif;
}


</style></head>
<body>

  <div class="login-card">
    <h1>Log-in</h1><br>
  <form name="form1" action="" method="post">
    <input type="text" name="user" placeholder="Username">
    <input type="password" name="pass" placeholder="Password">
    <input type="submit" name="login" class="login login-submit" value="login">
  </form>

  
</div>

<?php

  
  $dom=new DOMDocument();
 $m=date("n");$y=date("Y");
$f=$y+1;
$d=$y-1;
if($m>=10&&$m<=12)
	$file=$y."_".$f;
else if($m>=1&&$m<=7)
	$file=$d."_".$y;


$xmlFile=$file.".xml";
$xmlFile="xml/".$xmlFile;
$dom->load($xmlFile);
  if($dom->schemaValidate('presence.xsd')){
  
  if(isset($_POST['login'])){
   
    
  	$name=$_POST['user'];
  	$pass=$_POST['pass'];
  	$root=$dom->getElementsByTagName('master')->item(0);
  	//$years=$root->getElementsByTagName('year');
  	$i=0;
  	$y=date("Y");
  	while(1){
  		
  			$docteurss=$root->getElementsByTagName('docteurs');
  			$docteurs=$docteurss->item(0)->getElementsByTagName('docteur');
  			for($i=0;$i<$docteurs->length;$i++){
  				
  				$docteur=$docteurs[$i]->childNodes;
  				$nom=$docteur[0]->nodeValue;
  				$password=$docteur[1]->nodeValue;
  				if($name==$nom && $password==$pass){
  					setcookie('name',$name);
                  
  					header("Location:absence.php");
  				}
  				
  			}
  			break;
  		
  	}
  	
  	
  }
  }
  
  
  
?>

  

</body>
</html>