<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Climate Portal For Bangladesh- Admin Panel : Add Station</title>
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
	<a href= <?php echo base_url()."index.php/admin/addstation"; ?>>ADD Stations</a>
	|
	<a href= <?php echo base_url()."index.php/admin/addArchiveData"; ?>>Add Archive Data</a>
	</div>
	<div id="body">
      ADD STATION DATA<br/><br/><br/>
<?php


        /*options for division drop down*/
        $options = array(
                  'dhaka'  => 'Dhaka',
                  'khulna'    => 'Khulna',
                  'rajshahi'   => 'Rajshahi',
                  'rangpur'  => 'Rangpur',
                  'barisal'    => 'Barisal',
                  'chittagong'   => 'Chittagong',
                  'sylhet' => 'Sylhet',
                );


        echo validation_errors();

        echo  '------------------------<br/>';

        $name = set_value('name');
        echo form_open('admin/addstation/submit');
        echo 'Name '. form_input('stationName',$name).'<br/>';
        echo 'Division '.form_dropdown('division', $options, 'dhaka').'<br/>';
        echo 'Building Date (yyyy-mm-dd)'.form_input('builtdate', '1970-01-01').'<br/>';
        echo 'Latitude and Longitude of the station (+ for N Lat or E Long     - for S Lat or W Long)<br/>';
        echo 'Latitude '. form_input('lat', '');
        echo '  Longitude '. form_input('long', '').'<br/>';
        echo form_label('Is the station still operational?   ', 'working').'Yes';
        echo form_radio('working', 'yes', TRUE).' No ';
        echo form_radio('working', 'no').'<br/>';
        echo form_submit('mysubmit', 'Submit Station Info!').'<br/>';
        echo form_close();
?>
        </div>

	<div id="footer">
	CLIMATE PORTAL FOR BANGLADESH 2011.
	</div>
</div>

</body>
</html>