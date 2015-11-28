<?php
/**
 * Template Name: GET YEAR
 */

$except = array("Lamborghini", "Ferrari", "Tesla", "Aston Martin", "Alfa Romeo", "Bentley", "McLaren", "Lotus", "Rolls-Royce");

if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'getMakes')
{
	$myobj= file_get_contents('https://api.edmunds.com/api/vehicle/v2/makes?state=new&fmt=json&api_key=c8ektqg3jrxzyd73duwm74ne&state=new&view=full');
	$arraynew = json_decode($myobj);
	$num = count($arraynew->makes);/***It counts array elements for loop***/ 
	//echo $num;
	?>
	<select id="_text_field1">
    <option value="">--Select Make--</option>
	<?php for($i = 0; $i < $num; $i++)  {
		if (in_array(trim($arraynew->models[$i]->name), $except) == FALSE) { ?>
		<option value="<?php echo $arraynew->makes[$i]->niceName; ?>" ><?php echo $arraynew->makes[$i]->name; ?></option>
	<?php }	} ?>
    </select>
<?php }
/******************************************************************
				Code to get model according to make
******************************************************************/
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'getModel')
{
	$make = $_REQUEST['make'];
	$year = $_REQUEST['year'];
	$myobj= file_get_contents('https://api.edmunds.com/api/vehicle/v2/'.$make.'/models?fmt=json&api_key=pzuapzj3seygzqg6p6t6exrs');
	$arraynew = json_decode($myobj);
	$num = count($arraynew->models);/***It counts array elements for loop***/ 
	?>
	<select id="_text_field2">
    <option value="">--Select Model--</option>
	<?php for($i = 0; $i < $num; $i++)  { ?>
		<option value="<?php echo $arraynew->models[$i]->niceName; ?>" ><?php echo trim($arraynew->models[$i]->name);?></option>
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
	$myobj = file_get_contents('http://api.edmunds.com/api/vehicle/v2/'.$make.'/'.$model.'/years?fmt=json&api_key=pzuapzj3seygzqg6p6t6exrs');
	$arraynew = json_decode($myobj);
	$num = count($arraynew->years);/***It counts array elements for loop***/ 
	echo $num;
	for($i = 0; $i < $num; $i++)  { 
		$yearArr[] = $arraynew->years[$i]->year;/*******Code to get year*******/ 
	 } 
	  ?>
	<select id="_textarea3" size="10">
    <option value="">--Select Year--</option>
	<?php foreach($yearArr as $index => $year)  { ?>
		<option value="<?php echo $year;?>" ><?php echo trim($year);?></option>
	<?php } ?>
    </select>
   <?php } 
