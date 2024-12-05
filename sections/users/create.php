<?php 
    include("../../db.php");
    include("../../templates/header.php"); 

    if( $_POST ) {
        $username=(isset($_POST["username"]) ? $_POST["username"] : "");
        $useremail=(isset($_POST["useremail"]) ? $_POST["useremail"] : "");
        $userpassword=(isset($_POST["userpassword"]) ? $_POST["userpassword"] : "");
        $createuser=$connection->prepare("INSERT INTO users( id, username, email, password )
            VALUE( NULL, :username, :useremail, :userpassword )");
        $createuser->bindParam(":username", $username );
        $createuser->bindParam(":useremail", $useremail );
        $createuser->bindParam(":userpassword", $userpassword );
        $createuser->execute();
    }
?>
<form class="card" action="" method="POST" enctype="multipart/form-data">
    <div class="card-header">
        <h2>Create New User</h2>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="user-name" class="form-label">User name</label>
            <input type="text" class="form-control" name="username" id="user-name" placeholder="User Name">
        </div>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="useremail" id="email" placeholder="Email">
        </div>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="userpassword" id="password" placeholder="Password">
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex">
            <button type="submit" name="" id="" class="btn btn-success mx-auto">Create New User</button>
            <a name="" id="" class="btn btn-danger mx-auto" href="index.php" role="button">Cancel</a>
        </div>
    </div>
</form>
<?php include("../../templates/footer.php"); ?>