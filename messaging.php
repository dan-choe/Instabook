<?php
include ("./include.php");

if(! $_SESSION[user_id]){
    ?>
    <script>
        alert("Must be logged in as a user!");
        history.back();
    </script>
    <?
}


if (isset($_POST[func])) {
//	echo "function!";
	if (strcmp($_POST[func],'delete') == 0) {
		foreach ($_POST[msg] as $msgID) {
			sql_query("DELETE FROM SendReceive WHERE MessageId=$msgID LIMIT 1");
			sql_query("DELETE FROM Message WHERE Id=$msgID LIMIT 1");
		}
	} else if (strcmp($_POST[func],'send') == 0) {
		$rxID = $_POST[receiver];
		$sndID = $_SESSION[user_idx];
		$content = mysqli_real_escape_string($connect, $_POST[message]);
		$subject = mysqli_real_escape_string($connect, $_POST[subject]);

//		echo "RX: $rxID <br>SND: $sndID <br>Message: $content <br>Sub: $subject";

		sql_query("INSERT INTO Message(Subject, Content) VALUES('$subject', '$content')");

		//this is the dicey part.  It would be better if they were all in one table.
		$messageID = sql_query("SELECT Id FROM Message WHERE Subject='$subject' AND Content='$content' ORDER BY Id DESC LIMIT 1");
		$messageID = mysqli_fetch_array($messageID);
		$messageID = $messageID[Id];

		sql_query("INSERT INTO SendReceive(MessageId, SenderId, ReceiverId) VALUES('$messageID', '$sndID', '$rxID')");

	}

}



if($_SESSION[user_id]){
    ?>

	 <h2>Hello <?php echo $_SESSION[user_name]?>! Here are your messages:</h2>

    <?php
} else {
	echo "no user";
}
?>

<!--
	Need a table.  3 columns, sender, subject, message. (and a delete) (and time sent?)
-->

<form action="messaging.php" method="post">
<input type="hidden" name="func" value="delete">
<table class="niceTable">
<tr>
<th>Delete?</th>
<th>Sender</th>
<th>DateTime</th>
<th>Subject</th>
<th>Message</th>
</tr>
<?
$query = "SELECT * FROM SendReceive WHERE ReceiverId='$_SESSION[user_idx]'";
$result = sql_query($query);

while ($row = mysqli_fetch_array($result)) {

	//scalar variables, how I missed thee
	$sender = sql_query("SELECT UserId from User WHERE AccountNumber=$row[SenderId]");
	$sender = mysqli_fetch_array($sender);
	$sender = $sender[UserId];

	$message = sql_query("SELECT * FROM Message WHERE Id=$row[MessageId]");
	$message = mysqli_fetch_array($message);

	echo "<tr>" .
	"<td><input type='checkbox' name='msg[]' value='$row[MessageId]'></td>" .	//delete
	"<td>$sender</td>" .	//sender
	"<td>$message[TimeSent]</td>" .			//date
	"<td>$message[Subject]</td>" .			//subject
	"<td>$message[Content]</td>" .			//message
	"</tr>";
}

?>
</table>
<input type="submit" value="Delete Selected Messages">
</form>

<!-- New Message.
-->
<h2>Send a Message</h2>
<form action="messaging.php" method="post">
<table>
<tr>
	<td>To:</td>
	<td> <select name="receiver">
	<?
	//make an option for every user. not practical, but should be effective
	$users = sql_query("SELECT UserID, AccountNumber FROM User ORDER BY UserID ASC");
	while ($u = mysqli_fetch_array($users)) {
		echo "<option value='$u[AccountNumber]'>$u[UserID]</option>";
	}
	?>
	</select></td>

	<td>Subject:</td>
	<td><input type='text' name='subject'>
	</td>
</tr>
<tr>
	<td colspan=4>
	Message:<br>
	<textarea rows='4' cols='80' name='message'></textarea>
	</td>
</tr>
</table>
<input type="hidden" name="func" value="send">
<input type="submit" value="Send Message">
</form>
