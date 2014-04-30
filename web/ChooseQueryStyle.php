<?php
	require_once("./include/membersite_config.php");

	//init(x,"","","","","");
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
		<script>
// 			function getQuery(){
// 				var x = document.getElementById("QueryArea").value;
// 				//alert(x);
// 				
// 				$.post("http://localhost:8888/web/SelectPipelines.php",{x: x},"");
// 				);
// 				
// 			}
		</script>
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
				<div align = "center">
					Option 1: Submit Visualization Query
					<br><br>
					<div id = "test">
					<form id="syntaxCheck" action = "/" name = "syntaxChecker">
						<div>
							<textarea id="QueryArea" style="width:100%; height: 100px;"></textarea>
							<input type="button" value="submit" onclick="checkSyntax()" />
							<br />
							<p id="msg"></p>
						</div>
					</form>
					</div>
					<script>
						var errorNum = 0;
						
						function checkSyntax() {
							var c1 = document.getElementById('QueryArea').value;
							var queryArr = c1.split("\n"); 
							var d1 = document.getElementById('msg');
							var keywords = new Array("PREFIX","VISUALIZE", "VISUALIZE NODESET", "AS", "IN", "WHERE", "FORMAT", "AND");
							
							
							//traverse the queryArr array
							for(var i = 0;i<queryArr.length;i++)
					
							{
								//split line by space
								
								var lineArr = queryArr[i].trim().split(" ");
								var temp = lineArr[0].toUpperCase();
							

								//check if keyword is correct
								if(keywords.indexOf(temp)== -1)
								{
									error();
									errorNum ++;
									
								}
								
								else{			
									
									
									switch(temp)
									{
										//PREFIX
										case "PREFIX":
										
											prefixCheck(lineArr[1]);
										break;
											
										case "VISUALIZE":
										case "VISUALIZE NODESET":
											visualizeCheck(lineArr[1]);
										break;

										//AS
										case "AS":
											asCheck(lineArr[1]);
										break;
									
										case "FORMAT": 
											//formatCheck(lineArr[1]);
											
										break;
										
										case "AND":
											andCheck(lineArr[1]);
										break	
									}
									
								}	
							}
							
							countError();
						}
							
					
								
						function prefixCheck(word){
							var d2 = document.getElementById('msg');
							var prefixType = new Array ('views','formats','types','visko','params');
							if (prefixType.indexOf(word) == -1)
								{
									error();
								}
								
						}
						
						function visualizeCheck(uri){
							if (uri == null)
							{
								error();
							}
							
						}
						
						function asCheck(abs){
							if (abs === null)
							{
								error();
							}
							
						}
						
						function andCheck(){
						
						}
						
						function error(){
							var d2 = document.getElementById('msg');
							var error = "Syntax Error!";
							var color = error.fontcolor("red");
							d2.innerHTML = color;
							document.getElementById("test").reset();
							errorNum ++;
						}
						
						function countError()
						{
							var d2 = document.getElementById('msg');
							
						    if (errorNum == 0)
							{
							document.getElementById("syntaxCheck").action ="./SelectPipelines.php";
							 document.getElementById("syntaxCheck").submit();
							 document.getElementById("syntaxCheck").action ="./SelectPipelines.php";
							}		
						}
						
					</script>
					
					<!--<div style = "float:right;">
							<a href="./SelectPipelines.php">
								<button type="button" onclick="getQuery()">Submit</button>
							</a>
					</div>-->
				</div>	
				<br><br><br><br><br>
				<div align = "center">
					Option 2: 
					<br><br>
					<html lang="en">
						<head>
							<meta charset="utf-8">
							<title>jQuery UI Accordion - Default functionality</title>
							<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
							<script src="//code.jquery.com/jquery-1.9.1.js"></script>
							<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
							<link rel="stylesheet" href="/resources/demos/style.css">
							<style>
								#accordion-resizer {
								padding: 10px;
								width: 350px;
								height: 200px;
								}
								</style>
								<script>
								$(function() {
								$( "#accordion" ).accordion({
								heightStyle: "fill"
								});
								});
								$(function() {
								$( "#accordion-resizer" ).resizable({
								minHeight: 100,
								minWidth: 200,
								resize: function() {
								$( "#accordion" ).accordion( "refresh" );
								}
								});
								});
								</script>
						</head>
						<body>
							<div id="accordion">
								<h3>1D Abstractions</h3>
								<div>
									<p>
									<table>
									<tr>
									<td>
										<font size="3" color="black"><b>Timeline</b></font>
										<?php $src = "http://www.stanford.edu/group/spatialhistory/media/images/publication/MSantosAPeers_graphs-05.svg"; ?>
										<a href='./SetQueryParameters.php?type=1D_Timeline&image=<?php echo $src ?>&desc=Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.'><img src="http://www.stanford.edu/group/spatialhistory/media/images/publication/MSantosAPeers_graphs-05.svg" width="250" height="250">	

									</td>
									<td>
										Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
									</td>
									</tr>
									</table>
									</p>
								</div>
								<h3>2D Abstractions</h3>
								<div>
									<p>
									<table>
									<tr>
									<td>
										<font size="3" color="black"><b>Contour Map</b></font><br>
										<?php $src = "https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"; ?>
										<a href='./SetQueryParameters.php?image=<?php echo $src ?>&desc=Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.'><img src="https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"  width="250" height="250"></a>
									</td>
									<td>
										Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
									</td>
									</tr>
									<tr>
									<td>
										<font size="3" color="black"><b>Force Graph</b></font><br>
										<?php $src = "https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"; ?>
										<a href='./SetQueryParameters.php?image=<?php echo $src ?>&desc=Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.'><img src="https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"  width="250" height="250"></a>
									</td>
									<td>
										Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
									</td>
									</tr>
									<tr>
									<td>
										<font size="3" color="black"><b>Point Map</b></font><br>
										<?php $src = "https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"; ?>
										<a href='./SetQueryParameters.php?image=<?php echo $src ?>&desc=Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.'><img src="https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"  width="250" height="250"></a>
									</td>
									<td>
										Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
									</td>
									</tr>
									<tr>
									<td>
										<font size="3" color="black"><b>Raster Map</b></font><br>
										<?php $src = "https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"; ?>
										<a href='./SetQueryParameters.php?image=<?php echo $src ?>&desc=Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.'><img src="https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"  width="250" height="250"></a>
									</td>
									<td>
										Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
									</td>
									</tr>
									<tr>
									<td>
										<font size="3" color="black"><b>Species Distribution Map</b></font><br>
										<?php $src = "https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"; ?>
										<a href='./SetQueryParameters.php?image=<?php echo $src ?>&desc=Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.'><img src="https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"  width="250" height="250"></a>
									</td>
									<td>
										Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
									</td>
									</tr>
									<tr>
									<td>
										<font size="3" color="black"><b>Spherized Raster</b></font><br>
										<?php $src = "https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"; ?>
										<a href='./SetQueryParameters.php?image=<?php echo $src ?>&desc=Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.'><img src="https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"  width="250" height="250"></a>
									</td>
									<td>
										Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
									</td>
									</tr>
									<tr>
									<td>
										<font size="3" color="black"><b>Time Series Plot</b></font><br>
										<?php $src = "https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"; ?>
										<a href='./SetQueryParameters.php?image=<?php echo $src ?>&desc=Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.'><img src="https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"  width="250" height="250"></a>
									</td>
									<td>
										Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
									</td>
									</tr>
									<tr>
									<td>
										<font size="3" color="black"><b>VisKo Data Transformations Force Graph </b></font><br>
										<?php $src = "https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"; ?>
										<a href='./SetQueryParameters.php?image=<?php echo $src ?>&desc=Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.'><img src="https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"  width="250" height="250"></a>
									</td>
									<td>
										Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
									</td>
									</tr>
									<tr>
									<td>
										<font size="3" color="black"><b>VisKo Instances Bar Chart</b></font><br>
										<?php $src = "https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"; ?>
										<a href='./SetQueryParameters.php?image=<?php echo $src ?>&desc=Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.'><img src="https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"  width="250" height="250"></a>
									</td>
									<td>
										Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
									</td>
									</tr>
									<tr>
									<td>
										<font size="3" color="black"><b>VisKo Operator Paths Force Graph</b></font><br>
										<?php $src = "https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"; ?>
										<a href='./SetQueryParameters.php?image=<?php echo $src ?>&desc=Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.'><img src="https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"  width="250" height="250"></a>
									</td>
									<td>
										Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
									</td>
									</tr>
									</table>
									</p>
								</div>
								<h3>3D Abstractions</h3>
								<div>
									<p>
									<table>
										<tr>
										<td>
											<font size="3" color="black"><b>Bar Chart</b></font><br>
											<?php $src = "https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"; ?>
											<a href='./SetQueryParameters.php?image=<?php echo $src ?>&desc=Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.'><img src="https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"  width="250" height="250"></a>
										</td>
										<td>
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
										</td>
										</tr>
										<tr>
										<td>
											<font size="3" color="black"><b>Isosurfaces Rendering</b></font><br>
											<?php $src = "https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"; ?>
											<a href='./SetQueryParameters.php?image=<?php echo $src ?>&desc=Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.'><img src="https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"  width="250" height="250"></a>
										</td>
										<td>
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
										</td>
										</tr>
										<tr>
										<td>
											<font size="3" color="black"><b>Mesh Plot</b></font><br>
											<?php $src = "https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"; ?>
											<a href='./SetQueryParameters.php?image=<?php echo $src ?>&desc=Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.'><img src="https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"  width="250" height="250"></a>
										</td>
										<td>
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
										</td>
										</tr>
										<tr>
										<td>
											<font size="3" color="black"><b>Molecular Structure</b></font><br>
											<?php $src = "https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"; ?>
											<a href='./SetQueryParameters.php?image=<?php echo $src ?>&desc=Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.'><img src="https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"  width="250" height="250"></a>
										</td>
										<td>
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
										</td>
										</tr>
										<tr>
										<td>
											<font size="3" color="black"><b>Molecular Structure Cartoon</b></font><br>
											<?php $src = "https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"; ?>
											<a href='./SetQueryParameters.php?image=<?php echo $src ?>&desc=Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.'><img src="https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"  width="250" height="250"></a>
										</td>
										<td>
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
										</td>
										</tr>
										<tr>
										<td>
											<font size="3" color="black"><b>Point Plot</b></font><br>
											<?php $src = "https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"; ?>
											<a href='./SetQueryParameters.php?image=<?php echo $src ?>&desc=Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.'><img src="https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"  width="250" height="250"></a>
										</td>
										<td>
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
										</td>
										</tr>
										<tr>
										<td>
											<font size="3" color="black"><b>Raster Cube</b></font><br>
											<?php $src = "https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"; ?>
											<a href='./SetQueryParameters.php?image=<?php echo $src ?>&desc=Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.'><img src="https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"  width="250" height="250"></a>
										</td>
										<td>
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
										</td>
										</tr>
										<tr>
										<td>
											<font size="3" color="black"><b>Surface Plot</b></font><br>
											<?php $src = "https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"; ?>
											<a href='./SetQueryParameters.php?image=<?php echo $src ?>&desc=Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.'><img src="https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"  width="250" height="250"></a>
										</td>
										<td>
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
										</td>
										</tr>
										<tr>
										<td>
											<font size="3" color="black"><b>Volume Rendering</b></font><br>
											<?php $src = "https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"; ?>
											<a href='./SetQueryParameters.php?image=<?php echo $src ?>&desc=Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.'><img src="https://nanohub.org/infrastructure/rappture/raw-attachment/wiki/rp_xml_ele_field/contour.jpg"  width="250" height="250"></a>
										</td>
										<td>
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
										</td>
										</tr>
									</table>
									</p>
								</div>
							</div>
						</body>
					</html>
				</div>
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