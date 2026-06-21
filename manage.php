<?php

session_start();

require_once("settings.php");

if(!isset($_SESSION["admin"]))
{
    header("Location: login.php");
    exit();
}

if(isset($_POST["delete_job"]))
{
    $job_ref = mysqli_real_escape_string(
        $conn,
        $_POST["job_ref"]
    );

    mysqli_query(
        $conn,
        "DELETE FROM eoi
         WHERE job_ref='$job_ref'"
    );
}

if(isset($_POST["update_status"]))
{
    $eoi_id = (int)$_POST["eoi_id"];

    $status = mysqli_real_escape_string(
        $conn,
        $_POST["status"]
    );

    mysqli_query(
        $conn,
        "UPDATE eoi
         SET status='$status'
         WHERE eoi_id=$eoi_id"
    );
}

$sort = $_GET["sort"] ?? "eoi_id";

$allowed_sorts =
[
    "eoi_id",
    "job_ref",
    "first_name",
    "last_name",
    "status"
];

if(!in_array($sort, $allowed_sorts))
{
    $sort = "eoi_id";
}

$query =
"SELECT *
 FROM eoi
 ORDER BY $sort";

if(isset($_POST["search_job"]))
{
    $job_ref = mysqli_real_escape_string(
        $conn,
        $_POST["job_ref"]
    );

    $query =
    "SELECT *
     FROM eoi
     WHERE job_ref='$job_ref'";
}

if(isset($_POST["search_name"]))
{
    $name = mysqli_real_escape_string(
        $conn,
        $_POST["name"]
    );

    $query =
    "SELECT *
     FROM eoi
     WHERE first_name LIKE '%$name%'
     OR last_name LIKE '%$name%'";
}

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage EOIs</title>
<link rel="stylesheet" href="styles/unified.css">
</head>

<body>

<?php include 'header.inc'; ?>
<?php include 'nav.inc'; ?>

<div class="form-container">

<h2>Manage EOIs</h2>

<p>
Sort Results:
<a href="?sort=eoi_id">EOI ID</a> |
<a href="?sort=job_ref">Job Reference</a> |
<a href="?sort=first_name">First Name</a> |
<a href="?sort=last_name">Last Name</a> |
<a href="?sort=status">Status</a>
</p>

<hr>

<form method="post">

<label>Search by Job Reference:</label>

<input type="text" name="job_ref">

<input
type="submit"
name="search_job"
value="Search">

</form>

<br>

<form method="post">

<label>Search by Applicant Name:</label>

<input type="text" name="name">

<input
type="submit"
name="search_name"
value="Search">

</form>

<br>

<form method="post">

<label>Delete EOIs by Job Reference:</label>

<input type="text" name="job_ref">

<input
type="submit"
name="delete_job"
value="Delete">

</form>

<br>

<table border="1" cellpadding="8">

<tr>
<th>EOI ID</th>
<th>Job Ref</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Status</th>
<th>Update Status</th>
</tr>

<?php

while($row = mysqli_fetch_assoc($result))
{
?>

<tr>

<td><?php echo $row["eoi_id"]; ?></td>

<td><?php echo htmlspecialchars($row["job_ref"]); ?></td>

<td>
<?php
echo htmlspecialchars(
    $row["first_name"] . " " . $row["last_name"]
);
?>
</td>

<td><?php echo htmlspecialchars($row["email"]); ?></td>

<td><?php echo htmlspecialchars($row["phone"]); ?></td>

<td><?php echo htmlspecialchars($row["status"]); ?></td>

<td>

<form method="post">

<input
type="hidden"
name="eoi_id"
value="<?php echo $row["eoi_id"]; ?>">

<select name="status">

<option value="New">New</option>
<option value="Current">Current</option>
<option value="Final">Final</option>

</select>

<input
type="submit"
name="update_status"
value="Update">

</form>

</td>

</tr>

<?php
}
?>

</table>

<br>

<a href="logout.php">Logout</a>

</div>

<?php include 'footer.inc'; ?>

</body>
</html>