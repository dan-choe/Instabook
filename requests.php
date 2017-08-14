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
// Yes, I know, I didn't really get much working with it yet.  just a quick outline while I'm thinking about it.
// nat

//need quite a few functions
// send friend request
// accept friend request
// unfriend

//these are only for the group owner
//send group request
//accept group join request
//boot someone out of a group

//do we need to be able to create a new group? if so, here is not a bad place for it.
//yes, we need to do that too.
//so, a mess of 8 functions

if (isset($_POST[func])) {
//	echo "function!";
	if (strcmp($_POST[func],'faccept') == 0) {	//Waiting Friend Requests
		foreach ($_POST[freq] as $fId) {	//because could be multiple request
			//we want to accept a friend request
			sql_query("INSERT INTO Friends(UserA, UserB) VALUES('$_SESSION[user_idx]', '$fId')");
			sql_query("INSERT INTO Friends(UserB, UserA) VALUES('$_SESSION[user_idx]', '$fId')");
			//that means add them to the friends table (both pairs)
						
			//and delete the request
			sql_query("DELETE FROM FriendRequest WHERE Sender='$fId' AND Recipient='$_SESSION[user_idx]' LIMIT 1");
		}
		
	} else if (strcmp($_POST[func],'frequest') == 0) {	//send a new friend request
		sql_query("INSERT INTO FriendRequest(Sender, Recipient) VALUES('$_SESSION[user_idx]', '$_POST[receiver]')");
		
	} else if (strcmp($_POST[func],'fdelete') == 0) {	//delete a friendship
		foreach ($_POST[fdel] as $fId) {	//multiple possible
			//delete both ways
			sql_query("DELETE FROM Friends WHERE UserA='$_SESSION[user_idx]' AND UserB='$fId' LIMIT 1");
			sql_query("DELETE FROM Friends WHERE UserB='$_SESSION[user_idx]' AND UserA='$fId' LIMIT 1");
		}
		
	} else if (strcmp($_POST[func],'fsreq') == 0) {	//delete pending send requests
		foreach ($_POST[freq] as $fId) {
			sql_query("DELETE FROM FriendRequest WHERE Recipient='$fId' AND Sender='$_SESSION[user_idx]' LIMIT 1");
		}
		
	} else if (strcmp($_POST[func],'gaccept') == 0) {	//accept a join group request
		foreach ($_POST[greq] as $gId) {
			//add to group membership
			sql_query("INSERT INTO GroupMembership(User, IBGroup) VALUES('$_SESSION[user_idx]', '$gId')");

			//delete request
			sql_query("DELETE FROM GroupRequest WHERE GroupId='$gId' AND UserId='$_SESSION[user_idx]' LIMIT 1");
		}
		
	} else if (strcmp($_POST[func],'gsreq') == 0) {	//Rescind sent group join request
		foreach ($_POST[greq] as $gId) {
			//delete request
			sql_query("DELETE FROM GroupRequest WHERE GroupId='$gId' AND UserId='$_SESSION[user_idx]' AND WhoRequested='USER' LIMIT 1");
		}	
		
	} else if (strcmp($_POST[func],'gleave') == 0) {	//Leave a group
		foreach ($_POST[glev] as $gId) {
			//delete request
			sql_query("DELETE FROM GroupMembership WHERE IBGroup='$gId' AND User='$_SESSION[user_idx]' LIMIT 1");
		}	
		
	} else if (strcmp($_POST[func],'gsend') == 0) {	//send a request to join a group
		foreach ($_POST[grequest] as $gId) {
			//request
			sql_query("INSERT INTO GroupRequest(GroupId, UserId, WhoRequested) VALUES('$gId', '$_SESSION[user_idx]', 'USER')");
		}	
		
	} else if (strcmp($_POST[func],'gcreate') == 0) {	//create a new group
		$gn = mysqli_real_escape_string($connect, $_POST[gname]);	//group name
		$gt = mysqli_real_escape_string($connect, $_POST[gtype]);	//group type
		sql_query("INSERT INTO IBGroup(Name, Type, Owner) VALUES('$gn', '$gt', '$_SESSION[user_idx]')");
		
	} else if (strcmp($_POST[func],'gmanagement') == 0) {	//group you own, management.  a doozy for sure.
		//need to check for selected checkboxes... if we're doing anything.
		$groupnum = $_POST[group];
		
		//delete group
		if(isset($_POST[deletegroup])) {
			sql_query("DELETE FROM IBGroup WHERE Id='$groupnum' LIMIT 1");
			//probably also want to delete  group requests and members that involve this group.
			sql_query("DELETE FROM GroupRequest WHERE GroupId='$groupnum'");
			sql_query("DELETE FROM GroupMembership WHERE IBGroup='$groupnum'");
		} else {
		
			//rename group
			if(isset($_POST[renamegroup])) {
				$nn = mysqli_real_escape_string($connect, $_POST[gnname]);	//new name, and group new name.
				sql_query("UPDATE IBGroup SET Name ='$nn' WHERE Id='$groupnum' LIMIT 1");
			}
			
			//remove user[s] from group
			foreach ($_POST[deluser] as $duser) {
				sql_query("DELETE FROM GroupMembership WHERE IBGroup='$groupnum' AND User='$duser' LIMIT 1");
			}
			
			//accept group requests from users to join the group
			foreach ($_POST[adduser] as $auser) {
				sql_query("DELETE FROM GroupRequest WHERE GroupId='$groupnum' AND UserId='$auser' LIMIT 1");
				sql_query("INSERT INTO GroupMembership(User, IBGroup) VALUES('$auser', '$groupnum')");
			}
			
			//Rescind offers to people that haven't accepted
			foreach ($_POST[recuser] as $ruser) {
				sql_query("DELETE FROM GroupRequest WHERE GroupId='$groupnum' AND UserId='$ruser' LIMIT 1");

			}
			
			//send a new group request to someone.
			if (isset($_POST[sendrequest])) {
				sql_query("INSERT INTO GroupRequest(GroupId, UserId, WhoRequested) VALUES('$groupnum', '$_POST[rxr]', 'OWNER')");
			}
		
		}
	}
}



