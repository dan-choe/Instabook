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

if(!$_GET[g_id]){
    ?>
    <script>
        alert("No group id!");
        history.back();
    </script>
    <?
    exit;
}else{
    $g_id = $_GET[g_id];
	
}


if (isset($_POST[func])) {
	if (strcmp($_POST[func],'Enter') == 0) {
			// change the name of group. only owner allows this!
			
			$ibgroupnewname = "SELECT * FROM IBGroup WHERE Id=" . $g_id; //ORDER BY Id DESC
			$ibgroupnewname = sql_query($ibgroupnewname);
			$ibgroupnewname = mysqli_fetch_array($ibgroupnewname);

			sql_query("UPDATE IBGroup SET Name='$_POST[newgroupname]' WHERE Id='$g_id' ");
			
	} else if (strcmp($_POST[func],'Delete') == 0) {
		
			sql_query("DELETE FROM Post WHERE Id=".$_POST[postid]);
			
			// AttachedToPage
			sql_query("DELETE FROM AttachedToPage WHERE Post=".$_POST[postid]);
			
			// decrease post count in Page
			$currPCount = sql_query("SELECT * FROM Page WHERE AssociatedGroup='$g_id'");
			$currPCount = mysqli_fetch_array($currPCount);
			$currPCount = $currPCount[PostCount] - 1;
			sql_query("UPDATE Page SET PostCount='$currPCount' WHERE AssociatedGroup='$g_id' ");
			
	} else if (strcmp($_POST[func],'post') == 0) {
		// insert post
		$sndID = $_SESSION[user_idx];
		$content = mysqli_real_escape_string($connect, $_POST[post]);		
		sql_query("INSERT INTO Post(Author, Content, LikeCount, CommentCount, Date) VALUES('$sndID', '$content',0,0,NOW())");
		
		// AttachedToPage	
		$postID = sql_query("SELECT Id FROM Post WHERE Content='$content'");
		$postID = mysqli_fetch_array($postID);
		$postID = $postID[Id];
		sql_query("INSERT INTO AttachedToPage(Post, Page) VALUES('$postID', '$g_id')");
		
		// increase post count in Page
		$currPCount = sql_query("SELECT * FROM Page WHERE AssociatedGroup='$g_id'");
		$currPCount = mysqli_fetch_array($currPCount);
		$currPCount = $currPCount[PostCount] + 1;
		sql_query("UPDATE Page SET PostCount='$currPCount' WHERE AssociatedGroup='$g_id' ");
		

	} else if (strcmp($_POST[func],'Submit comment') == 0) {
		$sndID = $_SESSION[user_idx];
		$content = mysqli_real_escape_string($connect, $_POST[commenttext]);
		
		sql_query("INSERT INTO Comment(Author, Content, LikeCount, TimeCommmented) VALUES('$sndID', '$content',0,NOW())");
		
		$commentID = sql_query("SELECT Id FROM Comment WHERE Content='$content'");
		$commentID = mysqli_fetch_array($commentID);
		$commentID = $commentID[Id];
		
		sql_query("INSERT INTO AttachedToPost(Post, Comment) VALUES('$_POST[postid]', '$commentID')");
		
		
		$currentNumComment = sql_query("SELECT CommentCount FROM Post WHERE Id='$_POST[postid]'");
		$currentNumComment = mysqli_fetch_array($currentNumComment);
		$addOne = $currentNumComment[CommentCount] + 1;
		
		sql_query("UPDATE Post SET CommentCount='$addOne' WHERE Id='$_POST[postid]' ");
		
		
		
		
	} else if (strcmp($_POST[func],'Like this post') == 0) {
		
		$sndID = $_SESSION[user_idx];
		
		sql_query("INSERT INTO LikePost(UserID, PostId) VALUES('$sndID', '$_POST[postid]')");
		
		$currentLike = sql_query("SELECT LikeCount FROM Post WHERE Id='$_POST[postid]'");
		$currentLike = mysqli_fetch_array($currentLike);
		$addOneLike = $currentLike[LikeCount] + 1;
		
		sql_query("UPDATE Post SET LikeCount='$addOneLike' WHERE Id='$_POST[postid]' ");
		
	} else if (strcmp($_POST[func],'Unlike this post') == 0) {
		
		$sndID = $_SESSION[user_idx];
		
		sql_query("DELETE FROM LikePost WHERE UserID='$sndID' AND PostId ='$_POST[postid]'");
		
		$currentLike = sql_query("SELECT LikeCount FROM Post WHERE Id='$_POST[postid]'");
		$currentLike = mysqli_fetch_array($currentLike);
		$addOneLike = $currentLike[LikeCount] - 1;
		
		sql_query("UPDATE Post SET LikeCount='$addOneLike' WHERE Id='$_POST[postid]' ");
		
	} else if (strcmp($_POST[func],'Like this comment') == 0) {
		
		$sndID = $_SESSION[user_idx];
		
		sql_query("INSERT INTO LikeComment(UserID, CommentId) VALUES('$sndID', '$_POST[commentid]')");
		
		$currentLike = sql_query("SELECT LikeCount FROM Comment WHERE Id='$_POST[commentid]'");
		$currentLike = mysqli_fetch_array($currentLike);
		$addOneLike = $currentLike[LikeCount] + 1;
		
		sql_query("UPDATE Comment SET LikeCount='$addOneLike' WHERE Id='$_POST[commentid]' ");
		
	} else if (strcmp($_POST[func],'Unlike this comment') == 0) {
		
		$sndID = $_SESSION[user_idx];
		
		sql_query("DELETE FROM LikeComment WHERE UserID='$sndID' AND CommentId ='$_POST[commentid]'");
		
		$currentLike = sql_query("SELECT LikeCount FROM Comment WHERE Id='$_POST[commentid]'");
		$currentLike = mysqli_fetch_array($currentLike);
		$addOneLike = $currentLike[LikeCount] - 1;
		
		sql_query("UPDATE Comment SET LikeCount='$addOneLike' WHERE Id='$_POST[commentid]' ");
		
	} else if (strcmp($_POST[func],'Delete this comment') == 0) {
		
		$sndID = $_SESSION[user_idx];
		
		sql_query("DELETE FROM Comment WHERE Author='$sndID' AND CommentId ='$_POST[commentid]'");
		
		$currentNumComment = sql_query("SELECT CommentCount FROM Post WHERE Id='$_POST[postid]'");
		$currentNumComment = mysqli_fetch_array($currentNumComment);
		$subtractOne = $currentNumComment[CommentCount] - 1;
		
		sql_query("UPDATE Post SET CommentCount='$subtractOne' WHERE Id='$_POST[postid]' ");
		
		sql_query("DELETE FROM AttachedToPost WHERE Post='$_POST[postid]' AND Comment ='$_POST[commentid]'");
		
		
		
	} 
}
?>



