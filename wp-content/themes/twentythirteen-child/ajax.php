<?php $link = mysql_connect('localhost', 'keyLessUser', 'Te0]%6.Qh_X0');
	mysql_select_db('db_keyLessOption', $link);
	header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
$action = $_REQUEST['action'];
/******************Code to get model accordin to make******************/
if($action == 'getModel' && isset($_REQUEST['make']))
{
	$make = $_REQUEST['make'];
	
	$myobj= file_get_contents('https://api.edmunds.com/api/vehicle/v2/'.$make.'/models?fmt=json&api_key=pzuapzj3seygzqg6p6t6exrs');
	$arraynew = json_decode($myobj);
	$num = count($arraynew->models);/***It counts array elements for loop***/ 
	?>
    <option value="">--Select Model--</option>
	<?php for($i = 0; $i < $num; $i++)  { ?>
		<option value="<?php echo $arraynew->models[$i]->niceName; ?>"><?php echo trim($arraynew->models[$i]->name);?></option>
	 <?php }
	 } 


/******************Code to get year accordin to make******************/
if($action == 'getYear' && isset($_REQUEST['yearMake']) && isset($_REQUEST['yearModel']))
{
		$make = $_REQUEST['yearMake'];
	$model = $_REQUEST['yearModel'];
	$myobj = file_get_contents('http://api.edmunds.com/api/vehicle/v2/'.$make.'/'.$model.'/years?fmt=json&api_key=pzuapzj3seygzqg6p6t6exrs');
	$arraynew = json_decode($myobj);
	$num = count($arraynew->years);/***It counts array elements for loop***/ 
	for($i = 0; $i < $num; $i++)  { 
		$yearArr[] = $arraynew->years[$i]->year;/*******Code to get year*******/ 
	 } 
	  ?>
    <option value="">--Select Year--</option>
	<?php foreach($yearArr as $index => $year)  { ?>
		<option value="<?php echo $year;?>" ><?php echo trim($year);?></option>
	<?php } ?>
   <?php 
} 
/*********************************Code to select product************************************/
if($action == 'selectProduct' && isset($_REQUEST['productMake']) && isset($_REQUEST['productYear']) && isset($_REQUEST['productModel']))
{
	$sql =  mysql_query("SELECT * FROM auto_automodels WHERE make = '".$_REQUEST['productMake']."' AND carYear = '".$_REQUEST['productYear']."' AND model LIKE  '%".$_REQUEST['productModel']."%' GROUP BY product_id" ); 	?>
	<?php while($data = mysql_fetch_array($sql)) { 
		echo $data['product_id'].",";
	 }	
} 
/************************************************Delete product make modeal and year from database*********************************/
if($action == 'deleteModels' && isset($_REQUEST['id']))
{
	$sql =  mysql_query("DELETE FROM auto_automodels WHERE id = ".$_REQUEST['id']."" );  
	if($sql)
	{
		echo "Data Deleted";
	}
	else
	{
		mysql_error();
	}
} 
/*********************************************Add product make model and year in database*********************************************/
if($action == 'addModels')
{
	$make = $_REQUEST['addMake'];
	$model = $_REQUEST['addModel'];
	$ProductId = $_REQUEST['productId'];
	$years = $_REQUEST['addYear'];
	$yearArray = explode(",",$years);
	$yearNum = count($year);
	foreach($yearArray as $year)
	{
		$checkData = mysql_query("select id from auto_automodels where product_id = '$ProductId' and make = '$make' and carYear = '$year' and model = '$model'");
		$arr = mysql_fetch_array($checkData); $dataExist = $arr['id']; 
		if($dataExist == '')
		{
			$addQuery = mysql_query("INSERT INTO auto_automodels VALUES ('', '$ProductId', '$make', '$year', '$model')");
		}
	}
	if($addQuery)
	{
		echo "Data Entered";
	}
}
/*********************Code to get data****************************/
if($action == 'getModelData')
{
	$sql1 = mysql_query("select * from auto_automodels where product_id ='".$_REQUEST['post']."' ORDER BY make");	
echo "<table>
		<tr>
			<th>Make</th>
			<th>Model</th>
			<th>Year</th>
		</tr>";
		$postId = mysql_fetch_array($sql1);
		echo "<div class='postId' style='display:none;'>".$postId['product_id']."</div>";
while($arr = mysql_fetch_array($sql1))
{
		echo "<tr>
			<td>".$arr['make']."</td>
			<td>".$arr['model']."</td>
			<td>".$arr['year']."</td>
			<td class='delete' id=".$arr['id']." onclick='return deleteData(".$arr['id']."); '>Delete</td>
		</tr>";
	
}
 echo "</table>";
}
/********************Code to show makes in menu*******************************/
if($action == 'getModelForMenu')
{
	$myobj= file_get_contents('https://api.edmunds.com/api/vehicle/v2/makes?state=new&fmt=json&api_key=c8ektqg3jrxzyd73duwm74ne&state=new&view=full');
				$arraynew = json_decode($myobj);
				$num = count($arraynew->makes);/***It counts array elements for loop***/  
                        $a=1; 
						echo '<ul class="dropdown-menu mega-dropdown-menu row">';
						for($i = 0; $i < $num; $i++)  { 
						if($arraynew->makes[$i]->name !='' )
							{
								if($a==1 || $a == (($a-1)%10==0))
								{
									echo "<li class='col-sm-2'><ul>";
								}
                             	echo "<li><a href='#' class='".trim($arraynew->makes[$i]->name)."' onClick='getValue(\"".trim($arraynew->makes[$i]->name)."\")'>".trim($arraynew->makes[$i]->name)."</a></li>"; 
								$a++;
								if($a==1 || $a == (($a-1)%10==0))
								{
									echo "</ul></li>";
								}
							}
                         } 
						 echo "</ul>";
}
/****************************************************/
if($action == 'getDatabyMakesMenu')
{
	$sql1 = mysql_query("select * from auto_automodels WHERE make = '".$_REQUEST['makeMenu']."' group by product_id");	
	 while($data = mysql_fetch_array($sql1)) { 
		echo $data['product_id'].",";
	 }	
}