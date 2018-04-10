<?php 

require 'user.php';
$iac7 = new User("sql1.njit.edu", "iac7", "curtsey94", "iac7");

$iac7->returnData();
		echo "<br>";
		echo "<h1>My data</h1><br>";
$iac7->display();
				echo "<br>";
$iac7->insert();
				echo "<br>";
$iac7->delete();
				echo "<br>";
$iac7->update();

?>