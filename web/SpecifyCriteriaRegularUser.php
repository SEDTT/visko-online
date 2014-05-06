<?php
	require_once("./include/membersite_config.php");
	require_once 'source/db/UserManager.php';
	require_once 'source/db/QueryManager.php';
	
	if(!$fgmembersite->CheckLogin()){
		$fgmembersite->RedirectToURL("index.php");
		exit;
	}

	$nameOfPerson = $fgmembersite->UserEmail();
	$userManager = new UserManager();
	$user = $userManager->getUserByEmail($nameOfPerson);
	
	$qm = new QueryManager();
	
	$abstractions = $qm->getUserAbstractions($user->getID());
	$inputURLs = $qm->getUserInputURLs($user->getID());
	$inputTypes = $qm->getUserInputTypes($user->getID());
	$inputFormats = $qm->getUserInputFormats($user->getID());
	$viewerSets = $qm->getUserViewerSets($user->getID());
	
	if(isset($_POST['submitted'])){
		$viewURI = ($_POST['viewURI'] == 'any') ? null : $_POST['viewURI'];
		$viewerSetURI = ($_POST['viewerSetURI'] == 'any') ? null : $_POST['viewerSetURI'];
		$inputURL = ($_POST['inputURL'] == 'any') ? null : $_POST['inputURL'];
		$formatURI = ($_POST['formatURI'] == 'any') ? null : $_POST['formatURI'];
		$typeURI = ($_POST['typeURI'] == 'any') ? null : $_POST['typeURI'];
		$startDate = parseDate($_POST['startDate']);
		$endDate = parseDate($_POST['endDate']);
		
		//search and get query results!!!
		$queryResults = $qm->searchUserQueries($user->getID(),
			$typeURI, $formatURI, $viewURI, $viewerSetURI, $inputURL, 
			$startDate, $endDate
		);
		
		//var_dump($queryResults);
		
	}
	
	
	
	function urltail($url){
		return parse_url($url, PHP_URL_FRAGMENT);
	}
	
	function parseDate($date){
		if($date == null || trim($date) == ''){
				return null;
		}
		else{
			return DateTime::createFromFormat('M/d/Y', trim($date));
		}
	}
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
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
									<script src="//code.jquery.com/jquery-1.9.1.js"></script>
									<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
									<link rel="stylesheet" href="/resources/demos/style.css">
									<script>
									$(function() {
									$( "#start_datepicker" ).datepicker();
									$("#end_datepicker").datepicker();
									});
									</script>
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
						<font size="5" color="black"> Visualization Search Criteria</font></br></br></br>		
				
					
									<form action="SpecifyCriteriaRegularUser.php" method="post">
										<input type="hidden" name="submitted" value="true">
								<table>
									<tr>
										<td>
										<select name="viewURI" id="ddAbstract" style="width:100%">
										<option value="any" selected>Any Abstraction</option>
										<?php foreach($abstractions as $abstraction)
											echo '<option value="'. $abstraction . '">'. urltail($abstraction) .'</option>';
										 ?>
										
										</select>
										</td>
										<td style="width:250px"> </td>
										<td>
											<html lang="en">
								
					
									<p>
									Start Date: <input name="startDate" type="text" id="start_datepicker"></br></br>
									End Date: <input name="endDate" type="text" id="end_datepicker">
									</p> 
							
							
							</td>
							</br></br></br>
							</tr>
							<tr style = "height:100px"></tr>
							<tr>
								<td>
									<select name="inputURL" id="ddInputURL" style="width:100%">
										<option value="any" selected>Any Input URL</option>
										<?php foreach($inputURLs as $inputURL)
											echo '<option value="'. $inputURL . '">'. $inputURL .'</option>';
										 ?>
									</select>
								</td>
								<td></td>
								<td>
									<select name="viewerSetURI" id="ddviewSet" style="width:100%">
										<option value="any" selected>Any Viewer Set</option>
										<?php foreach($viewerSets as $viewerSet)
											echo '<option value="'. $viewerSet . '">'. urltail($viewerSet) .'</option>';
										 ?>
									</select>
								</td>
							</tr>
							<tr style = "height:100px"></tr>
							<tr>	
								<td>
									<select name="formatURI" id="ddSourceFormat" style="width:100%">
										<option value="any" selected>Any Source Format</option>
										<?php foreach($inputFormats as $inputFormat)
											echo '<option value="'. $inputFormat . '">'. urltail($inputFormat) .'</option>';
										 ?>
									</select>
								</td>
								<td style= "width:250px"></td>
								<td>	
									<select name="typeURI" id="ddSourceType" style="width:100%">
										<option value="any" selected>Any Source Type</option>
										<?php foreach($inputTypes as $inputType)
											echo '<option value="'. $inputType . '">'. urltail($inputType) .'</option>';
										 ?>
									</select>
								</td>
							</tr>		
								</table>	
								
							</br></br>
							
							
		
					<body> 
						<div style = "float:right;">
							<button id = "button_id">Search</button>
						</div>
						<br><br><br>
						<p>
						
							<hr>
							
							Results:
								<div id = "resultsTbl" align = "center">
								Click on any visualization to see details.
				
								<table  border = "1" style=	"width:600px; height:100px" >
								<?php 
										if(isset ($queryResults)){
											$counter = 0;
											foreach($queryResults as $result){
												list($pipelineID, $normal, $resultURL) = $result;
											
												if($counter % 3 == 0)
													echo '<tr>';
												
												echo '<td><a href="ViewDetailsRegularUser.php?pid=' . $pipelineID .'"><img style="width:50px;height:50px;" src="'. $resultURL .'"/></a></td>';	
													
												if($counter % 3 == 0)
													echo '</tr>';
													
												$counter = $counter + 1;
											}
										}
			
								 ?>
								</table>
						</p>
						</form>
					</body>	
				</html>	
				</div>
		</div>
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
