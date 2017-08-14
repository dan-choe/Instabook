<?
session_start();

include ("./lib.php");

if($_SESSION[user_id] && $_SESSION[empl_id]){
	?>
	<script>
	alert("User & Employee login error! Please sign in again.");
	location.replace("instab_loginout.php");
	</script>
	<?
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

	<title>Instabook NY</title>

	<!-- Bootstrap core CSS -->
	<!-- <link href="css/bootstrap.css" rel="stylesheet"> -->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

	<!-- Custom styles for this template -->
	<!-- <link rel="stylesheet" href="layout.css"> -->
	<!-- <link rel="stylesheet" href="colors.css"> -->
	<!-- <link rel="stylesheet" href="style.css"> -->
	<link rel="stylesheet" href="style.css">

<?
	if($_SESSION[user_id]){
		echo "Logged in as user: $_SESSION[user_id]"."<br>";
	}
	if($_SESSION[empl_id] && $_SESSION[IsManager]){
		echo "Logged in as manager: $_SESSION[empl_id]"."<br>";
	}
	if($_SESSION[empl_id] && !$_SESSION[IsManager]){
		echo "Logged in as employee: $_SESSION[empl_id]"."<br>";
	}
?>

<br/>
</head>

<body>
	<div id="pageContent">
		<table class = 'titleBar'>
			<tr>
				<th colspan="100">
					InstaBook
				</th>
			</tr>
			<tr>
				<td><a href="./book">Read</a></td>
				<td><a href="./checklist">Check List</a></td>
				<td><a href="./list">Site Map</a></td>
				<?

				if($_SESSION[user_id]){
					?>

					<? // if logged in as user... ?>
					<td>
						<a href="./instab_loginout">Logout</a>
					</td>

					<!-- <td align="center" valign="middle" style="font-size:12px;">
					<a href="./messaging">Messaging</a>
				</td>

				<td align="center" valign="middle" style="font-size:12px;">
				<a href="./instab_m_modify">My Account</a>
			</td> -->

			<?}else if ($_SESSION[empl_id]){?>

				<? // if logged in as employee... ?>
				<td>
					<a href="./instab_loginout">Logout</a>
				</td>

				<!-- <td align="center" valign="middle" style="font-size:12px;">
				<a href="./advertisements">Manage Ads</a>
			</td> -->

			<?}else{?>

				<? // if not currently logged in in as user... ?>
				<td>
					<a href="./instab_login">User Login</a>
				</td>

				<td>
					<a href="./instab_employee_login">Employee Login</a>
				</td>

				<td>
					<a href="./instab_register">Register</a>
				</td>

				<?}?>


				<!-- </td>
				<td>
				<a href="./instab_m_list">Member-list</a>
			</td>
			<td>
			<a href="./instab_personalpage">PersonalPage</a>
		</td> -->
	</tr>
</table>
<hr/>
