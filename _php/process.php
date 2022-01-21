<?php

session_start();
require_once("initializations.php");
require_once("config.php");
// var_dump($_POST);
if(isset($_POST["User"]["user_type"]) && $_POST["User"]["user_type"] == "sign_in_student"){
    $user = $_POST["User"];
	$student_number = $user["student_number"];
	$password = $user["password"];
	// $sql = "SELECT * FROM " . $tbl_name . " WHERE BINARY (`Username` = '$username_or_email' OR `Email` = '$username_or_email') AND password = '$password'";
	$sql = "SELECT * FROM tbl_students WHERE BINARY (`Student Number` = '$student_number')";
	$select = $db_connection->prepare($sql);
	$select->execute();
	if($select->rowCount()>0){
		$user_password = $select->fetch(PDO::FETCH_ASSOC)["Password"];
		if(password_verify($password, $user_password)) {
			$_SESSION["user_id"] = $student_number;
			header("Location: " . getRelativePath("student/index.php"));
		} else {
			echo "
				<script>
					alert('Invalid Credentials!');
				</script>
			";
			echo "
				<script type='text/javascript'>
					setTimeout(
						function() {
							window.top.location='" . getRelativePath('stms/index.php') . "'
						}
					);
				</script>
			";
		}

	} else {
		// var_dump(getRelativePath('stms/index.php'));
		echo "
			<script>
				alert('Invalid Credentials!');
			</script>
		";
		echo "
			<script type='text/javascript'>
				setTimeout(
                    function() {
                        window.top.location='" . getRelativePath('stms/index.php') . "'
                    }
				);
			</script>
		";

	}
}

if(isset($_POST["User"]["user_type"]) && $_POST["User"]["user_type"] == "sign_up_student"){
    
    $user = $_POST["User"];
	$password = $user["password"] ?? "";
	
	if($password != $user["password_confirmation"]) {

	echo "
		<script>
			alert('Invalid Credentials!');
		</script>
	";
	echo "
		<script type='text/javascript'>
			setTimeout(
                function() {
                    window.top.location='" . sendGETData("form_type=sign_up&user_type=student") . "'
                }
			);
		</script>
	";
	}
	else{
        $user = $_POST["User"];

		$given_name = $user["given_name"];
		$middle_name = $user["middle_name"];
        $family_name = $user["family_name"];
        $block_number = $user["block_number"];
        $lot_number = $user["lot_number"];
        $street = $user["street"];
        $subdivision = $user["subdivision"];
        $barangay = $user["barangay"];
        $city = $user["city"];
        $province = $user["province"];
        $birthdate = "{$user['birth_month']}-{$user['birth_day']}-{$user['birth_year']}" ;
        $gender = $user["gender"];
        $contact_number = $user["contact_number"];
        $email = $user["email"];
        
        $student_number = $user["student_number"];
        $program = $user["program"];
        $year_level = $user["year_level"];
        $block_section = $user["block_section"];


		$password = password_hash($user["password"], PASSWORD_DEFAULT);
		$sql = "INSERT INTO tbl_students (`Given Name`, `Middle Name`, `Family Name`, `Gender`, `Email`, `Password`, `Block Number`, `Lot Number`, `Street`, `Subdivision`, `Barangay`, `City`, `Province`, `Birthdate`, `Contact Number`, `Student Number`, `Program`, `Year Level`, `Block Section Number`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$insert = $db_connection->prepare($sql);
		$insert->execute([$given_name, $middle_name, $family_name, $gender, $email, $password, $block_number, $lot_number, $street, $subdivision, $barangay, $city, $province, $birthdate, $contact_number, $student_number, $program, $year_level, $block_section]);
		if($insert->rowCount()>0){
			echo "
			<script>
				alert('Account Successfully Registered!');
			</script>
			";

			echo "
				<script type='text/javascript'>
					setTimeout(
                        function() {
                            window.top.location='" . sendGETData('form_type=sign_in&user_type=student') . "'
                        }
					);
				</script>
			";
		}
	}

	
}
