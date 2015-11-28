<?php
$year   = array("2015","2016","2017","2018");
				if(!empty($year))
				{
 $myobj1= file_get_contents('https://api.edmunds.com/api/vehicle/v2/makes?state=new&fmt=json&api_key=c8ektqg3jrxzyd73duwm74ne&state=new&view=full');
	$arraynew = json_decode($myobj1);
	//print_r($arraynew);
	$i=0;
				while($arraynew)
				{
		
				 print_r($x1=$arraynew->makes[$i]->name);
				 echo"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					if($i==4)
					{echo "<br>"; }
					if($i==9)
					{echo "<br>"; }
					if($i==14)
					{echo "<br>"; }
					if($i==19)
					{echo "<br>"; }
					if($i==24)
					{echo "<br>"; }
				 
					if($i==29)
					{echo "<br>"; }
					
					if($i==34)
					{echo "<br>"; }
					if($i==39)
					{echo "<br>"; }
				 $i++;
				 foreach( $x1 as $value1 )
				 {
					print_r($value1);
					
				 }
				}
				}
				 
				else{
				echo "None";
				}

				 
?>