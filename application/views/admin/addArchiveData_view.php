<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Climate Portal For Bangladesh- Admin Panel : Add Archive Data</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/css/style.css" />
</head>
<body>

<div id="container">
<div id="header">
	<h1>CLIMATE PORTAL FOR BANGLADESH</h1>
	</div>
	
	<div id="nav">
	<a href= <?php echo base_url(); ?>>Home</a>
	|
	<a href= <?php echo base_url()."index.php/admin/admin_panel"; ?>>Admin Panel</a>
	|
	<a href= <?php echo base_url()."index.php/admin/addstation"; ?>>Add Stations</a>
	|
	<a href= <?php echo base_url()."index.php/admin/addArchiveData"; ?>>Add Archive Data</a>
	</div>
	

	<div id="body">
    ADD ARCHIVE DATA
<?php

/*
 
sid INTEGER,
date DATE,
mintemp INTEGER,
maxtemp INTEGER,
rainfall INTEGER,
eid INTEGER,
 */
        /*options for division drop down*/
		
		//print_r($stations);
		
		//$options['a']='A';
		
		foreach($stations as $station)
		{
			//echo $station->name;
			//$options['a']='A';
			$options[$station->name] = $station->name;
		}
		
        /*$options = array(
                  'dhaka'  => 'Dhaka',
                  'khulna'    => 'Khulna',
                  'rajshahi'   => 'Rajshahi',
                  'rangpur'  => 'Rangpur',
                  'barisal'    => 'Barisal',
                  'chittagong'   => 'Chittagong',
                  'sylhet' => 'Sylhet',
                );
		*/

        echo validation_errors();

        echo  '------------------------<br/>';

        $name = set_value('name');
        echo form_open('admin/addArchiveData/submit');
        //echo 'Name '. form_input('stationName',$name).'<br/>';
        echo 'Station '.form_dropdown('station', $options, 'dhaka').'<br/>';
        echo 'Date (yyyy-mm-dd)'.form_input('date', '2011-12-01').'<br/>';
        echo 'Minimum Temp : '. form_input('mintemp','21').'<br/>';
		echo 'Maximum Temp : '. form_input('maxtemp','23').'<br/>';
		echo 'Rainfall : '. form_input('rainfall','33').'<br/>';
		echo form_submit('mysubmit', 'Submit Data !!').'<br/>';
        echo form_close();
?>
        </div>

	<div id="footer">
	CLIMATE PORTAL FOR BANGLADESH 2011.
	</div>
</div>

</body>
</html>