if($_SESSION[user_id]){
    ?>

	 <h2>Hello <?php echo $_SESSION[user_name]?>! Friend and Group Requests:</h2>

    <?php
} else {
	echo "no user";
}
?>

<!--
	Need a table. lots of tables.
	Table for each of those 7-8 items.
-->
<h3>Waiting Friend Requests</h3>
<form action="requests.php" method="post">
<input type="hidden" name="func" value="faccept">
<table class="niceTable">
<tr>
<th>Accept?</th>
<th>Sender</th>
<th>DateTime</th>
</tr>
<?

$query = "SELECT * FROM FriendRequest WHERE Recipient='$_SESSION[user_idx]'";
$result = sql_query($query);

while ($row = mysqli_fetch_array($result)) {

	//scalar variables, how I missed thee
	$sender = sql_query("SELECT UserId from User WHERE AccountNumber=$row[Sender]");
	$sender = mysqli_fetch_array($sender);
	$sender = $sender[UserId];

	echo "<tr>" .
	"<td><input type='checkbox' name='freq[]' value='$row[Sender]'></td>" .	//accept
	"<td>$sender</td>" .	//sender
	"<td>$row[RequestDate]</td>" .			//date
	"</tr>";
}

?>
</table>
<input type="submit" value="Accept selected friend requests">
</form>

<!-- Send a new friend request
-->
<h3>Send a friend request</h3>
<form action="requests.php" method="post">
<input type="hidden" name="func" value="frequest">
To:
<select name="receiver">
	<?
	//make an option for every user. not practical.												TODO:
	//Get a list of Users you have a current friend request pending								SET UP FANCY SQL QUERY
	//and a list of users you are already friends with
	//so only the "leftover users"
	$users = sql_query("SELECT UserID, AccountNumber FROM User " .
						"WHERE AccountNumber NOT IN (SELECT UserB FROM Friends WHERE UserA='$_SESSION[user_idx]') " .
						"AND AccountNumber NOT IN (SELECT Recipient FROM FriendRequest WHERE Sender='$_SESSION[user_idx]')" .
						"ORDER BY UserID ASC");
	while ($u = mysqli_fetch_array($users)) {
		if ($u[AccountNumber] == $_SESSION[user_idx]) {
			continue;	//don't let them friend themselves
		}
		echo "<option value='$u[AccountNumber]'>$u[UserID]</option>";
	}
	?>
</select>
<input type="submit" value="Send Request">
</form>


<!--
	put a list of current friends.  get friend name, "friends since"
	and a delete friendship button.
-->