<?
if($_SESSION[user_id]){
    ?>
	
	 <h2>Hello <?php echo $_SESSION[user_name]?>!<br><br></h2>

    <?php
} else {
	echo "no user";
}


	$ibgroup = "SELECT * FROM IBGroup WHERE Id=" . $g_id; //ORDER BY Id DESC
	$ibgroup = sql_query($ibgroup);
	$ibgroup = mysqli_fetch_array($ibgroup);
	
	echo "<h2>Group Name : ".$ibgroup[Name]."</h2>";
	
	if($_SESSION[user_idx] == $ibgroup[Owner]){
		echo "<h2>Change the name of group : ";
		
		echo "<form action='group.php?g_id=".$g_id."' method='post'>".
			"<input type='text' name='newgroupname' value='' size='50'><input type='submit' name='func' value='Enter'></td>" .
			"</form></h2>";
	}

	
	
	$ownerinfo = sql_query("SELECT * FROM User WHERE AccountNumber=". $ibgroup[Owner]);
	$ownerinfo = mysqli_fetch_array($ownerinfo);
	
	echo "<h2>Group Owner : ".$ownerinfo[UserID]." (".$ownerinfo[FirstName]." ".$ownerinfo[LastName].")</h2>";
	
	$groupPage = sql_query("SELECT * FROM Page WHERE AssociatedGroup=". $g_id);
	$groupPage = mysqli_fetch_array($groupPage);
	
	echo "<h2>Total number of post of this group : ".$groupPage[PostCount]."</h2>";

	
	
?>

