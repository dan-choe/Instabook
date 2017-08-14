<?php
include ("./include.php");

if(! $_SESSION[user_id]){
    ?>
    <script>
        <!-- alert("Must be logged in as a user!"); -->
        <!--   history.back(); -->
    </script>
    <?
}


if($_SESSION[user_id]){
    ?>

	 <h2>Hello <?php echo $_SESSION[user_name]?>! Here are your joined groups. Click the name of group where you want to visit.</h2>

    <?php
} else {
	echo "no user";
}
?>

<div>

	<div id="head_account"> </div>
	
	<div>
		<form action="instab_personalp.php" method="post">
		
		<table class="postTable">
		<tr>
		<th>No.</th>
		<th>The owner of the group</th>
		<th>Name of Group</th>	
		<th>Joined Date</th>
		<th>Group Type</th>
		</tr>
		<?
		// load joined groups
		$query = "SELECT * FROM GroupMembership WHERE User=" . $_SESSION[user_idx]; //ORDER BY Id DESC
		$result = sql_query($query);
		
		$numrow = 0;
		// IBGroup  JoinDate
		while ($row = mysqli_fetch_array($result)) {
			$numrow = $numrow + 1;
			
			echo "<tr><td colspan='6' style='height:20px; border-bottom:2px solid #000;'></td></tr><tr>";
			echo "<td>$numrow</td>";
			
			$groupinfo = sql_query("SELECT * FROM IBGroup WHERE Id=". $row[IBGroup]);
			$groupinfo = mysqli_fetch_array($groupinfo);
			
			$ownerinfo = sql_query("SELECT * FROM User WHERE AccountNumber=". $groupinfo[Owner]);
			$ownerinfo = mysqli_fetch_array($ownerinfo);
			
			echo "<td>$ownerinfo[UserID]</td>";		//Owner name of Group
			
			echo "<td><a href='/group.php?g_id=$row[IBGroup]'>$groupinfo[Name]</a></td>";			//Name of Group
			
			echo "<td>$row[JoinDate]</td>";			//Joined Date
			
			echo "<td>$groupinfo[Type]</td>";			//Group Type
			
		
			echo "</tr>";
			
		}
		
		echo "</table>";
		
		
		?>
	</div>

</div>
