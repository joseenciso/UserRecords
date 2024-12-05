<?php
    include("../../db.php");
    include("../../templates/header.php"); 

    if ( isset( $_GET['userid'] ) ) {
        $userid=( isset( $_GET['userid']) ) ? $_GET['userid'] : "";
        $deleteuser=$connection->prepare( "DELETE FROM users WHERE id=:id" );
        $deleteuser->bindParam(":id", $userid);
        $deleteuser->execute();
        header("Location:index.php");
    }

    $fetchusers=$connection->prepare("SELECT * FROM `users`");
    $fetchusers->execute();
    $users=$fetchusers->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="card">
    <div class="card-header d-flex">
        <h2 class="me-auto">Users</h2>
        <a name="" id="new-position" class="btn btn-success" href="create.php" role="button">New User</a>
    </div>
    <table class="card-body table-responsive table" id="table_id">
        <thead>
            <tr>
                <th scope="col" class="text-center">ID</th>
                <th scope="col">User Name</th>
                <th scope="col">Email</th>
                <th scope="col">Password</th>
                <th scope="col" class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach( $users as $user ){ ?>
                <tr class="">
                    <td scope="row" class="text-center"><?php echo $user['id']?></td>
                    <td><?php echo $user['username']?></td>
                    <td><?php echo $user['email']?></td>
                    <td><?php echo $user['password']?></td>
                    <td>
                        <div class="d-flex">
                            <a href="edit.php?userid=<?php echo $user['id'] ?>" role="button" name="button-edit" id="btn-edit" class="btn btn-primary ms-auto me-1">Edit</a>
                            <a href="index.php?userid=<?php echo $user['id']; ?>" button" name="button-delete" id="btn-delete" class="btn btn-danger me-auto ms-1">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="card-footer text-muted">
        Footer
    </div>
</div>
<?php include("../../templates/footer.php"); ?>