<h3>Current Friends</h3>
<form action="requests.php" method="post">
<input type="hidden" name="func" value="fdelete">
<table class="niceTable">
<tr>
<th>Unfriend?</th>
<th>UserName</th>
<th>Real Name</th>
<th>Friends Since</th>
</tr>
<?

$query = "SELECT * FROM Friends WHERE UserA='$_SESSION[user_idx]'";
$result = sql_query($query);

while ($row = mysqli_fetch_array($result)) {

	//scalar variables, how I missed thee
	$friend = sql_query("SELECT UserId, FirstName, LastName from User WHERE AccountNumber=$row[UserB]");
	$friend = mysqli_fetch_array($friend);
	$realname = "$friend[FirstName] $friend[LastName]";
	$friend = $friend[UserId];

	echo "<tr>" .
	"<td><input type='checkbox' name='fdel[]' value='$row[UserB]'></td>" .	//accept
	"<td>$friend</td>" .	//sender
	"<td>$realname</td>" .	//Real Name
	"<td>$row[FriendsSince]</td>" .			//date
	"</tr>";
}

?>
</table>
<input type="submit" value="UnFriend selected friends">
</form>


<h3>Current Sent Pending Friend Requests</h3>
<form action="requests.php" method="post">
<input type="hidden" name="func" value="fsreq">
<table class="niceTable">
<tr>
<th>Delete?</th>
<th>Recipient</th>
<th>DateTime</th>
</tr>
<?

$query = "SELECT * FROM FriendRequest WHERE Sender='$_SESSION[user_idx]'";
$result = sql_query($query);

while ($row = mysqli_fetch_array($result)) {

	//scalar variables, how I missed thee
	$receiver = sql_query("SELECT UserId from User WHERE AccountNumber=$row[Recipient]");
	$receiver = mysqli_fetch_array($receiver);
	$receiver = $receiver[UserId];

	echo "<tr>" .
	"<td><input type='checkbox' name='freq[]' value='$row[Recipient]'></td>" .	//accept
	"<td>$receiver</td>" .	//sender
	"<td>$row[RequestDate]</td>" .			//date
	"</tr>";
}

?>
</table>
<input type="submit" value="Delete selected sent friend requests">
</form>


<h2>Groups: </h2>

<h3>Current Received Pending Group Join Requests</h3>
<form action="requests.php" method="post">
<input type="hidden" name="func" value="gaccept">
<table class="niceTable">
<tr>
<th>Accept?</th>
<th>Group</th>
<th>DateTime</th>
</tr>
<?

$query = "SELECT * FROM GroupRequest WHERE UserId='$_SESSION[user_idx]' AND WhoRequested='OWNER'";
$result = sql_query($query);

while ($row = mysqli_fetch_array($result)) {

	//scalar variables, how I missed thee
	$group = sql_query("SELECT Name from IBGroup WHERE Id=$row[GroupId]");
	$group = mysqli_fetch_array($group);
	$group = $group[Name];

	echo "<tr>" .
	"<td><input type='checkbox' name='greq[]' value='$row[GroupId]'></td>" .	//accept
	"<td>$group</td>" .	//sender
	"<td>$row[RequestDate]</td>" .			//date
	"</tr>";
}

?>
</table>
<input type="submit" value="Accept selected group requests">
</form>

<h3>Current Sent Pending Group Join Requests</h3>
<form action="requests.php" method="post">
<input type="hidden" name="func" value="gsreq">
<table class="niceTable">
<tr>
<th>Rescind?</th>
<th>Group</th>
<th>DateTime</th>
</tr>
<?

$query = "SELECT * FROM GroupRequest WHERE UserId='$_SESSION[user_idx]' AND WhoRequested='USER'";
$result = sql_query($query);

while ($row = mysqli_fetch_array($result)) {

	//scalar variables, how I missed thee
	$group = sql_query("SELECT Name from IBGroup WHERE Id=$row[GroupId]");
	$group = mysqli_fetch_array($group);
	$group = $group[Name];

	echo "<tr>" .
	"<td><input type='checkbox' name='greq[]' value='$row[GroupId]'></td>" .	//accept
	"<td>$group</td>" .	//sender
	"<td>$row[RequestDate]</td>" .			//date
	"</tr>";
}

?>
</table>
<input type="submit" value="Rescind selected group requests">
</form>


<h3>Groups You're in (but don't own)</h3>
<form action="requests.php" method="post">
<input type="hidden" name="func" value="gleave">
<table class="niceTable">
<tr>
<th>Leave Group?</th>
<th>Group Name</th>	<!-- Group name could become a hyperlink to the group page. -->
<th>Type</th>
<th>Join Date</th>
</tr>
<?

