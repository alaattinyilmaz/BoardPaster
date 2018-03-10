<?php

$db = mysqli_connect('localhost', 'root', '', 'boardpaster');

if($db->connect_errno > 0)
{
    die('Unable to connect to database [' . $db->connect_error . ']');
}

$sql_land = "SELECT L.lName, L.lID FROM land L";
				
/*$landresult = mysqli_query($db, $sql_land);*/


?>






<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BoardPaster!</title>
<style type="text/css">
<!--
.style1 {
	font-size: 18pt;
	font-weight: bold;
}
.style2 {color: #333333}
.buttonstyle {
 	background-color: #666666; /* Green */
	border: none;
    color: white;  
	padding: 4px 10px;
	text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
	}

.buttonstyle:hover{
    color: #ffffff;
   background-color: #2a208d;
}
	
.style3 {
	font-size: 18px;
	font-weight: bold;
	color: #0066CC;
}

.textarea {
  border: 2px solid #2a208d;
  background: #efefef;
  color: #black;
  padding: 33;
  width: 800px;
  height: 500px;
}


.pasMode {
    display: none;
}

body {
	background-color: #FEFEFE;
}
a:link {
	color: #9B9B9B;
}
a:visited {
	color: #9B9B9B;
}
a:hover {
	color: #333333;
}
a:active {
	color: #333333;
}
</style>
</head>

<body>




<div align="center">
  <p>&nbsp;</p>
  	<table width="875" border="1"  bordercolor="#000066" bgcolor="#FFFFFF">
    <tr>
      <td><p align="center" class="style1">BoardPaster</p>
	
		<p align="center" class="style2">
	
		
        <label>

		  <?php



if(isset($_POST['create']))

{

$pathName = $_POST['name'];
$text = "";
$date = new DateTime();
$date = $date->getTimestamp();

 
	
	$checkquery = "SELECT * FROM content WHERE pathname = '$pathName'";
	$checkresult = mysqli_query($db, $checkquery);
	
	$realname = $pathName;
	
	for ($i = 2; mysqli_num_rows($checkresult)>=1; $i++)
	{
			$pathName = $realname.$i;
			$checkquery = "SELECT * FROM content WHERE pathname = '$pathName'";
			$checkresult = mysqli_query($db, $checkquery);
	}

$changedname = $pathName;

$personquery = "INSERT INTO content (pathName, text, date) VALUES ('$pathName', '$text', '$date');";

$presult = mysqli_query($db, $personquery);

			if($presult) 
			{
				echo "The page has been saved! <br>Paste in any text you want into the textarea and click save. <br>";
				
				//echo  '<p align="center" class="style3">' . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '?name='.$pathName.''; 
			}
			else 
			{
				echo "Could not be created. Try again.";
			}
			
}

else if (isset($_GET['name']) && isset($_POST['saved']))
{
		$newtext = $_POST['text_area'];
		$pathName = $_GET['name'];
				
		$date = new DateTime();
		$date = $date->getTimestamp();

		$updatecontent = "UPDATE content SET text = '$newtext', date = '$date' WHERE pathname = '$pathName'";
		$updateresult = mysqli_query($db, $updatecontent);
		
		if($updateresult) 
			{
			
			$takecid = "SELECT * FROM content WHERE pathname = '$pathName'";
			$cidresult = mysqli_query($db, $takecid);
			
			if(mysqli_num_rows($cidresult)>=1)
			{	
				$row = mysqli_fetch_assoc($cidresult);
				$cid = $row['id'];
				$logque = "INSERT INTO logs (cid, text, date) VALUES ('$cid', '$newtext', '$date');";
				$logqueresult = mysqli_query($db, $logque);
			}
				echo "Your modifications has been done!<br>";
				
				//echo  '<p align="center" class="style3">' . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '?name='.$pathName.''; 
			}
			else 
			{
				echo "Could not be created. Please Try again.";
			}
			
			
			
		
		
}

if (isset($_POST['name']) || isset($_GET['name']))
{

if (isset($_POST['name']))
{
	$pathName = $_POST['name'];
}
else
{
	$pathName = $_GET['name'];
}

if (isset($changedname))
{
$pathName = $changedname;
}

	$checkquery = "SELECT * FROM content WHERE pathname = '$pathName'";
	$checkresult = mysqli_query($db, $checkquery);
	
	$realname = $pathName;
	
	if(mysqli_num_rows($checkresult)>=1)
	{	
		$row = mysqli_fetch_assoc($checkresult);
		$textarea = $row['text'];
		
		$ts = $row['date']+10800;
		$cid =  $row['id'];
		$date = new DateTime("@$ts");
		$formatteddate = $date->format('d.m.Y - H:i:s');

		$date = $date->getTimestamp();
		
				
		if (isset($_POST['name']))
		{
			echo  '<p align="center" class="style3">' . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ."?name=".$pathName.'</p>'; 	
		}
		else
		{
			echo  '<p align="center" class="style3">' . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'].'</p>'; 	
		}
		
		echo "<div align='right'>last saved: <b>". $formatteddate.'</b></div>';
		
		if (isset($_GET['logid']) )
		{
		$logid = $_GET['logid'];
		
		$logshow = "SELECT * FROM logs WHERE cid = '$cid' and logid = '$logid'";
		$logres = mysqli_query($db, $logshow);
		if ($logres)
		{
			$logrow = mysqli_fetch_assoc($logres);
			$textarea = $logrow['text'];	
		}
			
		}
		
		echo ' 
		<form id="form1" name="form1" method="post" action="board.php?name='.$pathName.'">
	      <div align="center">
		  
		  <div id="passiveBtn" style="display:block">
		<input name="editmode" type="button" class="buttonstyle" onclick="showFunc()" value="Activate Edit Mode" size="20" />
		<input name="save" type="submit" class="buttonstyle" value="SAVE" size="20" />
		  </div>
		
		  <div id="activeBtn" style="display:none">
		<input name="linkmode" type="button" class="buttonstyle" onclick="showFunc()" value="Activate Link Mode" size="20" />
		<input name="save" type="submit" class="buttonstyle" value="SAVE" size="20" />
		<input name="saved" type="hidden"/>
		</div>
	        
	        <br />	  

		<div id="passiveMode" style="display:block">
	      <textarea name="text_area" class="textarea">'.$textarea.'</textarea>
		</div>
		
		<div id="activeMode" style="display:none">
	      <table width="803" border="1">
            <tr>
              <td bordercolor="#000066" bgcolor="#FFF4F4">'.$textarea.'</td>
			  </div></table>
			  
			 </div>
         
		';
		
			
		$logquery = "SELECT * FROM logs WHERE cid = '$cid' ORDER BY date DESC";
		$logresult = mysqli_query($db, $logquery);
	
	if($logresult)
	{
	echo "Change History: <br>";
		while($logrow = mysqli_fetch_assoc($logresult)) {
			$strdate = $logrow['date']+10800;
			$cid =  $row['id'];
			$lid =  $logrow['logid'];
			$date = new DateTime("@$strdate");
			$formatteddate = $date->format('d.m.Y - H:i:s');
			echo '<a href="board.php?name='.$pathName.'&logid='.$lid.'">'.$formatteddate.'</a><br>';
		}
	}
	
		
	}

	else {
	echo "There is not a such a user.";
	}
	
	
}

?>	
		  
		

<script>
function showFunc() {
    var btnpas = document.getElementById("passiveBtn");
    var btnact = document.getElementById("activeBtn");
    var passivemode = document.getElementById("passiveMode");
    var activemode = document.getElementById("activeMode");
	
    if (btnpas.style.display === "block") 
	{
        passivemode.style.display = "none";
        btnpas.style.display = "none";
        btnact.style.display = "block";
        activemode.style.display = "block";
    } 
	
	else if (btnact.style.display === "block"){
        activemode.style.display = "none";
        btnact.style.display = "none";
        btnpas.style.display = "block";
        passivemode.style.display = "block";
    }
}
</script>

  <p align="center" class="style2">created by <a href="http://github.com/alaattinyilmaz" target="_blank">emiralaattinyilmaz</a> 2018 | <a href="index.php">Main Page</a></p></td></tr>
          </table></div>
	      </div>
	    </label>
	    </form>

    </tr>
    
  </table>
</div>
</body>
</html>
