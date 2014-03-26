<?php
	require_once("./include/membersite_config.php");
	if(!$fgmembersite->CheckLogin()){
		$fgmembersite->RedirectToURL("index.php");
		exit;
	}
	
	if(isset($_POST['submitted'])){
		/*if($fgmembersite->RegisterUser()){
			$fgmembersite->RedirectToURL("thank-you.html");
		}*/
	}
	
	$nameOfPerson = $fgmembersite->UserEmail();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<link rel="shortcut icon" href="images/logo.png">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>VisKo</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
		<style type="text/css">
		table.bottomBorder { border-collapse:collapse; }
		table.bottomBorder td, table.bottomBorder th { border-bottom:1px dotted black;padding:5px; }
		</style>
		<!--[if IE 6]>
		<link rel="stylesheet" type="text/css" href="css/iecss.css" />
		<![endif]-->
	</head>
	<body>
	<div id="main_container">
		<div class="header">
			<div id="logo">
				<a href="index.php"><img src="images/logo.png" alt="" border="0" /></a>
				<font size="10" color="white"><b> VisKo</b></font>
			</div>			
			<div class="welcome">
			<br><br><br>
			<font size="2" color="white"><b>Welcome back <?PHP echo $nameOfPerson ?>!&nbsp;&nbsp;</b></font>
			<form id="form1" action="logout.php" method="get">
				<input id="logout" type="submit" value="Logout">
			</form>
			</div>
		</div>

		<div id="middle_box">
			<div class="middle_box_content">
					<html lang="en">
						<body>
						<font size="5" color="black">Set Query Parameters</font>
						<br><br>
						<!--here starts-->
						<head> 
						<link rel="stylesheet" href="css/styleDrop.css">
						<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
						<script type="text/javascript">
							$(document).ready(function()
							{
								$.getJSON("json/dropdownlists.txt",function(obj)
							   {
									 $.each(obj.viewerSets,function(key,value)
									 {
										var option = $('<option />').val(value.viewerSetName).text(value.viewerSetName);
										$("#ddViewerSet").append(option);
									 });
									 
									 $.each(obj.inputFormats,function(key,value)
									 {
										var option = $('<option />').val(value.inputFormatName).text(value.inputFormatName);
										$("#ddInputDataFormat").append(option);
									 });
									 
									 $.each(obj.inputDataTypes,function(key,value)
									 {
										var option = $('<option />').val(value.inputDataTypeName).text(value.inputDataTypeName);
										$("#ddInputDataType").append(option);
									 });
							
								});
							});
						</script>
						</head> 
						

						<!--ends here-->
						<table style="width:100%">
						<tr>
							<td>
								<div style="width:300px;height:150px;overflow:hidden">
									<img src="images/tmp.jpg"/>
								</div>
								<font size="1" color="black">Thumbnail from previous page!</font>
							</td>
							<td>
								<font size="2" color="black">&lt;&lt;Text Corresponding to Visualization Abstraction Description from previous page&gt;&gt;</font>
							</td>
						</tr>
						</table>
						
						<br><br>
						<hr>
						
						<table style="width:100%">
						<tr>
							<td style = "height:50px">
								<select id="ddViewerSet" style="width:400px">
								<option value="" disabled selected style='display:none;'>Viewer Set</option>
								</select>
							</td>
							<td style="width:20px"></td>
							<td>
								<font size="2" color="black"><p align="justify"><b>Viewer Set: </b>refers to programs that present the abstraction onto the screen, such as visualization specific software like ParaView or more generic applications like a Web browser that can display images in standard formats.</p></font>
							</td>
						</tr>
						<tr>
							<td style = "height:50px">
								<select id="ddInputDataFormat" style="width:100%">
								<option value="" disabled selected style='display:none;'>Input Data Format</option>
								</select>
							</td>
							<td></td>
							<td>
								<font size="2" color="black"><p align="justify"><b>Input Data Format: </b>refers to the file encoding of your input dataset.</p></font>
							</td>
						</tr>
						<tr>
							<td style = "height:50px">
								<select id="ddInputDataType" style="width:100%">
								<option value="" disabled selected style='display:none;'>Input Data Type</option>
								</select>
							</td>
							<td></td>
							<td>
								<font size="2" color="black"><p align="justify"><b>Input Data Type: </b>refers to the data structure represented by your input data format.</p></font>
							</td>
						</tr>
						<tr>
							<td style = "height:50px">
								<form>
								Input Data URL: <input type="text" name="inputDataURL" style="width:100%"><br>
								</form> 
							</td>
							<td></td>
							<td>
								<font size="2" color="black"><p align="justify"><b>Input Data URL: </b>refers to the location of your input data which is to be visualized.</p></font>
							</td>
						</tr>
						<tr>
							<td><center><button type="button" style= "background-color:#d9d9d9; width: 75px">Submit</button></td>
						</tr>
						</table>
						</body>
					</html>
			</div>
		</div> 
		<br><br><br>
		<footer>&copy; Developmental Technologies Team. All Rights Reserved</footer>
	</div>

	
	
<div id="nav_table" style="position: fixed; left:0px; right: 31px; top: 120px; bottom: auto; display: block">
    <ul id="sidebar-nav" class="Menu">
<body>
	<br>
	<table class="bottomBorder">
		<tr>
		  <td><center></td>
		</tr>
		<tr>
		  <td><center><br><a href="./RegularUserHome.php" style="text-decoration:none;"><font size="5" color="black">Home</font></a><br><br></td>
		</tr>                      
		<tr>                       
		  <td><center><br><a href="./SpecifyCriteriaRegularUser.php" style="text-decoration:none;"><font size="5" color="black">Search <br> History</font></a><br><br></td>
		</tr>                      
		<tr>                       
		  <td><center><br><a href="./ChooseQueryStyle.php" style="text-decoration:none;"><font size="5" color="black">Visualize</font></a><br><br></td>
		</tr>
		<tr>
		  <td><center><br><a href="./SelectOperation.php" style="text-decoration:none;"><font size="5" color="black">Manage <br> Services</font></a><br><br></td>
		</tr>
		<tr>
		  <td><center><br><a href="./ConfigureAccountRegularUser.php" style="text-decoration:none;"><font size="5" color="black">Configure <br> Account</font></a><br><br></td>
		</tr>
	</table>
    </ul>
</div>
</body>
</html>