<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Climate Portal For Bangladesh- Admin Panel</title>
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
	<a href= <?php echo base_url()."index.php/admin/addstation"; ?>>ADD Stations</a>
	|
	<a href= <?php echo base_url()."index.php/admin/addArchiveData"; ?>>Add Archive Data</a>
	</div>

	<div id="body">
	
	<?php
	//echo base_url()."application/images/btn1.jpg";	
	//<link type="text/css" href="<?= base_url() .APPPATH css/ss_bets.css" rel="stylesheet" />  
	
	//<img src='<?php base_url()."images/btn1.jpg";'/>
	
	/*echo base_url()."images/btn1.jpg";*/
	/*<img src='http://localhost/cpb/images/btn1.jpg' />*/
	?>
	


        <!--<a href= <?php echo base_url()."index.php/admin/addforecast"; ?>>ADD FORECAST</a>-->
        <br/>
        <a href= <?php echo base_url()."index.php/admin/addstation"; ?>>ADD Stations</a>
		<br/>
        <a href= <?php echo base_url()."index.php/admin/addArchiveData"; ?>><img alt="Add Archive Data"  src="<?php echo base_url();?>/images/btn1.jpg" height="100" width="100"/></a>

        </div>

	<div id="footer">
	CLIMATE PORTAL FOR BANGLADESH 2011.
	</div>
</div>

</body>
</html>