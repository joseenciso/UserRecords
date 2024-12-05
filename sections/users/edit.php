<?php
    include("../../templates/header.php");
    include("../../db.php");

    if ( isset($_GET['userid']) ) {
        $userid=(isset($_GET['userid']) ? $_GET['userid'] : "");
        $getuser=$connection->prepare("SELECT * FROM `users` WHERE id=:id");
        $getuser->bindParam(":id", $userid);
        $getuser->execute();
        $fetchuser=$getuser->fetch(PDO::FETCH_LAZY);
        $username=$fetchuser["username"];
        $useremail=$fetchuser["email"];
        $userpassword=$fetchuser["password"];
    }

    if ( $_POST ) {
        $userid=(isset($_GET['userid']) ? $_GET['userid'] : "");
        $username=(isset($_POST['username']) ? $_POST['username'] : "");
        $useremail=(isset($_POST['email']) ? $_POST['email'] : "");
        $userpassword=(isset($_POST['post']) ? $_POST['post'] : "");
        $postuser=$connection->prepare("UPDATE users SET username=:username, email=:email, password=:password
            WHERE id=:id");
        $postuser->bindParam(":username", $username);
        $postuser->bindParam(":email", $useremail);
        $postuser->bindParam(":password", $userpassword);
        $postuser->bindParam(":id", $userid);
        $postuser->execute();
        header("Location:index.php");
    }
?>
<form class="card" action="" method="POST" enctype="multipart/form-data">
    <div class="card-header">
        <h2>Edit User</h2>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="user-name" class="form-label">User name</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="User Name" value="<?php echo $username; ?>">
        </div>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="useremail" placeholder="Email" value="<?php echo $useremail; ?>">
        </div>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="userpassword" placeholder="Password" value="<?php echo $userpassword; ?>">
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex">
            <button type="submit" name="" id="" class="btn btn-success mx-auto">Edit User</button>
            <a name="" id="" class="btn btn-danger mx-auto" href="index.php" role="button">Cancel</a>
        </div>
    </div>
</form>
<?php include("../../templates/footer.php"); ?>