// I should probably also not show groups in this selection that you own, so you can't leave those groups.
//because then they wouldn't have an owner. And that would be bad.


$query = "SELECT * FROM GroupMembership WHERE User='$_SESSION[user_idx]'";
$result = sql_query($query);

while ($row = mysqli_fetch_array($result)) {

	//scalar variables, how I missed thee
	$group = sql_query("SELECT Name, Type, Owner FROM IBGroup WHERE Id=$row[IBGroup]");
	$group = mysqli_fetch_array($group);
	
	$groupowner = $group[Owner];
	
	if ($groupowner == $_SESSION[user_idx]) {
		continue;	//this isn't working. figure it out later.  It might just be a "don't do that" type thing.
	}
	
	$grouptype = $group[Type];
	$group = $group[Name];

	echo "<tr>" .
	"<td><input type='checkbox' name='glev[]' value='$row[IBGroup]'></td>" .	//accept
	"<td>$group</td>" .	//group
	"<td>$grouptype</td>" .
	"<td>$row[JoinDate]</td>" .			//date
	"</tr>";
}

?>
</table>
<input type="submit" value="Leave selected groups">
</form>


<!-- if owner of group, use a table for group management.
	This also includes renaming the group!  This sounds like lots of form data.
	
	and as a bonus, you can't nest forms!  Which means lots of boogers and "state vars"
-->
<h3>My groups (You OWN these)</h3>
<? /*

	Ok, notes time.
	I need a Table.  Then, for each table. display 1 group.
	So we need a foreach <group you own> loop
		For each one:
		A single form.  with gmanage func and groupid set each time
		We need to give option to delete
		need option to add a user (still like the checkbox for adding)
		Then we need to have a way to list users that want to join.
		So that's a foreach <user in grouprequest of this group(from the outer loop)>
			For each user:
			radio button for accept, another for delete, in same pair
			print out username
			print out request date.

	Also, I think cancel and reject might be better terms than delete
*/ ?>

<?
$query = "SELECT * FROM IBGroup WHERE Owner='$_SESSION[user_idx]'";
$allgroups = sql_query($query);

