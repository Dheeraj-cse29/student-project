<?php

$conn = mysqli_connect("localhost","root","","student_db",3307);

if(!$conn){
die("Connection failed");
}


/* ADD */
if(isset($_POST['add']))
{
$name=$_POST['name'];
$email=$_POST['email'];
$age=$_POST['age'];

mysqli_query($conn,"INSERT INTO students(name,email,age)
VALUES('$name','$email','$age')");

header("Location: students.php");
}


/* DELETE */

if(isset($_GET['delete']))
{
$id=$_GET['delete'];

mysqli_query($conn,"DELETE FROM students WHERE id=$id");

header("Location: students.php");
}


/* EDIT FETCH */

$editData=null;

if(isset($_GET['edit']))
{
$id=$_GET['edit'];

$res=mysqli_query($conn,"SELECT * FROM students WHERE id=$id");

$editData=mysqli_fetch_assoc($res);
}



/* UPDATE */

if(isset($_POST['update']))
{
$id=$_POST['id'];

$name=$_POST['name'];
$email=$_POST['email'];
$age=$_POST['age'];

mysqli_query($conn,"UPDATE students SET

name='$name',
email='$email',
age='$age'

WHERE id=$id");

header("Location: students.php");

}



/* SEARCH */

if(isset($_GET['search']))
{

$search=$_GET['search'];

$res=mysqli_query($conn,

"SELECT * FROM students WHERE name LIKE '%$search%'");

}

else{

$res=mysqli_query($conn,"SELECT * FROM students");

}

?>



<!DOCTYPE html>

<html>

<head>

<title>Student Management System</title>

<link rel="stylesheet" href="style.css">

</head>


<body>



<div class="container">

<h1>Student Management System</h1>



<div class="card">

<form method="POST">

<input type="hidden" name="id"

value="<?= $editData['id'] ?? '' ?>">



<input type="text"

name="name"

placeholder="Enter name"

value="<?= $editData['name'] ?? '' ?>"

required>



<input type="email"

name="email"

placeholder="Enter email"

value="<?= $editData['email'] ?? '' ?>"

required>



<input type="number"

name="age"

placeholder="Enter age"

value="<?= $editData['age'] ?? '' ?>"

required>



<?php if($editData){ ?>

<button class="btn-update" name="update">

Update Student

</button>

<?php } else { ?>

<button class="btn-add" name="add">

Add Student

</button>

<?php } ?>


</form>

</div>





<h2>Search Student</h2>


<form method="GET">

<input type="text"

name="search"

placeholder="Enter student name">


<button type="submit" class="search-btn">
Search
</button>
</form>





<h2>Student Records</h2>



<table>

<tr>

<th>ID</th>

<th>Name</th>

<th>Email</th>

<th>Age</th>

<th>Action</th>

</tr>



<?php while($row=mysqli_fetch_assoc($res)){ ?>


<tr>

<td><?= $row['id'] ?></td>

<td><?= $row['name'] ?></td>

<td><?= $row['email'] ?></td>

<td><?= $row['age'] ?></td>


<td>

<a class="edit"

href="?edit=<?= $row['id'] ?>">

Edit

</a>


<a class="delete"

href="?delete=<?= $row['id'] ?>"

onclick="return confirm('Delete?')">

Delete

</a>


</td>

</tr>


<?php } ?>


</table>



</div>



</body>

</html>