<?php

session_start();
require_once("settings.php");

if(!isset($_SESSION["admin"]))
{
    header("Location: login.php");
    exit();
}

/* Delete by Job Reference */

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

/* Update Status */

if(isset($_POST["update_status"]))
{
    $eoi_id = (int)$_POST["eoi_id"];
    $status = $_POST["status"];

    mysqli_query(
        $conn,
        "UPDATE eoi
         SET status='$status'
         WHERE eoi_id=$eoi_id"
    );
}

/* Sorting */

$sort = $_GET["sort"] ?? "eoi_id";

$allowed =
[
    "eoi_id",
    "job_ref",
    "first_name",
    "last_name",
    "status"
];

if(!in_array($sort, $allowed))
{
    $sort = "eoi_id";
}

/* Search */

$query =
"SELECT *
 FROM eoi
 ORDER BY $sort";

if(isset($_POST["search_job"]))
{
    $job_ref =
    mysqli_real_escape_string(
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
    $name =
    mysqli_real_escape_string(
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
<html>
<head>
    <title>Manage EOIs</title>
    <link rel="stylesheet" href="styles/unified.css">
</head>

<body>

<?php include 'header.inc'; ?>
<?php include 'nav.inc'; ?>

<div class="form-container">

<h2>Manage EOIs</h2>

<p>
Sort:
<a href="?sort=eoi_id">EOI ID</a> |
<a href="?sort=job_ref">Job Ref</a> |
<a href="?sort=first_name">First Name</a> |
<a href="?sort=last_name">Last Name</a> |
<a href="?sort=status">Status</a>
</p>

<hr>

<form method="post">
    Search by Job Reference:
    <input type="text" name="job_ref">
    <button type="submit" name="search_job">
        Search
    </button>
</form>

<br>

<form method="post">
    Search by Applicant Name:
    <input type="text" name="name">
    <button type="submit" name="search_name">
        Search
    </button>
</form>

<br>

<form method="post">
    Delete All EOIs by Job Reference:
    <input type="text" name="job_ref">
    <button type="submit" name="delete_job">
        Delete
    </button>
</form>

<br>

<table border="1" cellpadding="8">

<tr>
    <th>ID</th>
    <th>Job Ref</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Status</th>
    <th>Change Status</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>

<td><?php echo $row["eoi_id"]; ?></td>

<td><?php echo $row["job_ref"]; ?></td>

<td>
<?php
echo $row["first_name"] .
" " .
$row["last_name"];
?>
</td>

<td><?php echo $row["email"]; ?></td>

<td><?php echo $row["phone"]; ?></td>

<td><?php echo $row["status"]; ?></td>

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

<button
type="submit"
name="update_status">
Update
</button>

</form>

</td>

</tr>

<?php } ?>

</table>

<br>

<a href="logout.php">Logout</a>

</div>

<?php include 'footer.inc'; ?>

</body>
</html>