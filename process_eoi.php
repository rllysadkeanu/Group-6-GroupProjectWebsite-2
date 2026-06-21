<?php

require_once("settings.php");

if ($_SERVER["REQUEST_METHOD"] != "POST")
{
    header("Location: apply.php");
    exit();
}

function sanitise_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

$job_ref = sanitise_input($_POST["job_reference_number"] ?? "");
$first_name = sanitise_input($_POST["first_name"] ?? "");
$last_name = sanitise_input($_POST["last_name"] ?? "");
$date_of_birth = sanitise_input($_POST["date_of_birth"] ?? "");
$gender = sanitise_input($_POST["gender"] ?? "");
$street_address = sanitise_input($_POST["street_address"] ?? "");
$suburb_town = sanitise_input($_POST["suburb_town"] ?? "");
$state = sanitise_input($_POST["state"] ?? "");
$postcode = sanitise_input($_POST["postcode"] ?? "");
$email = sanitise_input($_POST["email"] ?? "");
$phone = sanitise_input($_POST["phone_number"] ?? "");
$other_skill = sanitise_input($_POST["other_skill"] ?? "");

$skills = "";

if(isset($_POST["skill"]))
{
    $skills = implode(", ", $_POST["skill"]);
}

$errors = array();

if(!preg_match("/^[A-Za-z0-9]{5}$/", $job_ref))
{
    $errors[] = "Invalid Job Reference Number";
}

if(!preg_match("/^[A-Za-z]{1,20}$/", $first_name))
{
    $errors[] = "Invalid First Name";
}

if(!preg_match("/^[A-Za-z]{1,20}$/", $last_name))
{
    $errors[] = "Invalid Last Name";
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL))
{
    $errors[] = "Invalid Email Address";
}

if(!preg_match("/^[0-9]{8,12}$/", $phone))
{
    $errors[] = "Invalid Phone Number";
}

if(!preg_match("/^[0-9]{4}$/", $postcode))
{
    $errors[] = "Invalid Postcode";
}

if(count($errors) > 0)
{
    echo "<h2>Errors Found</h2>";

    foreach($errors as $error)
    {
        echo "<p>$error</p>";
    }

    echo '<p><a href="apply.php">Return to Application Form</a></p>';

    exit();
}

$sql = "
INSERT INTO eoi
(
    job_ref,
    first_name,
    last_name,
    email,
    phone,
    date_of_birth,
    gender,
    street_address,
    suburb_town,
    state,
    postcode,
    skills,
    other_skill
)
VALUES
(
    ?, ?, ?, ?, ?,
    ?, ?, ?, ?, ?,
    ?, ?, ?
)
";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "sssssssssssss",
    $job_ref,
    $first_name,
    $last_name,
    $email,
    $phone,
    $date_of_birth,
    $gender,
    $street_address,
    $suburb_town,
    $state,
    $postcode,
    $skills,
    $other_skill
);

mysqli_stmt_execute($stmt);

$eoi_number = mysqli_insert_id($conn);

mysqli_stmt_close($stmt);
mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Application Submitted</title>
<link rel="stylesheet" href="styles/unified.css">
</head>

<body>

<?php include 'header.inc'; ?>

<div class="form-container">

<h2>Application Submitted Successfully</h2>

<p>Your EOI Number is:</p>

<h3><?php echo $eoi_number; ?></h3>

<p>
<a href="index.php">Return to Home Page</a>
</p>

</div>

<?php include 'footer.inc'; ?>

</body>
</html>