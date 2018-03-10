<?php

$db = mysqli_connect('localhost', 'root', '', 'wog_db');

if($db->connect_errno > 0)
{
    die('Unable to connect to database [' . $db->connect_error . ']');
}

$sql_land = "SELECT L.lName, L.lID FROM land L";
				
$landresult = mysqli_query($db, $sql_land);


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
	hover-color: #000000;
    border: none;
    color: white;  
	padding: 3px 10px;
	border-radius: 10px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
	}
-->
</style>
</head>

<body>
<div align="center">
  <p>&nbsp;</p>
  <table width="875" border="1"  bordercolor="#666666" bgcolor="#FFFFFF">
    <tr>
      <td><p align="center" class="style1">BoardPaster</p>
        <p align="center" class="style2">Welcome to the&nbsp;<strong>BoardPaster Clipboard</strong>. </p>
      <p align="center" class="style2">Here you can very simply create your own page, paste your text, save it and open it anywhere!      </p>
      <form	action="board.php" method="post">
        <div align="center"><span class="style2">Make Your Own : </span>
            <input type="text" name="name" size="20">
            <input type="hidden" name="create" size="20" value="1">
			  <input name="Submit" type="submit" class="buttonstyle" value="Create" >
        </div>
      </form>
	  </p>
	  <div align="center">
	    <p>&nbsp;</p>
	    <p>created by emiralaattinyilmaz 2018<br />
          </p>
	    </div></td>
    </tr>
  </table>
  <p class="style1">&nbsp;</p>
  <p>&nbsp; </p>
</div>
</body>
</html>
