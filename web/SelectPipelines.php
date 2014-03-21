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
						<head>
							<meta charset="utf-8">
							<title>jQuery UI Accordion - Default functionality</title>
							<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
							<script src="//code.jquery.com/jquery-1.9.1.js"></script>
							<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
							<link rel="stylesheet" href="/resources/demos/style.css">
							<script>
								$(function() {
								$( "#accordion" ).accordion();
								});
							</script>
						</head>
						<body>
						<table style="width:100%">	
						<tr>
							<td><h3>Select Pipelines</h3></td>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td><h3>Pipeline Execution Queue</h3></td>
						</tr>
						<tr>
						<td>
							<div id="accordion">
								<h3>Pipelines: &lt;&lt;GMT&gt;&gt;</h3>
								<div>
									<table border="1" color="black" style="width:100%">
									<tr>
										<td bgcolor="#C0C0C0">
											<p><b><center>ID</b></p>
										</td>
										<td bgcolor="#C0C0C0">
											<p><b><center>Abstraction</b></p>
										</td>
										<td bgcolor="#C0C0C0">
											<p><b><center>Format</b></p>
										</td>
									</tr>
									<tr>
										<td>
											<p><center>12</p>
										</td>
										<td>
											<p><center>Isosurfaces</p>
										</td>
										<td>
											<p><center>JPEG</p>
										</td>
										<td>
											<center><button type="button">Edit</button>
										</td>
										<td>
											<center><button type="button">Run</button>
										</td>
									</tr>
									<tr>
										<td>
											<p><center>13</p>
										</td>
										<td>
											<p><center>Countour Map</p>
										</td>
										<td>
											<p><center>JPEG</p>
										</td>
										<td>
											<center><button type="button">Edit</button>
										</td>
										<td>
											<center><button type="button">Run</button>
										</td>
									</tr>
									<tr>
										<td>
											<p><center>14</p>
										</td>
										<td>
											<p><center>Contour Map</p>
										</td>
										<td>
											<p><center>PNG</p>
										</td>
										<td>
											<center><button type="button">Edit</button>
										</td>
										<td>
											<center><button type="button">Run</button>
										</td>
									
									</tr>
									</table>
								</div>
								<h3>Pipelines: &lt;&lt;VTK&gt;&gt;</h3>
								<div>
									<table border="1" color="black" style="width:100%">
									<tr>
										<td bgcolor="#C0C0C0">
											<p><b><center>ID</b></p>
										</td>
										<td bgcolor="#C0C0C0">
											<p><b><center>Abstraction</b></p>
										</td>
										<td bgcolor="#C0C0C0">
											<p><b><center>Format</b></p>
										</td>
									</tr>
									<tr>
										<td>
											<p><center>12</p>
										</td>
										<td>
											<p><center>Isosurfaces</p>
										</td>
										<td>
											<p><center>JPEG</p>
										</td>
										<td>
											<center><button type="button">Edit</button>
										</td>
										<td>
											<center><button type="button">Run</button>
										</td>
									</tr>
									<tr>
										<td>
											<p><center>13</p>
										</td>
										<td>
											<p><center>Countour Map</p>
										</td>
										<td>
											<p><center>JPEG</p>
										</td>
										<td>
											<center><button type="button">Edit</button>
										</td>
										<td>
											<center><button type="button">Run</button>
										</td>
									</tr>
									<tr>
										<td>
											<p><center>14</p>
										</td>
										<td>
											<p><center>Contour Map</p>
										</td>
										<td>
											<p><center>PNG</p>
										</td>
										<td>
											<center><button type="button">Edit</button>
										</td>
										<td>
											<center><button type="button">Run</button>
										</td>
									
									</tr>
									</table>
								</div>
								<h3>Pipelines: &lt;&lt;Paraview&gt;&gt;</h3>
								<div>
									<table border="1" color="black" style="width:100%">
									<tr>
										<td bgcolor="#C0C0C0">
											<p><b><center>ID</b></p>
										</td>
										<td bgcolor="#C0C0C0">
											<p><b><center>Abstraction</b></p>
										</td>
										<td bgcolor="#C0C0C0">
											<p><b><center>Format</b></p>
										</td>
									</tr>
									<tr>
										<td>
											<p><center>12</p>
										</td>
										<td>
											<p><center>Isosurfaces</p>
										</td>
										<td>
											<p><center>JPEG</p>
										</td>
										<td>
											<center><button type="button">Edit</button>
										</td>
										<td>
											<center><button type="button">Run</button>
										</td>
									</tr>
									<tr>
										<td>
											<p><center>13</p>
										</td>
										<td>
											<p><center>Countour Map</p>
										</td>
										<td>
											<p><center>JPEG</p>
										</td>
										<td>
											<center><button type="button">Edit</button>
										</td>
										<td>
											<center><button type="button">Run</button>
										</td>
									</tr>
									<tr>
										<td>
											<p><center>14</p>
										</td>
										<td>
											<p><center>Contour Map</p>
										</td>
										<td>
											<p><center>PNG</p>
										</td>
										<td>
											<center><button type="button">Edit</button>
										</td>
										<td>
											<center><button type="button">Run</button>
										</td>
									
									</tr>
									</table>
								</div>
							</div>
						</td>
						<td></td>
						<td>
							<table border="1" color="black" style="width:100%">
							<tr>
								<td bgcolor="#C0C0C0">
									<p><b><center>Pipeline ID</b></p>
								</td>
								<td bgcolor="#C0C0C0">
									<p><b><center>Result</b></p>
								</td>
								<td>
								</td>
							</tr>
							<tr>
								<td>
									<p><center>12</p>
								</td>
								<td>
									<center><img src="http://openvisko.org/visualization-examples/gravity-3d-isosurfacesrendering-vtk.png" width="150"/>
								</td>
								<td>
									<center><button type="button">Remove</button>
								</td>
							</tr>
							<tr>
								<td>
									<p><center>13</p>
								</td>
								<td>
									<p><center>Image</p>
								</td>
								<td>
									<center><button type="button">Remove</button>
								</td>
							</tr>
							<tr>
								<td>
									<p><center>14</p>
								</td>
								<td>
									<p><center>Image</p>
								</td>
								<td>
									<center><button type="button">Remove</button>
								</td>
							</tr>
							</table>
						</td>
						</tr>
						</table>
						</body>
					</html>
			</div>
		</div> 
		<br><br><br>
		<footer>&copy; Developmental Technologies Team. All Rights Reserved</footer>
	</div>
	</body>
	
	
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
		  <td><center><br><a href="./SpecifyCriteria.php" style="text-decoration:none;"><font size="5" color="black">Search <br> History</font></a><br><br></td>
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