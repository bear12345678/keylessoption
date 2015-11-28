<?php
/**
 * Template Name: GET YEAR1
 */
get_header();
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'getMakes')
{
	$myobj= file_get_contents('https://api.edmunds.com/api/vehicle/v2/makes?state=new&fmt=json&api_key=c8ektqg3jrxzyd73duwm74ne&state=new&view=full');
	$arraynew = json_decode($myobj);
	$num = count($arraynew->makes);/***It counts array elements for loop***/ 
	//echo $num;
	?>
	<select id="_text_field1">
    <option value="">--Select Make--</option>
	<?php for($i = 0; $i <= $num; $i++)  { ?>
		<option value="<?php echo $arraynew->makes[$i]->name; ?>" >
			<?php echo $arraynew->makes[$i]->name;/*******Code to get year*******/ ?>
         </option>
	<?php } ?>
    </select>
<?php }
/******************************************************************
				Code to get model according to make
******************************************************************/
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'getModel')
{
	$make = $_REQUEST['make'];
	$myobj= file_get_contents('https://api.edmunds.com/api/vehicle/v2/'.$make.'/models?fmt=json&api_key=pzuapzj3seygzqg6p6t6exrs');
	$arraynew = json_decode($myobj);
	$num = count($arraynew->models);/***It counts array elements for loop***/ 
	?>
	<select id="_textarea3" multipe>
    <option value="">--Select Model--</option>
	<?php for($i = 0; $i <= $num; $i++)  { ?>
		<option value="<?php echo $arraynew->models[$i]->name; ?>" >
			<?php echo $arraynew->models[$i]->name;/*************Code to get model************/  ?>
         </option>
	<?php } ?>
    </select>
    <?php }
/************************************************************************************
				Code to get year according to make and model
************************************************************************************/
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'getYear')
{
	$make = $_REQUEST['make'];
	$model = $_REQUEST['model'];
	$myobj = file_get_contents('http://api.edmunds.com/api/vehicle/v2/BMW/1-series/years?fmt=json&api_key=pzuapzj3seygzqg6p6t6exrs');
	//$myobj= file_get_contents('https://api.edmunds.com/api/vehicle/v2/BMW/models?fmt=json&api_key=pzuapzj3seygzqg6p6t6exrs');
	$arraynew = json_decode($myobj);
	
	$num = count($arraynew->years);/***It counts array elements for loop***/ 
	for($i = 0; $i <= $num; $i++)  { 
		$yearArr[] = $arraynew->years[$i]->year;/*******Code to get year*******/ 
	 } 
	 foreach($yearArr as $index => $year)  { ?>
			<?php echo $year;/*******Code to get year*******/ ?>
	<?php } }
	 /*$myobj = file_get_contents('https://api.edmunds.com/api/vehicle/v2/vins/1G6AF5SX6D0125409/?fmt=json&api_key=pzuapzj3seygzqg6p6t6exrs');
	$arraynew = json_decode($myobj);
    echo "<pre>";
	print_r($arraynew);
	echo "</pre>";
	
	echo "<pre>";
	echo 'Make: '.$arraynew->make->name.'<br>';
	echo 'Year: '.$arraynew->years[0]->year.'<br>';
	echo 'Model: '.$arraynew->model->name.'<br>';
	echo 'Vin: '.$arraynew->vin.'<br>';
	echo 'Trim: '.$arraynew->years[0]->styles[0]->trim.'<br>';


	echo "</pre>";*/ ?>
    
    
    <?php	$myobj= file_get_contents('https://api.edmunds.com/api/vehicle/v2/makes?state=new&fmt=json&api_key=c8ektqg3jrxzyd73duwm74ne&state=new&view=full');
	$arraynew = json_decode($myobj);
	$num = count($arraynew->makes);/***It counts array elements for loop***/ 
	echo "<pre>";
	//print_r($arraynew);
	echo "</pre>";
get_footer(); ?>








