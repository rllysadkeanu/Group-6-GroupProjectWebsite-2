<?php

require_once("settings.php");

if ($_SERVER["REQUEST_METHOD"] != "POST")
{
    header("Location: apply.php");
    exit();
}

function clean($data)
{
    return htmlspecialchars(trim(stripslashes($data)));
}

$job_ref = clean($_POST["job_reference_number"]);
$first_name = clean($_POST["first_name"]);
$last_name = clean($_POST["last_name"]);
$date_of_birth = clean($_POST["date_of_birth"]);
$gender = clean($_POST["gender"]);

$street_address = clean($_POST["street_address"]);
$suburb_town = clean($_POST["suburb_town"]);
$state = clean($_POST["state"]);
$postcode = clean($_POST["postcode"]);

$email = clean($_POST["email"]);
$phone = clean($_POST["phone_number"]);

$skills = "";

if(isset($_POST["skill"]))
{
    $skills = implode(", ", $_POST["skill"]);
}

$other_skill = clean($_POST["other_skill"] ?? "");

$error = "";

/* Validation */

if(!preg_match("/^[A-Za-z0-9]{5}$/", $job_ref))
{
    $error .= "Invalid Job Reference Number<br>";
}

if(!preg_match("/^[A-Za-z]{1,20}$/", $first_name))
{
    $error .= "Invalid First Name<br>";
}

if(!preg_match("/^[A-Za-z]{1,20}$/", $last_name))
{
    $error .= "Invalid Last Name<br>";
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL))
{
    $error .= "Invalid Email Address<br>";
}

if(!preg_match("/^[0-9]{8,12}$/", $phone))
{
    $error .= "Invalid Phone Number<br>";
}

if(!preg_match("/^[0-9]{4}$/", $postcode))
{
    $error .= "Invalid Postcode<br>";
}

if($error != "")
{
    die($error);
}

/* Insert Application */

$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO eoi
    (
        job_ref,
        first_name,
        last_name,
        date_of_birth,
        gender,
        street_address,
        suburb_town,
        state,
        postcode,
        email,
        phone,
        skills,
        other_skill
    )
    VALUES
    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
);

mysqli_stmt_bind_param(
    $stmt,
    "sssssssssssss",
    $job_ref,
    $first_name,
    $last_name,
    $date_of_birth,
    $gender,
    $street_address,
    $suburb_town,
    $state,
    $postcode,
    $email,
    $phone,
    $skills,
    $other_skill
);

mysqli_stmt_execute($stmt);

$eoi_number = mysqli_insert_id($conn);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Application Submitted</title>
    <link rel="stylesheet" href="styles/unified.css">
</head>
<body>

<?php include 'header.inc'; ?>

<div class="form-container">

    <h2>Application Submitted Successfully</h2>

    <p>Your EOI Number is:</p>

    <h3><?php echo $eoi_number; ?></h3>

    <a href="index.php">Return Home</a>

</div>

<?php include 'footer.inc'; ?>

</body>
</html>