<?php ob_start();
/**
 * Template Name: Vin Page
 */
get_header(); ?>
<section>
    <div class="container">
        <div class="row">
        	<div class="sectionheading">
                <h2> Car Details </h2>
                <p class="subheading">Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
            </div>
            <?php if(isset($_REQUEST['goVin']))
            {
                $vin = $_REQUEST['vin'];	
                $myobj = @file_get_contents('https://api.edmunds.com/api/vehicle/v2/vins/'.$vin.'/?fmt=json&api_key=pzuapzj3seygzqg6p6t6exrs');
				if(!$myobj) { echo "You have entered wrong Vin Number "; }
				else
				{
					$arraynew = json_decode($myobj);
					echo 'Make: '.$arraynew->make->name.'<br>';
					echo 'Year: '.$arraynew->years[0]->year.'<br>';
					echo 'Model: '.$arraynew->model->name.'<br>';
					echo 'Vin: '.$arraynew->vin.'<br>';
					echo 'Trim: '.$arraynew->years[0]->styles[0]->trim.'<br>';
				}
            } 
            else
            {
                header("location: http://www.keylessoption.com/");
            }?>
        </div>
    </div>
</section>
<?php get_footer(); ?>