while ($curgroup = mysqli_fetch_array($allgroups)) {
	//cur group is the "per group"
	//need a form per group
?>
<div class="gmanage">
<form action="requests.php" method="post">
<input type="hidden" name="func" value="gmanagement">
<input type="hidden" name="group" value="<? echo "$curgroup[Id]";?>">


<b><? echo $curgroup[Name] ?></b> <i>(<? echo $curgroup[Type]; ?>)</i>
<?												
echo "<input type='checkbox' name='deletegroup' value='$curgroup[Id]'>Delete Group?"; //delete group
echo "<input type='checkbox' name='renamegroup' value='$curgroup[Id]'>Rename Group?"; //rename group

echo " <input type='text' name='gnname' value='$curgroup[Name]'>";

?>
<input type="submit" value="Update Group">

<?
//here's where the tables go.  I'm probably trying to do too much again.
//table for current members. you can delete them (kick them out of the group)
?>
<h4>Current Users</h4>
<table class="niceTable">
<tr>
<th>Remove from Group?</th>
<th>User Name</th>	
</tr>


<?
// get current users in the group. don't count yourself, same problem as above.
$query = "SELECT User FROM GroupMembership WHERE IBGroup='$curgroup[Id]'";
$result = sql_query($query);

while ($u = mysqli_fetch_array($result)) {
	//don't show yourself
	if ($u[User] == $_SESSION[user_idx]) {
		continue;
	}
	
	$query = "SELECT UserId from User WHERE AccountNumber=$u[User]";
	$username = sql_query($query);
	$username = mysqli_fetch_array($username);
	$username = $username["UserId"];
	
	echo "<tr>" .
		 "<td><input type='checkbox' name='deluser[]' value='$u[User]'></td>" .
		 "<td>$username</td>" .
		 "</tr>";
		 
}

?>



</table>


<?
//table for pending requests waiting on approval from owner (you)	these can actually be done with a boolean flag.
?>
<h4>Pending Requests waiting on approval</h4>
<table class="niceTable">
<tr>
<th>Accept?</th>
<!-- <th>Deny?</th> Nope, not doing this part-->
<th>User Name</th>	
</tr>

<?
$query = "SELECT * FROM GroupRequest WHERE GroupId='$curgroup[Id]' AND WhoRequested='USER'"; 	//poop
$result = sql_query($query);
while ($u = mysqli_fetch_array($result)) {
	$query = "SELECT UserID from User WHERE AccountNumber=$u[UserId]";
	$username = sql_query($query);
	$username = mysqli_fetch_array($username);
	$username = $username["UserID"];
	
	echo "<tr>" .
		 "<td><input type='checkbox' name='adduser[]' value='$u[UserId]'></td>" .			//figure out radio buttons
	//	 "<td><input type='checkbox' name='rejectuser[]' value='$u[User]'></td>" .
		 "<td>$username</td>" .
		 "</tr>";
}


?>


</table>
<?
//table for pending requests waiting on approval from person (not you)
?>
<h4>Pending requests you sent</h4>
<table class="niceTable">
<tr>
<th>Rescind offer?</th>
<th>User Name</th>	
</tr>
<?
//put a thing in here for adding new users to the group.
//selection is of users that are not in the group, and do not have a pending request for this group.

$query = "SELECT * FROM GroupRequest WHERE GroupId='$curgroup[Id]' AND WhoRequested='OWNER'"; 
$result = sql_query($query);
while ($u = mysqli_fetch_array($result)) {
	$query = "SELECT UserID from User WHERE AccountNumber=$u[UserId]";
	$username = sql_query($query);
	$username = mysqli_fetch_array($username);
	$username = $username["UserID"];
	
	echo "<tr>" .
		 "<td><input type='checkbox' name='recuser[]' value='$u[UserId]'></td>" .
		 "<td>$username</td>" .
		 "</tr>";
}



?>
</table>

<h4>Send New Group Request</h4>
<select name="rxr">
<?
	$query = "SELECT UserID, AccountNumber FROM User " .	//fancy query to exclude users already in the group, and those with requests out for the group
		"WHERE AccountNumber NOT IN (SELECT User FROM GroupMembership WHERE IBGroup='$curgroup[Id]')" .
		"AND AccountNumber NOT IN (SELECT UserId FROM GroupRequest WHERE GroupId='$curgroup[Id]')" .
		"ORDER BY UserID ASC;";
	$userlist = sql_query($query);
	while ($u = mysqli_fetch_array($userlist)) {
		if ($u[AccountNumber] == $_SESSION[user_idx]) {
			continue;
		}
		echo "<option value='$u[AccountNumber]'>$u[UserID]</option>";
	}
	
	echo "<input type='checkbox' name='sendrequest' value='$curgroup[Id]'> Send Request?";
	
	?>
</select>


</form>
</div>
<?
}	//the end of the current group while loop.
?>

<h3>Send a Request to Join a Group</h3>
<form action="requests.php" method="post">
<input type="hidden" name="func" value="gsend">
<table class="niceTable">
<tr>
<th>Send Request?</th>
<th>Group Name</th>
<th>Organization Type</th>
</tr>

<?
//get all the groups we're not in(which covers groups we own), and don't have requests for
$query = "SELECT Name, Type, Id FROM IBGroup " .
		 "WHERE Id NOT IN (SELECT IBGroup FROM GroupMembership WHERE User='$_SESSION[user_idx]') " .
		 "AND Id NOT IN (SELECT GroupId FROM GroupRequest WHERE UserId='$_SESSION[user_idx]')";
$glist = sql_query($query);
while ($g = mysqli_fetch_array($glist)) {
	echo "<tr>" .
	"<td><input type='checkbox' name='grequest[]' value='$g[Id]'></td>" .	//request
	"<td>$g[Name]</td>" .	//group name
	"<td>$g[Type]</td>" .	//group type
	"</tr>";	
}
?>

</table>
<input type="submit" value="Send selected Group requests">
</form>


<h3>Create a new group</h3>
<!-- group needs: name, type -->
<form action="requests.php" method="post">
<input type="hidden" name="func" value="gcreate">

Group Name: <input type='text' name='gname'>

Group Type: <input type='text' name='gtype'>
	<? /* Group types are just user definable, not predetermined.
	<select name="gtype">
	//make an option for every group type
	$users = sql_query("SELECT UserID, AccountNumber FROM User");
	while ($u = mysqli_fetch_array($users)) {
		echo "<option value='$u[AccountNumber]'>$u[UserID]</option>";
	}
	
	</select></td>
	*/ ?>
<input type="submit" value="Create Group">
</form>






