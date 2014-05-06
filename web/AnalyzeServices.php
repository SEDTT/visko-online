<?php
	require_once("./include/membersite_config.php");
//	if(!$fgmembersite->CheckLogin()){
//		$fgmembersite->RedirectToURL("index.php");
//		exit;
//	}
	
	if(isset($_POST['submitted'])){
		/*if($fgmembersite->RegisterUser()){
			$fgmembersite->RedirectToURL("thank-you.html");
		}*/
	}
	
//	$nameOfPerson = $fgmembersite->UserEmail();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Privileged Mode</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" href="images/logo.png">
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
					<font size="10" color="white"><b>&nbsp; Privileged Mode</b></font>
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
					<font size="6" color="black">Frequency of Service Properties</font></br></br>				
					
					- Total Number of Services Registered: [[X]]<br><br>
					- Most Supported Abstraction: [[Abstraction]]<br>
					- Most Supported Input Format: [[Format]]<br>
					- Most Supported Input Data Type: [[Type]]<br>
					- Most Supported Output Format: [[Format]]<br>
					- Most Supported Output Data Type: [[Type]]<br>
					- Most Supported Service Toolkit: [[Toolkit Name]]<br><br><br>
					
					
					<br><br><br>
					
					<p>
						<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
						

						<div id="container1" style="height: 400px; min-width: 310px;	max-width: 800px;margin: 0 auto;">
							
						<script>
						
							$(function () {
							window.ViewerSets = getViewerSets();
							window.Viewers = getViewers();
							window.Tranformers = getTransformers();
							window.Converters = getConverters();
							window.Filters = getFilters();
							window.Mappers = getMappers();
							
							 Highcharts.setOptions(Highcharts.theme);
								$('#container1').highcharts({
								chart: {
									type: 'column',
									margin: 75,
									options3d: {
										enabled: true,
										alpha: 10,
										beta: 25,
										depth: 70
									}
								},
								title: {
									text: 'Frequency of Service Types'
								},
								subtitle: {
									text: ''
								},
								plotOptions: {
									column: {
										depth: 25
									}
								},
								xAxis: {
									categories: ['Viewer Sets', 'Viewers', 'Transformers', 'Converters', 'Filters', 'Mappers']
								},
								yAxis: {
									opposite: true
								},
								series: [{
									name: 'Service Types',
									data: [window.ViewerSets,window.Viewers,window.Tranformers, window.Converters, window.Filters, window.Mappers]
								}]
								});
							});
                            
                            
                            function getViewerSets()
							{
								var value = <?php echo (60) ?>;
                                return value;
                            }
                            
                            function getViewers()
							{
                                var value = <?php echo (44) ?>;
                                return value;
                            }
                            
                            function getTransformers()
                            {
                               var value = <?php echo (66) ?>;
                                return value;
                            }
                            function getConverters()
							{
                               var value = <?php echo (88) ?>;
                                return value;
                            }
                            function getFilters()
							{
                               var value = <?php echo (10) ?>;
                                return value;
                            }
                            function getMappers()
							{
                                var value = <?php echo (109) ?>;
                                return value;
                            }
						</script>    
					</div>
					</p>
					<br><br><br><br><br><br>
		
					
					
					<p>
					- Service with most associated errors: [[Service Name]]<br><br><br><br><br><br>
					</p>
					<p>
						<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
						<script src="http://code.highcharts.com/highcharts.js"></script>
						<script src="http://code.highcharts.com/highcharts-3d.js"></script>
						<script src="http://code.highcharts.com/modules/exporting.js"></script>

						<div id="container" style="height: 400px; min-width: 310px;	max-width: 800px;margin: 0 auto;">
						
						
						<?php
							// Eddie's localhost
							$conn = mysql_connect('localhost','root','sk@t3low1432');
							//echo "Connection: " . $conn;
							
							$timeOutTemp  = mysql_query("SELECT COUNT(*) AS count0 FROM cs4311team3sp14.servicetimeouterrors",   $conn);
							$timeOut1     = mysql_fetch_object($timeOutTemp);
							$timeOut = $timeOut1->count0;
							//echo "Time out: " . $timeOut;
							
							$inputDataTemp = mysql_query("SELECT COUNT(*) AS count1 FROM cs4311team3sp14.inputdataurlerrors",     $conn);
							$inputData1    = mysql_fetch_object($inputDataTemp);
							$inputData = $inputData1->count1;
							//echo "Input: " . $inputData;
							
							$serviceExecTemp = mysql_query("SELECT COUNT(*) AS count2 FROM cs4311team3sp14.serviceexecutionerrors", $conn);
							$serviceExec1    = mysql_fetch_object($serviceExecTemp);
							$serviceExec = $serviceExec1->count2;
							//echo "SErvice: " . $serviceExec;
						?>
						<script>
							
							$(function () {
							window.timeoutError = getTimeoutError();
							window.inputDataError = getInputData();
							window.serivceExecError= getServiceExec();
							 Highcharts.setOptions(Highcharts.theme);
								$('#container').highcharts({
								chart: {
									type: 'column',
									margin: 75,
									options3d: {
										enabled: true,
										alpha: 10,
										beta: 25,
										depth: 70
									}
								},
								title: {
									text: 'Frequency of Service Errors'
								},
								subtitle: {
									text: ''
								},
								plotOptions: {
									column: {
										depth: 25
									}
								},
								xAxis: {
									categories: ['Service Timeout', 'Inupt Data', 'Service Execution']
								},
								yAxis: {
									opposite: true
								},
								series: [{

									name: 'Errors',
									data: [window.timeoutError, window.inputDataError, window.serivceExecError]
								}]
								});
							});
							Highcharts.createElement('link', {
								href: 'http://fonts.googleapis.com/css?family=Unica+One',
								rel: 'stylesheet',
								type: 'text/css'
							}, null, document.getElementsByTagName('head')[0]);

							Highcharts.theme = {
								colors: ["#0F3E58","#2b908f", "#90ee7e", "#f45b5b", "#7798BF", "#aaeeee", "#ff0066", "#eeaaee", "#55BF3B", "#DF5353", "#7798BF", "#aaeeee"],
								chart: {
									backgroundColor: {
										linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
										stops: [
											[0, '#DDDDDD'],
											[1, '#aaaaaa']
										]
									},
									style: {
										fontFamily: "'Lucida Sans Unicode', 'Arial', 'Helvetica', 'sans-serif'"
									},
									plotBorderColor: '#606063'
								},
								title: {
									style: {
										color: '#333333',
										textTransform: 'uppercase',
										fontSize: '20px'
									}
								},
								subtitle: {
									style: {
										color: '##333333',
										textTransform: 'uppercase'
									}
								},
								xAxis: {
									gridLineColor: '#707073',
									labels: {
										style: {
											color: '#333333'
										}
									},
									lineColor: '#707073',
									minorGridLineColor: '#505053',
									tickColor: '#707073',
									title: {
										style: {
											color: '##333333'
										}
									}
								},
								yAxis: {
									gridLineColor: '#707073',
									labels: {
										style: {
											color: '#333333'
										}
									},
									lineColor: '#707073',
									minorGridLineColor: '#505053',
									tickColor: '#707073',
									tickWidth: 1,
									title: {
										style: {
											color: '#333333'
										}
									}
								},
								tooltip: {
									backgroundColor: 'rgba(0, 0, 0, 0.85)',
									style: {
										color: '#F0F0F0'
									}
								},
								plotOptions: {
									series: {
										dataLabels: {
											color: '#B0B0B3'
										},
										marker: {
											lineColor: '#333333'
										}
									},
									boxplot: {
										fillColor: '#505053'
									},
									candlestick: {
										lineColor: 'white'
									},
									errorbar: {
										color: 'white'
									}
								},
								legend: {
									itemStyle: {
										color: '#333333'
									},
									itemHoverStyle: {
										color: '#FFF'
									},
									itemHiddenStyle: {
										color: '#606063'
									}
								},
								credits: {
									style: {
										color: '#666'
									}
								},
								labels: {
									style: {
										color: '#707073'
									}
								},

								drilldown: {
									activeAxisLabelStyle: {
										color: '#F0F0F3'
									},
									activeDataLabelStyle: {
										color: '#F0F0F3'
									}
								},

								navigation: {
									buttonOptions: {
										symbolStroke: '#DDDDDD',
										theme: {
											fill: '#505053'
										}
									}
								},

								// scroll charts
								rangeSelector: {
									buttonTheme: {
										fill: '#505053',
										stroke: '#000000',
										style: {
											color: '#CCC'
										},
									states: {
										hover: {
											fill: '#707073',
											stroke: '#000000',
											style: {
												color: 'white'
											}
										},
											select: {
												fill: '#000003',
												stroke: '#000000',
												style: {
													color: 'white'
												}
											}
										}
									},
									inputBoxBorderColor: '#505053',
									inputStyle: {
										backgroundColor: '#333',
										color: 'silver'
									},
									labelStyle: {
										color: 'silver'
									}
								},

								   navigator: {
									  handles: {
										 backgroundColor: '#666',
										 borderColor: '#AAA'
									  },
									  outlineColor: '#CCC',
									  maskFill: 'rgba(255,255,255,0.1)',
									  series: {
										 color: '#7798BF',
										 lineColor: '#A6C7ED'
									  },
									  xAxis: {
										 gridLineColor: '#505053'
									  }
								   },

								   scrollbar: {
									  barBackgroundColor: '#808083',
									  barBorderColor: '#808083',
									  buttonArrowColor: '#CCC',
									  buttonBackgroundColor: '#606063',
									  buttonBorderColor: '#606063',
									  rifleColor: '#FFF',
									  trackBackgroundColor: '#404043',
									  trackBorderColor: '#404043'
								   },

								   // special colors for some of the
								   legendBackgroundColor: 'rgba(0, 0, 0, 0.5)',
								   background2: '#505053',
								   dataLabelsColor: '#B0B0B3',
								   textColor: '#C0C0C0',
								   contrastTextColor: '#F0F0F3',
								   maskColor: 'rgba(255,255,255,0.3)'
								};
                            
                            function getTimeoutError()
							{
								var value = <?php  echo ($timeOut) ?>;
                                return value;
                            }
                            function  getInputData()
							{
                               var value = <?php echo ($inputData) ?>;
                                return value;
                            }
                            function getServiceExec()
							{
                                var value = <?php echo ($serviceExec) ?>;
                                return value;
                            }
                            
						</script>    
					</div>
					</p>
					<br><br>
					
				</div>
			
				<br/><br/><br/>
			</div>
			<footer>&copy; Developmental Technologies Team. All Rights Reserved</footer>
		</div>
	</body>
	
