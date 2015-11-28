<html>
	<head>
		<style>
		.center {
		  position: relative;
		  top: 50%;
		  left: 50%;
		  transform: translateY(-50%) translateX(-50%);
		}
		#importfrm {
			padding: 20px;
			border: 1px solid gray;
			background: #eeeeee;
			width: 400px;
			text-align: center;
			line-height: 40px;
		}
		#progress {
			height: 20px;  /* Can be anything */
			position: relative;
			background: #555;
			border: 2px solid black;
		}
		.meteryes {
			float: left;
			display: inline-block;
			  height: 100%;
			  background-color: darkgreen;
			  position: relative;
			  overflow: hidden;
		}

		.meterno {
			float: left;
			display: inline-block;
			  height: 100%;
			  background-color: darkred;
			  position: relative;
			  overflow: hidden;
		}

		.meterskip {
			float: left;
			display: inline-block;
			  height: 100%;
			  background-color: yellow;
			  position: relative;
			  overflow: hidden;
		}
		.error {
			display: none;
		}
		</style>
	</head>
	<body>		
		<form id="importfrm" class="center" method="post" enctype="multipart/form-data">
			<h2>Upload product/fitment data</h2>
			<table>
				<tr>
					<td>User ID :</td><td><input type="text" name="id" id="id"></td>
				</tr>
				<tr>
					<td>Password :</td><td><input type="password" name="pw" id="pw"></td>
				</tr>
				<tr>
					<td>Product data(csv) :</td><td><input type="file" name="product" id="product" accept=".csv"></td>
				</tr>					
				<tr>
					<td>Fitment data(csv) :</td><td><input type="file" name="fitment" id="fitment" accept=".csv"></td>
				</tr>
			</table>
			<div id="progress">
			</div>				
			<div id="information">
				Ready to process
				<br>Total: 0
				<br>Processed: 0
				<br>Skipped: 0
				<br>Failed: 0
			</div>
			<div class="error">User ID or Password mismatch.</div>
			<input type="submit" value="Import">
			<br>
		</form>
