<?php 
class User {
	var $hostname;
	var $username;
	var $password;
	var $dbname;
	var $conn;

	function __construct($hostname, $username, $password, $dbname) {
		$this->hostname = $hostname;
		$this->username = $username;
		$this->password = $password;
		$this->dbname = $dbname;
		try {
    		$this->conn = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    		echo "Connected successfully\n"; 
		} catch(PDOException $e) {		
			// echo "Connection failed: " . $e->getMessage();
			http_error("500 Internal Server Error\n\n"."There was a SQL error:\n\n" . $e->getMessage());
		}
	}
	function runQuery($query) {
	    try {
			$q = $this->conn->prepare($query);
			$q->execute();
			$results = $q->fetchAll();
			$q->closeCursor();
			return $results;	
		} catch (PDOException $e) {
				http_error("500 Internal Server Error\n\n"."There was a SQL error:\n\n" . $e->getMessage());
		}	  
	}
	function http_error($message) {
		header("Content-type: text/plain");
		die($message);
	}
	function returnData() {
		echo "<br>Host: " . $this->hostname . "<br>";
		echo "Username: " . $this->username . "<br>";
		echo "Password:" . $this->password . "<br>";
		echo "Database: " . $this->dbname . "<br>";
	}
	function display() {
		$sql = 'select * from accounts';
		$results = $this->runQuery($sql);
		$this->makeTable($results);
	}	
	function insert() {
		echo "<h2>Inserting Data into the database</h2>";
		$sql = "insert into accounts (
					email,
					fname,
					lname,
					phone,
					birthday,
					gender,
					password) 
					values 
					('Week_10@homework.com',
					'Week',
					'Ten',
					'973-867-5309',
					2018-05-01,
					'male',
					'password1');";
		$results = $this->runQuery($sql);
		$sql = "insert into accounts (
					email,
					fname,
					lname,
					phone,
					birthday,
					gender,
					password) 
					values 
					('John@john',
					'Doe',
					'Doe',
					'973-555-5555',
					2018-04-01,
					'male',
					'password2');";
		$results = $this->runQuery($sql);
		$sql = "insert into accounts (
					email,
					fname,
					lname,
					phone,
					birthday,
					gender,
					password) 
					values 
					('James@James',
					'James',
					'James',
					'111-111-1111',
					2018-04-01,
					'dfdf',
					'password3');";
		$results = $this->runQuery($sql);
		$this->makeTable($results);
		$this->display();
	}
	function delete() {
		echo "<h2>Deleting users with the last name of 'James'</h2>";
		$sql = "delete from accounts where lname = 'James';";
		$results = $this->runQuery($sql);
		$this->makeTable($results);
		$this->display();
	}
	function update() {
		echo "<h2>Updating password to 'random password' if first name is 'James'</h2>";
		$sql = "update accounts
			set password = 'random password'
			where fname = 'James';";
		$results = $this->runQuery($sql);
		$this->makeTable($results);
		$this->display();
	}
	function makeTable($results) {
		if(count($results) > 0) {
			echo "<table border=\"1\">
		<tr>
			<th>ID</th>
			<th>Email</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Phone #</th>
			<th>Birthday</th>
			<th>Gender</th>
			<th>Pass</th>
		</tr>";
			foreach ($results as $row) {
				echo "<tr>
				<td>".$row["id"]."</td>
				<td>".$row["email"]."</td>
				<td>".$row["fname"]."</td>
				<td>".$row["lname"]."</td>
				<td>".$row["phone"]."</td>
				<td>".$row["birthday"]."</td>
				<td>".$row["gender"]."</td>
				<td>".$row["password"]."</td>
					</tr>";
			}
			echo "</table>";
		} else {
    		echo '0 results';
		}
	}
}
?>