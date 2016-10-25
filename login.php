<?php 
	//require("../../config.php");
	require("functions.php");
	
	// kui kasutaja on sisseloginud, siis suuna data lehele
	if(isset ($_SESSION["userId"])) {
		header("Location: data.php");
		exit();
	}
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
		
	$signupPassword = "";	
	$signupEmailError = "";
	$signupEmail = "";
	$signupsignupTelephone = "";
	$signupsignupTelephoneError = "";
	$signupsignupUsernameError = "";
	$signupsignupUsername = "";
	$loginEmailError = "";
	$loginPasswordError= "";
	$loginEmail= "";
	$loginPassword= "";
	$signupUsername = "";
	$signupTelephone = "";
	$signupUsernameError = "";
	$signupTelephoneError = "";
	
	if (isset($_POST["loginPassword"])) {
		
		if (empty($_POST["loginPassword"])) {
			
			$loginPasswordError = "Palun sisestage parool";
			
		}
		
	}
	
	if (isset ($_POST["loginEmail"])) {
		
		if (empty($_POST["loginEmail"])) {
			
			$loginEmailError = "Palun sisestage email";
			
		} else {
			
			$loginEmail = ($_POST["loginEmail"]);
			
		}
		
	}
	
	//kas on üldse olemas
	if (isset ($_POST["signupEmail"])) {
		
		// oli olemas, ehk keegi vajutas nuppu
		// kas oli tühi
		if (empty ($_POST["signupEmail"])) {
			
			//oli tõesti tühi
			$signupEmailError = "See väli on kohustuslik";
			
		} else {
				
			// kõik korras, email ei ole tühi ja on olemas
			$signupEmail = $_POST["signupEmail"];
		}
		
	}
	
	$signupPasswordError = "";
	
	//kas on üldse olemas
	if (isset ($_POST["signupPassword"])) {
		
		// oli olemas, ehk keegi vajutas nuppu
		// kas oli tühi
		if (empty ($_POST["signupPassword"])) {
			
			//oli tõesti tühi
			$signupPasswordError = "See väli on kohustuslik";
			
		} else {
			
			// oli midagi, ei olnud tühi
			
			// kas pikkus vähemalt 8
			if (strlen ($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "Parool peab olema vähemalt 8 tm pikk";
				
			} else {
				
				//$signupUsername = cleanInput($_POST["signupUsername"]);
				$signupUsername = $_POST["signupUsername"];
				
			}
			
		}
		
	}
	
	if (isset ($_POST["signupTelephone"])) {
		
		if (empty ($_POST["signupTelephone"])) {
			
			$signupTelephoneError = "See väli on kohustuslik";
			
		} else {
			
			$signupTelephone = $_POST["signupTelephone"];
			
		}
		
	}
	
	if (isset ($_POST["signupUsername"])) {
		
		if (empty ($_POST["signupUsername"])) {
			
			$signupUsernameError = "See väli on kohustuslik";
			
		} else {
			
			if (strlen ($_POST["signupUsername"]) > 12) {
				
				 $signupUsernameError = "Kasutajanimi peab olema lühem kui 12 tm";
				
			}
			
		}
		
	}
	
	if ( isset($_POST["signupEmail"]) &&
		 isset($_POST["signupPassword"]) &&
		 isset($_POST["signupUsername"]) &&
		 isset($_POST["signupTelephone"]) &&
		 empty($signupUsernameError) &&
		 empty($signupTelephoneError) &&
		 empty($signupEmailError) &&
		 empty($signupPasswordError)
	   ) {
		
		// ühtegi viga ei ole, kõik vajalik olemas
		echo "salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo "räsi ".$password."<br>";
		
		//$signupEmail = cleanInput($signupEmail);
		//$password = cleanInput($password);
		
		
		
		//kutsun funktsiooni, et salvestada
		signup($signupEmail, $password, $signupUsername, $signupTelephone);
		
	}	
	
	$notice = "";
	if (isset($_POST["loginEmail"]) &&
		isset($_POST["loginPassword"]) &&
		!empty($_POST["loginEmail"]) &&
		!empty($_POST["loginPassword"])
	){
		
		//$_POST["loginEmail"] = cleanInput($_POST["loginEmail"]);
		//$_POST["loginEmail"] = cleanInput($_POST["loginPassword"]);
		
		
		$notice = login($_POST["loginEmail"], $_POST["loginPassword"]);
		
	}
	
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sisselogimise leht</title>
	</head>
	<body>

		<h1>Logi sisse</h1>
		<p style="color:red;"><?php echo $notice; ?></p>
		<form method="POST">
			
			<label>E-post</label><br>
			<input name="loginEmail" type="email" value="<?=$loginEmail;?>"> <?php echo $loginEmailError; ?>
			
			<br><br>
			
			<label>Parool</label><br>
			<input name="loginPassword" type="password"> <?php echo $loginPasswordError; ?>
						
			<br><br>
			
			<input type="submit">
		
		</form>
		
		<h1>Loo Kasutaja</h1>
		
		<form method="POST">
		
			<label>Kasutajanimi<label><br>
			<input name="signupUsername" type="text"> <?php echo $signupUsernameError; ?>
			
			<br><br>
			
			<label>E-post</label><br>
			<input name="signupEmail" type="email" value="<?=$signupEmail;?>"> <?php echo $signupEmailError; ?> 
			
			<br><br>
			
			<label>Parool</label><br>
			<input name="signupPassword" type="password"> <?php echo $signupPasswordError; ?>
			
			<br><br>
			
			<label>Telefon</label><br>
			<input name="signupTelephone" type="tel"> <?php echo $signupTelephoneError; ?>
			
			<br><br>
			
			<input type="submit" value="Loo Kasutaja">
</html>