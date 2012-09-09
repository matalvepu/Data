<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Climate Portal For Bangladesh- Admin Panel : Login</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/css/style.css" />
</head>
<body>

<div id="container">
	<div id="header">
            <h1>CLIMATE PORTAL FOR BANGLADESH</h1>
	</div>

        <div id="nav">
            <?php echo anchor(base_url(),'HOME'); ?>
        </div>

	<div id="body">

        LOGIN
        <?php
        echo form_open('admin/login/validate');
        echo form_input('username','Azad');
        echo form_password('password','Password');
        echo form_submit('submit','Login');
        echo form_close();
        ?>

        </div>

	<p class="footer"></p>
</div>

</body>
</html>