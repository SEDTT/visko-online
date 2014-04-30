<?php
	require_once("./include/membersite_config.php");
	require_once("./source/viskoapi/ViskoQuery.php");
	
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

	$image = $_GET['image'];
	$description = $_GET['desc'];
	$viewURIs = $_GET['type'];
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
		<script type="text/javascript">
			var defaultValue = "default";
			var format;
			var type;
			var view;
			var viewerSet;
			var artifactURL;
			var parameter;
			var parameterValue;
			var bindings = new Array();

			function parameterBinding(parameter,parameterValue)
			{
				this.parameter=parameter;
				this.parameterValue=parameterValue;
			}

			function trim(stringToTrim)
			{
				return stringToTrim.replace(/^\s+|\s+$/g,"");
			}

			function reset()
			{
				format = defaultValue;
				type = defaultValue;
				view = defaultValue;
				viewerSet = defaultValue;
				artifactURL = defaultValue;
				
				document.getElementById("ddInputDataFormat").disabled = false;
				//document.getElementById("paramURIs").disabled = true;
				//document.getElementById("paramValue").disabled = true;
				//document.getElementById("bindButton").disabled = true;
				document.getElementById("ddInputDataType").disabled = false;
				document.getElementById("ddviewURI").disabled = false;
				document.getElementById("ddViewerSet").disabled = false;
				document.getElementById("ddInputDataURL").disabled = false;
				document.getElementById("queryText").disabled = false;
				//document.getElementById("submitButton").disabled = true;
				
				document.getElementById("ddInputDataFormat").selectedIndex = 0;
				document.getElementById("ddInputDataType").selectedIndex = 0;
				//document.getElementById("paramURIs").selectedIndex = 0;
				//document.getElementById("paramValue").value = "";
				document.getElementById("ddviewURI").selectedIndex = 0;
				document.getElementById("ddViewerSet").selectedIndex = 0;
				document.getElementById("ddInputDataURL").value = "";
				document.getElementById("queryText").value = "";
				
				//bindings = new Array();
			}

			function setQueryFields()
			{	
				document.getElementById("ddInputDataType").disabled = false;
				//document.getElementById("paramURIs").disabled = false;
				//document.getElementById("paramValue").disabled = false;
				//document.getElementById("bindButton").disabled = false;
				document.getElementById("ddInputDataFormat").disabled = false;
				document.getElementById("ddViewerSet").disabled = false;
				document.getElementById("ddInputDataURL").disabled = false;
				document.getElementById("queryText").disabled = false;
				//document.getElementById("submitButton").disabled = false;
				
				format = document.getElementById("ddInputDataFormat").value;
				var elem = document.getElementById("formatInput");
				elem.value= format;
				type = document.getElementById("ddInputDataType").value;
				var elem2 = document.getElementById("typeInput");
				elem2.value= type;
				view = ddviewURI;
				var elem3 = document.getElementById("viewInput");
				elem3.value= view;
				//view = "<?php echo $viewURIs; ?>";
				//<?php echo $viewURIs; ?>
				//view = document.getElementById("viewURIs").value;
				viewerSet = document.getElementById("ddViewerSet").value;
				var elem4 = document.getElementById("viewerSetInput");
				elem4.value= viewerSet;
				artifactURL = trim(document.getElementById("ddInputDataURL").value);
				var elem5 = document.getElementById("artifactURLInput");
				elem5.value= artifactURL;
				
				/*parameter = document.getElementById("paramURIs").options[document.getElementById("paramURIs").selectedIndex].value;
				parameterValue = trim(document.getElementById("paramValue").value);
				
				if(parameter != defaultValue && parameterValue != "" && parameterValue != null)
				{
					var paramExists = false;
					for(var i = 0; i < bindings.length; i = i + 1)
					{
						var binding = bindings[i];
						if(binding.parameter == parameter)
						{
							binding.parameterValue = parameterValue;
							paramExists = true;
						}
					}
					
					if(!paramExists)
					{
						bindings.push(new parameterBinding(parameter, parameterValue));
					}
				}*/
			}
				
			function clearParameterValue()
			{
				document.getElementById("paramValue").value = "";
				writeQuery();
			}

			function writeQuery()
			{	
				setQueryFields();
				var query = "";
				//document.write("hello!");
				if(view == defaultValue)
				{reset();}
				else
				{
					if(artifactURL != null && artifactURL != "")
					{query = query + "VISUALIZE " + artifactURL + " \n";}
					else
					{query = query + "VISUALIZE url \n";}
				
					if(view != null && view != defaultValue)
						query = query + "AS " + view + " \n";
					else{query = query + "AS view";}
					
					if(viewerSet !== null && viewerSet != defaultValue)
					{query = query + "IN " + viewerSet + " \n";}
					else
					{query = query + "IN viewer-set \n";}
					
					if(format != null && format != defaultValue)
					{
						query = query + "WHERE\n";
						query = query + "\tFORMAT = " + format + "\n";
					}
					else
					{query = query + "WHERE\n\tFORMAT = format\n";}
					
					if(type != null && type != defaultValue)
					{query = query + "\tAND TYPE = " + type + "\n";}
					else
					{query = query + "\tAND TYPE = type\n";}
					
					for(var i = 0; i < bindings.length; i = i + 1)
					{
						var binding = bindings[i];
						var parameter = binding.parameter;
						var parameterValue = binding.parameterValue;
						
						query = query + "\tAND " + parameter + " = " + parameterValue + "\n";
					
					}		
					document.getElementById("queryText").value = query;
				}
			}
			
			
			function constructQuery(){
			//var ekis = "<?php echo'ekis'; ?>;"
			//<?php
			//	echo "hi";
			//	$viskoQuery = new ViskoQuery(null, format, type, view, viewerSet, artifactURL, null);
			//?>;
			//window.location='<%= ResolveUrl("SelectPipelines.php") %>'
				//document.write("yay");
			}
		</script>

	</head>
	<body onLoad = "reset()">
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
						var ddviewURI;
							$(document).ready(function()
							{
								$.getJSON("json/dropdownlists.txt",function(obj)
							   {
									 $.each(obj.viewerSets,function(key,value)
									 {
										var option = $('<option />').val(value.viewerSetURI).text(value.viewerSetName);
										$("#ddViewerSet").append(option);
									 });
									 
									 $.each(obj.inputFormats,function(key,value)
									 {
										var option = $('<option />').val(value.inputFormatURI).text(value.inputFormatName);
										$("#ddInputDataFormat").append(option);
									 });
									 
									 $.each(obj.inputDataTypes,function(key,value)
									 {
										var option = $('<option />').val(value.inputDataTypeURI).text(value.inputDataTypeName);
										$("#ddInputDataType").append(option);
									 });	
									
									$.each(obj.abstractions, function (i, elem) 
									{
										if (elem.abstractionName === '<?php echo $viewURIs ?>') {
										 ddviewURI= elem.abstractionURI;
										 //document.write(ddviewURI);
										}
									});
								});
							});
							</script>
						</head> 
						
						<!--ends here-->
						<table style="width:100%">
						<tr>
							<td>
								<div style="width:250px;height:250px;">
									<img src="
										<?php echo $image; ?>" width="250" height="250"/> 
								</div>
							</td>
							<td style="width:30px"></td>
							<td>
								<font size="2" color="black"><?php echo $description; ?></font>
							</td>
						</tr>
						</table>
						
						<br><br>
						<hr>
						
						<table style="width:100%">
						<tr>
							<td style = "height:50px">
								<select id="ddViewerSet" style="width:400px" onchange="writeQuery()">
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
								<select id="ddInputDataFormat" style="width:100%" onchange="writeQuery()">
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
								<select id="ddInputDataType" style="width:100%" onchange="writeQuery()">
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
								Input Data URL: <input type="text" name="inputDataURL" style="width:100%" id="ddInputDataURL"><br>
								</form> 
							</td>
							<td></td>
							<td>
								<font size="2" color="black"><p align="justify"><b>Input Data URL: </b>refers to the location of your input data which is to be visualized.</p></font>
							</td>
						</tr>
						<tr>
							<td><form name="myform" action= "SelectPipelines.php" method="post">
								<input type="hidden" name="format" id="formatInput"/> <br />
								<input type="hidden" name="type" id="typeInput"/> <br />
								<input type="hidden" name="view" id="viewInput"/> <br />
								<input type="hidden" name="viewerSet" id="viewerSetInput"/> <br />
								<input type="hidden" name="artifactURL" id="artifactURLInput"/> <br />
								<center><input name="Submit" value="submit" type="submit" onClick="writeQuery()" /></center>
								</form>
							</td>
						</tr>
						</table>
						<form action="ViskoServletManager">
						<input type="hidden" name="requestType" value="execute-query" /> 	<table style="width: 1023px; ">
						<tr><td colspan="2"><h2>VisKo  Query</h2></td></tr>
						<tr>
							<td style="width: 996px; " colspan="2" align="right"><textarea style="width: 989px; height: 152px; background-color: #AFEEEE" id="queryText" name="query"></textarea></td>
						</tr>
						</form>
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