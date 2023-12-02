<?php
include_once('config.php');
$sql = 'SELECT ID, Code, Title FROM tblqueue order by ID asc';
$result = mysqli_query($conn, $sql);  
$fisrtRow =mysqli_fetch_assoc($result);
$reset = mysqli_data_seek($result,0); //reset the pointer
?>
<!DOCTYPE html>
<html>
<head>
		 <title>Karaoke</title>
<link rel="stylesheet" href="style.css">
</head>
<body>



<div class="container">
		<h1>Karaoke</h1><br><br>
		<a href="http://localhost/YoutubeAPI/list.php" target="_blank">Songbook</a>
	
		<form id="start" action="index.php" method="POST">
			<input type="submit" value="Refresh Queue" name="submit">
		</form>

	

		<?php

		function searchFirstRow() {
			// Database connection details
			include("config.php");

			// SQL query to select the first row from the table
			$fisrtRow = $conn->query("SELECT searchCode FROM tblqueue LIMIT 1");

			if ($fisrtRow) {
				$row = $fisrtRow->fetch_assoc();
				if ($row) {
					$searchCode = $row['searchCode'];
					?>
					<!-- The value of the searchcode from the first row on the queue -->
					<form id="youtubeform">
						<input type="hidden" name="searchCode" id="searchCode" value="<?php echo $searchCode?>">
						<input type="submit" id="submit" value="Sing!">
					</form>
					<?php
					
				} else {
					echo "Select Songs Here <a href=\"http://localhost/YoutubeAPI/list.php\" target=\"_blank\">Songbook</a>";
				}
			} else {
				echo "Error: " . $conn->error;
			}

			// Close the connection
			$conn->close();
		}

		if (isset($_POST['submit'])) {
			searchFirstRow();
		}

		?>



</div>
<div id="videos"></div>
<!-- queue table -->
<div id="queue">
	<table >
		<label>Song Queue</label>
		<thread>
			<tr>
				<td>Code</td>
				<td>Title</td>
				<td></td>
			</tr>
		</thread>
		<?php
		while ($row = mysqli_fetch_array($result)) {
			echo '<tr>
			<td>'.$row["Code"].'</td>
			<td>'.$row["Title"].'</td>'.
			'<td><a href="index.php?del='.$row["ID"].'">Del</a></td>'
			.'<tr>';
			
		}
		?>
	</table>
<!-- delete queue here -->
	<form method="post" action="index.php">
    <input type="submit" name="btnDelAll" value="Delete All from Queue">
	</form>
	<?php
	function deleteall(){
		// Database connection details
		include("config.php");

		// SQL query to delete all records from the table
		$deletesql = "DELETE FROM tblqueue";

		if ($conn->query($deletesql) === TRUE) {
			?>
			<script> alert("All Deleted"); </script>
			<?php
			header("Location: index.php");
		} else {
			echo "Error deleting records: " . $conn->error;
		}

		// Close the connection
		$conn->close();
	}

	if(isset($_POST['btnDelAll'])){
		deleteall();
	}

	if(isset($_GET['del']))
	{
		$delID = htmlspecialchars($_GET['del']);
		$delete_single = "DELETE FROM tblqueue WHERE ID = $delID";

		if( ! $conn->query($delete_single))
		{
			echo $conn->error;
		}
		else
		{
			header("Location: index.php");
		}
	}
	?>

</div>
<!-- Scoreboard -->
<div id="score">ScoreBoard</div>
<!-- hiddenfields -->
<div> 
	<!-- VideoID -->
	<input type="hidden" id="videoID" placeholder="videoID" >
	<!-- duratiom -->
	<input type="hidden" id="min" placeholder="minutes">
	<input type="hidden" id="sec" placeholder="seconds">
	
    <input type="hidden" id="time" name="time" placeholder="Timer">


	<!-- if the value of timer becomes 0 -->
	

</div>


</body>
<!-- google cdn -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript" src="script.js"></script>


</html>