<div>

	<div id="head_account">
		<div>
			<!--profile pic / id / ... -->
		</div>
	</div>
	<!-- Make a post -->
	<div>
		<h2>Make a post on the group page</h2>
		<form action="group.php?g_id=<?=$g_id?>" method="post">
		<table>
	

		<tr>
			<td colspan=4>
			Content:<br>
			<textarea rows='4' cols='80' name='post'></textarea>
			</td>
		</tr>
		</table>
		<input type="hidden" name="func" value="post">
		<input type="submit" value="Submit">
		</form>
	</div>
	
	<?
		if (isset($_POST[funcmodify])) {	
				if (strcmp($_POST[funcmodify],'Modify') == 0) {
							echo "modify button!";
							
							$modifypost = sql_query("SELECT * FROM Post WHERE Id='$_POST[postid]' ");
							$modifypost = mysqli_fetch_array($modifypost);
		
							echo "<div><h2>Modify this post</h2>
									<form action='group.php?g_id=".$g_id."' method='post'>
									<table><tr>
									<td colspan=4>
									Content:<br>
									<textarea rows='4' cols='80' name='post'>$modifypost[Content]</textarea>
									</td>
										</tr>
										</table>
										<input type='hidden' name='postid' value='$_POST[postid]'>
										<input type='submit' name='funcmodify' value='Submit modified post'>
										<input type='submit' name='funcmodify' value='Cancel modify post'>
										</form>
									</div>";
				} else if (strcmp($_POST[funcmodify],'Submit modified post') == 0) {
							echo "The post is updated!";
							
							$content = mysqli_real_escape_string($connect, $_POST[post]);
							
							sql_query("UPDATE Post SET Content='$content' WHERE Id='$_POST[postid]' ");
							
							
				} else if (strcmp($_POST[funcmodify],'Cancel modify post') == 0) {
							echo "Canceled modification of this post!";
				}
			}
	
	?>
	
	
	<?
		if (isset($_POST[funcmodifyc])) {	
				if (strcmp($_POST[funcmodifyc],'Modify this comment') == 0) {
							echo "modify button!";
							
							$modifycomment = sql_query("SELECT * FROM Comment WHERE Id='$_POST[commentid]' ");
							$modifycomment = mysqli_fetch_array($modifycomment);
		
							echo "<div><h2>Modify this post</h2>
									<form action='group.php?g_id=".$g_id."' method='post'>
									<table><tr>
									<td colspan=4>
									Content:<br>
									<textarea rows='4' cols='80' name='post'>$modifycomment[Content]</textarea>
									</td>
										</tr>
										</table>
										<input type='hidden' name='commentid' value='$_POST[commentid]'>
										<input type='submit' name='funcmodifyc' value='Submit modified comment'>
										<input type='submit' name='funcmodifyc' value='Cancel modify comment'>
										</form>
									</div>";
				} else if (strcmp($_POST[funcmodifyc],'Submit modified comment') == 0) {
							echo "The post is updated!";
							
							$content = mysqli_real_escape_string($connect, $_POST[post]);
							
							sql_query("UPDATE Comment SET Content='$content' WHERE Id='$_POST[commentid]' ");
							
							
				} else if (strcmp($_POST[funcmodifyc],'Cancel modify comment') == 0) {
							echo "Canceled modification of this comment!";
				}
			}
	
	?>
	
	
	
	
	
	
	<!--
			See all posts
	-->
	
	<div>
		<form action="group.php?g_id=<?=$g_id?>" method="post">
		
		<table class="postTable">
		<tr>
		<th>Edit</th>
		<th>Author</th>
		<th>DateTime</th>
		
		<th>Content</th>
		<th>LikeCount</th>
		<th>CommentCount</th>
		</tr>
		<?
		
		//AttachedToPage : Posts of this group
		
		$posts = "SELECT * FROM AttachedToPage WHERE Page=".$g_id; // ORDER BY Post DESC
		$postsresult = sql_query($posts);
		
		
		
		
		
		while ($posts = mysqli_fetch_array($postsresult)) {
			$query = "SELECT * FROM Post WHERE Id=" . $posts[Post];// ." ORDER BY Id DESC";
			$result = sql_query($query);
		
		
		while ($row = mysqli_fetch_array($result)) {

			$writername = sql_query("SELECT UserID FROM User WHERE AccountNumber=". $row[Author]);
			$writername = mysqli_fetch_array($writername);

			echo "<tr><td colspan='6' style='height:20px; border-bottom:2px solid #000;'></td></tr><tr>";
			
			
			// delete & modify button, but should be author of it or owner of this group
			
			if($_SESSION[user_idx] == $row[Author] || $_SESSION[user_idx] == $ibgroup[Owner]){
			
				echo "<td><form action='group.php?g_id=".$g_id."' method='post'>
				<input type='hidden' name='postid' value='$row[Id]'>
				<input type='submit' name='func' value='Delete'>
				<input type='submit' name='funcmodify' value='Modify'></form></td>";
	
			}
			else{
				echo "<td></td>";
				
			}
			
			echo "<td>$writername[UserID]</td>" .
				"<td>$row[Date]</td>" .			//date
				"<td>$row[Content]</td>" .			//Content
				"<td>$row[LikeCount]</td>" .			//LikeCount
				"<td>$row[CommentCount]</td>" .			//CommentCount
				"</tr>".
				"<tr>";
			
			echo "<form action='group.php?g_id=".$g_id."' method='post'>
			<td colspan='2'>".
			"Write a comment</td>".
			"<td colspan='3'><input type='hidden' name='postid' value='$row[Id]'>
			
			<input type='text' name='commenttext' value='' size='50'></td>" .
			
			"<td><input type='submit' name='func' value='Submit comment'></td>" .
			"</form></tr>";
			
			
			// check the user liked this post before or not.
			$youlikedquery = "SELECT COUNT(*) AS counts FROM LikePost WHERE UserID=" . $_SESSION[user_idx]." AND PostId=" . $row[Id];
			$youlikedresult = sql_query($youlikedquery);
			$youlikedresult = mysqli_fetch_array($youlikedresult);
			
			if($youlikedresult[counts] == 0){
				//like button this post
				echo "<tr>
				<td colspan='2'>Do you like this post?</td>".
				"<td colspan='3'>
				<form action='group.php?g_id=".$g_id."' method='post'>
				<input type='hidden' name='postid' value='$row[Id]'>
				<input type='submit' name='func' value='Like this post'></td>" .
				"</form></tr>";
			}else{
				//unlike button
				echo "<tr>
				<td colspan='2'>You like this post.</td>".
				"<td colspan='3'>
				<form action='group.php?g_id=".$g_id."' method='post'>
				<input type='hidden' name='postid' value='$row[Id]'>
				<input type='submit' name='func' value='Unlike this post'></td>" .
				"</form></tr>";
				
			}
			
				// list of comments of this post
				$commentquery = "SELECT * FROM AttachedToPost WHERE Post=" . $row[Id];
				$commentresult = sql_query($commentquery);
				
				if(mysqli_num_rows($commentresult)==0){
					//echo "no comment";
				}else{
					
					echo "<tr><td colspan='6'><table class='commetTable'>";
						
					while ($commentrow = mysqli_fetch_array($commentresult)) {
						
						$getthecomment = sql_query("SELECT * FROM Comment WHERE Id=". $commentrow[Comment]);
						$thecomment = mysqli_fetch_array($getthecomment);
						
						$cusername = sql_query("SELECT UserID FROM User WHERE AccountNumber=". $thecomment[Author]);
						$ccusername = mysqli_fetch_array($cusername);

						echo "<tr>" .
						"<td>$ccusername[0]</td>" .
						"<td>$thecomment[Date]</td>" .
						"<td>$thecomment[Content]</td>" .
						"<td>LikeCount: ".$thecomment[LikeCount]."</td>" .
						"<td colspan='2'>$thecomment[TimeCommmented]</td>" .
						"</tr>";
						
						
						// check the user liked this comment before or not.
						$youlikedcquery = "SELECT COUNT(*) AS counts FROM LikeComment WHERE UserID=" . $_SESSION[user_idx]." AND CommentId=" . $thecomment[Id];
						$youlikedcresult = sql_query($youlikedcquery);
						$youlikedcresult = mysqli_fetch_array($youlikedcresult);
						
						if($youlikedcresult[counts] == 0){
							//like button this comment
							echo "<tr>
								<form action='group.php?g_id=".$g_id."' method='post'>
								<td colspan='2'>Do you like this comment?</td>".
								"<td colspan='3'><input type='hidden' name='commentid' value='$thecomment[Id]'><input type='submit' name='func' value='Like this comment'></td>" .
								"</form></tr>";
						}else{
							//unlike button
							echo "<tr>
								<form action='group.php?g_id=".$g_id."' method='post'>
								<td colspan='2'>You like this comment.</td>".
								"<td colspan='3'><input type='hidden' name='commentid' value='$thecomment[Id]'><input type='submit' name='func' value='Unlike this comment'></td>" .
								"</form></tr>";
						}
						
						// if the user is owner of this comment, show delete / modify button.
						
						$ownercommentquery = "SELECT * FROM Comment WHERE Author=" . $_SESSION[user_idx]." AND Id=" . $thecomment[Id];
						$ownercommentqueryresult = sql_query($ownercommentquery);
						$ownercommentqueryresult2 = mysqli_fetch_array($ownercommentqueryresult);
						
						if(mysqli_num_rows($ownercommentqueryresult)){
							//show delete / modify button
							echo "<tr>
								<form action='group.php?g_id=".$g_id."' method='post'>".
								"<td colspan='3'><input type='hidden' name='postid' value='$row[Id]'><input type='hidden' name='commentid' value='$thecomment[Id]'><input type='submit' name='func' value='Delete this comment'></td>" .
								"<td colspan='3'><input type='submit' name='funcmodifyc' value='Modify this comment'></td>" .
								"</form></tr>";
						}else{
							//no button
							echo "";
						}
					}

				
				echo "</td></tr></table>";
				}
		}
		
		}
		
		echo "</td></tr></form></table>";
		mysqli_close($connect);
		
		?>
	</div>

</div>