<div id="nav_table" style="position: fixed; left:0px; right: 40px; top: 100px; bottom: auto; display: block">
    <ul id="sidebar-nav" class="Menu">
<body>
	<br>
	<table class="bottomBorder">
		<tr>
		  <td><center></td>
		</tr>
		<tr>
		  <td><center><a href="./PrivilegedUserHome.php" style="text-decoration:none;"><font size="4" color="black">Home</font><br><br></a></td>
		</tr>
		<tr>
		  <td><center><br><a href="./PipelineSpecifyCriteria.php" style="text-decoration:none;"><font size="4" color="black">Search Pipelines</font><br><br></a></td>
		</tr>
		<tr>
		  <td><center><br><a href="./QueriesSpecifyCriteria.php" style="text-decoration:none;"><font size="4" color="black">Search Queries</font><br><br></a></td>
		</tr>
		<tr>
		  <td><center><br><a href="./ServicesSpecifyCriteria.php" style="text-decoration:none;"><font size="4" color="black">Search Services</font><br><br></a></td>
		</tr>
		<tr>
		  <td><center><br><a href="./SearchUsers.php" style="text-decoration:none;"><font size="4" color="black">Search Users</font><br><br></a></td>
		</tr>
		<tr>
		  <td><center><br><a href="./AnalyzePipelines.php" style="text-decoration:none;"><font size="4" color="black">Analyze Pipelines</font><br><br></a></td>
		</tr>
		<tr>
		  <td><center><br><a href="./AnalyzeQueries.php" style="text-decoration:none;"><font size="4" color="black">Analyze Queries</font><br><br></a></td>
		</tr>
		<tr>
		  <td><center><br><a href="./AnalyzeServices.php" style="text-decoration:none;"><font size="4" color="black">Analyze Services</font><br><br></a></td>
		</tr>
	</table>
    </ul>
</div>
</body>
</html>