<?php
    $SERVER_NAME = "localhost";
    $USER_NAME = "root"; //TODO
	$PASSWORD = "!vsruser!";  //TODO
	$DATABASE_NAME = "...-svs"; //TODO
        
    // Create connection
    $conn = new mysqli($SERVER_NAME, $USER_NAME, $PASSWORD, $DATABASE_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
	
	
	// Execute query 
        $sql = ""; //TODO

        $result = $conn->query($sql);
        $error = mysqli_error($conn);

        // Store results
        while($row = $result->fetch_assoc()) {
         	$data[] = $row;
        }		
?>
<html>
<head>
</head>
<body>
<?php if(!empty($error))
	echo "<p style='color:red'>$error</p>";
?>
<p>Please enter the name:</p>
<form action="<?=$_SERVER['PHP_SELF']?>" method="GET">
<input type="input" name="name" value="" />
<br/>
<input type="submit" name="sendbtn" value="Send" />
</form>
<?php
	if(!empty($data)) {
		echo "<h1>Persons:</h1><table border='1'><tr><th>Id</th><th>Firstname</th><th>Age</th></tr>";
		foreach($data as $row) {
			echo "<tr><td>".$row["id"]."</td>";
			echo "<td>".$row["name"]."</td>";
			echo "<td>".$row["age"]."</td></tr>";
		}
		echo "</table>";
	}
	else
		echo "No data available";

        echo '(Query: '.$sql.')';      
?>
</body>
</html>