<?php
	function parseCSV($filepath) {		
		$row = 0;
		$header = array();
		$rows = array();
		if (($handle = fopen($filepath, "r")) !== FALSE) {
		  while (($data = fgetcsv($handle)) !== FALSE) {		  			    		  	
		    $row++;
		    if($row == 1) {	//Header	
		    	$header = $data;	    
		    } else {	//Data rows
		    	$obj = array();
		    	for($i=0; $i<count($header); $i++) {
		    		$obj[$header[$i]] = $data[$i];
		    	}
		    	$rows[] = $obj;
		    }
		  }
		  fclose($handle);
		}
		return $rows;
	}

	$link = mysqli_connect('localhost', 'keyLessUser', 'Te0]%6.Qh_X0');
	mysqli_select_db($link, 'db_keyLessOption');
	header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	$id = null;
	if(isset($_REQUEST["id"]))
		$id = $_REQUEST["id"];
	$pw = null;
	if(isset($_REQUEST["pw"]))
		$pw = $_REQUEST["pw"];
	$success = 0;
	$failure = 0;
	$skip = 0;
	$total = 0;
	$percent = 0;
	if($id == null) {
	} else if($id == "admin" && $pw == "admin") {
		/*********************************************Add product make model and year in database*********************************************/
		if($_FILES["product"]["size"] != 0)
		{
			$rows = parseCSV($_FILES['product']['tmp_name']);
			// Total processes
			$total += count($rows);
			// Loop through process
			foreach($rows as $row)
			{				
				$sku = mysqli_real_escape_string($link, $row["Sku"]);
				$title = mysqli_real_escape_string($link, $row["Title"]);
				$content = mysqli_real_escape_string($link, $row["Description"]);
				$excerpt = mysqli_real_escape_string($link, $row["Short Description"]);
				$regprice = mysqli_real_escape_string($link, $row["Regular Price"]);
				$saleprice = mysqli_real_escape_string($link, $row["Sale Price"]);
				$salefrom = mysqli_real_escape_string($link, $row["Sale From Date"]);
				$saleto = mysqli_real_escape_string($link, $row["Sale To Date"]);
				$mngstock = mysqli_real_escape_string($link, $row["Manage Stock"]);
				$qty = mysqli_real_escape_string($link, $row["Stock Quantity"]);
				$stat = mysqli_real_escape_string($link, $row["Stock Status"]);
				$backorder = mysqli_real_escape_string($link, $row["Allow Backorders"]);
				$indiv = mysqli_real_escape_string($link, $row["Sold Individually"]);
				$weight = mysqli_real_escape_string($link, $row["Weight"]);
				$width = mysqli_real_escape_string($link, $row["Width"]);
				$height = mysqli_real_escape_string($link, $row["Height"]);
				$length = mysqli_real_escape_string($link, $row["Length"]);
				$condition = mysqli_real_escape_string($link, $row["Condition"]);
				$fccid = mysqli_real_escape_string($link, $row["FCC ID"]);
				$icother = mysqli_real_escape_string($link, $row["IC/Other"]);
				$partno = mysqli_real_escape_string($link, $row["Part Number"]);
				$progr = mysqli_real_escape_string($link, $row["Programming"]);
				$totalsale = mysqli_real_escape_string($link, $row["Total Sales"]);

				$now = date('Y-m-d H:i:s');

				//TODO other parameters
				$sql1 = mysqli_query($link, "SELECT p.ID FROM `auto_posts` p LEFT JOIN auto_postmeta m ON m.post_id=p.ID WHERE p.post_type='product' AND m.meta_key='_sku' AND m.meta_value='$sku'");
				$arr = mysqli_fetch_array($sql1);
				$ProductID = "";
				if($arr)
					$ProductID = $arr["ID"];
				if($ProductID == "" || $sku == "" || $sku == null) {					
					//TODO finish insert sql
					$addQuery = mysqli_query($link, "INSERT INTO auto_posts VALUES ('', '1', '$now', '$now', '$content', '$title', '$excerpt', 'publish', 'open', 'closed', '', 'product_".$sku."', '', '', '$now', '$now', '', '0', '', '0', 'product', '', '0')");					
					if($addQuery) {
						$pid = mysqli_insert_id($link);
						//TODO insert meta data
						int $res = 1;
						mysqli_query($link, "UPDATE auto_posts SET guid='https://www.keylessoption.com/?post_type=product&#038;p=" . $pid . "' WHERE ID='$pid'");
						$res = $res && mysqli_affected_rows($link);
						mysqli_query($link, "INSERT INTO auto_postmeta VALUES ('', '$pid', '_sku', '$sku')");
						$res = $res && mysqli_affected_rows($link);
						mysqli_query($link, "INSERT INTO auto_postmeta VALUES ('', '$pid', '_regular_price', '$regprice')");
						$res = $res && mysqli_affected_rows($link);
						mysqli_query($link, "INSERT INTO auto_postmeta VALUES ('', '$pid', '_sale_price', '$saleprice')");
						$res = $res && mysqli_affected_rows($link);
						mysqli_query($link, "INSERT INTO auto_postmeta VALUES ('', '$pid', '_sale_price_dates_from', '$salefrom')");
						$res = $res && mysqli_affected_rows($link);
						mysqli_query($link, "INSERT INTO auto_postmeta VALUES ('', '$pid', '_sale_price_dates_to', '$saleto')");
						$res = $res && mysqli_affected_rows($link);
						mysqli_query($link, "INSERT INTO auto_postmeta VALUES ('', '$pid', '_manage_stock', '$mngstock')");
						$res = $res && mysqli_affected_rows($link);
						mysqli_query($link, "INSERT INTO auto_postmeta VALUES ('', '$pid', '_stock', '$qty')");
						$res = $res && mysqli_affected_rows($link);
						mysqli_query($link, "INSERT INTO auto_postmeta VALUES ('', '$pid', '_stock_status', '$stat')");
						$res = $res && mysqli_affected_rows($link);
						mysqli_query($link, "INSERT INTO auto_postmeta VALUES ('', '$pid', '_backorders', '$backorder')");
						$res = $res && mysqli_affected_rows($link);
						mysqli_query($link, "INSERT INTO auto_postmeta VALUES ('', '$pid', '_sold_individually', '$indiv')");
						$res = $res && mysqli_affected_rows($link);
						mysqli_query($link, "INSERT INTO auto_postmeta VALUES ('', '$pid', '_weight', '$weight')");
						$res = $res && mysqli_affected_rows($link);
						mysqli_query($link, "INSERT INTO auto_postmeta VALUES ('', '$pid', '_width', '$width')");
						$res = $res && mysqli_affected_rows($link);
						mysqli_query($link, "INSERT INTO auto_postmeta VALUES ('', '$pid', '_height', '$height')");
						$res = $res && mysqli_affected_rows($link);
						mysqli_query($link, "INSERT INTO auto_postmeta VALUES ('', '$pid', '_length', '$length')");
						$res = $res && mysqli_affected_rows($link);
						mysqli_query($link, "INSERT INTO auto_postmeta VALUES ('', '$pid', 'condition', '$condition')");
						$res = $res && mysqli_affected_rows($link);
						mysqli_query($link, "INSERT INTO auto_postmeta VALUES ('', '$pid', 'FCC ID', '$fccid')");
						$res = $res && mysqli_affected_rows($link);
						mysqli_query($link, "INSERT INTO auto_postmeta VALUES ('', '$pid', 'IC/Other', '$icother')");
						$res = $res && mysqli_affected_rows($link);
						mysqli_query($link, "INSERT INTO auto_postmeta VALUES ('', '$pid', 'Part_Number', '$partno')");
						$res = $res && mysqli_affected_rows($link);
						mysqli_query($link, "INSERT INTO auto_postmeta VALUES ('', '$pid', 'Programming', '$progr')");
						$res = $res && mysqli_affected_rows($link);
						mysqli_query($link, "INSERT INTO auto_postmeta VALUES ('', '$pid', 'total_sales', '$totalsale')");
						$res = $res && mysqli_affected_rows($link);
						if($res)
							$success ++;
					} else {
						$failure ++;
					}
				} else {
					$skip ++;
				}

			    // Calculate the percentation
			    $yespercent = round($success * 100/$total )."%";
			    $nopercent = round($failure * 100/$total)."%";
			    $skippercent = round($skip * 100/$total)."%";
			    $totalpercent = round(($skip + $success + $failure)* 100/$total )."%";

			    if($totalpercent != $percent && $totalpercent % 5 == 0) {
			    	$percent = $totalpercent;
			    
				    // Javascript for updating the progress bar and information
				    echo '<script language="javascript">
				    document.getElementById("progress").innerHTML="<div class=\"meteryes\" style=\"width:'.$yespercent.';\">&nbsp;</div><div class=\"meterskip\" style=\"width:'.$skippercent.';\">&nbsp;</div><div class=\"meterno\" style=\"width:'.$nopercent.';\">&nbsp;</div>";
				    document.getElementById("information").innerHTML="Now processing ...<br>Total: '.$total.'<br>Processed: '.$success.'<br>Skipped: '.$skip.'<br>Failed: '.$failure.'";
				    </script>';

					// This is for the buffer achieve the minimum size in order to flush data
				    echo str_repeat(' ',1024*64);		    

					// Send output to browser immediately
				    flush();
				}
			}
		}
		if($_FILES["fitment"]["size"] != 0)
		{
			$rows = parseCSV($_FILES['fitment']['tmp_name']);
			mysqli_query($link, "delete from auto_automodels");
			// Total processes
			$total += count($rows);
			// Loop through process
			foreach($rows as $row)
			{				
				$sku = mysqli_real_escape_string($link, $row["Description"]);
				$make = mysqli_real_escape_string($link, $row["Make"]);
				$year = mysqli_real_escape_string($link, $row["Year"]);
				$model = mysqli_real_escape_string($link, $row["Model"]);
				$sql1 = mysqli_query($link, "SELECT p.ID FROM `auto_posts` p LEFT JOIN auto_postmeta m ON m.post_id=p.ID WHERE p.post_type='product' AND m.meta_key='_sku' AND m.meta_value='$sku'");
				$arr = mysqli_fetch_array($sql1);
				$ProductID = "";
				if($arr)
					$ProductID = $arr["ID"];
				if($ProductID == "" || $sku == "" || $sku == null) {
					$skip ++;
				} else {
					$addQuery = mysqli_query($link, "INSERT INTO auto_automodels VALUES ('', '$ProductID', '$make', '$year', '$model')");

					if($addQuery) {
						$success ++;
					} else {
						$failure ++;
					}
				}

			    // Calculate the percentation
			    $yespercent = round($success * 100/$total )."%";
			    $nopercent = round($failure * 100/$total)."%";
			    $skippercent = round($skip * 100/$total)."%";
			    $totalpercent = round(($skip + $success + $failure)* 100/$total )."%";

			    if($totalpercent != $percent && $totalpercent % 5 == 0) {
			    	$percent = $totalpercent;
			    
				    // Javascript for updating the progress bar and information
				    echo '<script language="javascript">
				    document.getElementById("progress").innerHTML="<div class=\"meteryes\" style=\"width:'.$yespercent.';\">&nbsp;</div><div class=\"meterskip\" style=\"width:'.$skippercent.';\">&nbsp;</div><div class=\"meterno\" style=\"width:'.$nopercent.';\">&nbsp;</div>";
				    document.getElementById("information").innerHTML="Now processing ...<br>Total: '.$total.'<br>Processed: '.$success.'<br>Skipped: '.$skip.'<br>Failed: '.$failure.'";
				    </script>';

					// This is for the buffer achieve the minimum size in order to flush data
				    echo str_repeat(' ',1024*64);		    

					// Send output to browser immediately
				    flush();
				}
			}
		}
		// Tell user that the process is completed
		echo '<script language="javascript">
			document.getElementById("progress").innerHTML="<div class=\"meteryes\" style=\"width:'.$yespercent.';\">&nbsp;</div><div class=\"meterskip\" style=\"width:'.$skippercent.';\">&nbsp;</div><div class=\"meterno\" style=\"width:'.$nopercent.';\">&nbsp;</div>";
			document.getElementById("information").innerHTML="Process completed.<br>Total: '.$total.'<br>Processed: '.$success.'<br>Skipped: '.$skip.'<br>Failed: '.$failure.'";</script>';
	} else {
		echo '<style>
		.error {
			display: block;
			color: red;
		}
		</style>';
	}
?>
	</body>
</html>