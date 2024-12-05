<?php
    include ( "../../db.php");

    if( $_POST ) {
        $positionname=( isset( $_POST["positionname"]) ? $_POST["positionname"] : "");
        $createposition=$connection->prepare( "INSERT INTO positions( id, positionname )
            VALUES ( null, :positionname)");
        // Asign values from POST
        $createposition->bindParam( ":positionname", $positionname );
        $createposition->execute();
        header("location:index.php");
    }
?>

<?php include("../../templates/header.php"); ?>

<form class="card" action="" method="POST" enctype="multipart/form-data">
    <div class="card-header">
        <h2>Create New Position</h2>
    </div>
    <div class="card-body">
        <div class="d-flex">
            <div class="input-group w-50">
                <label for="positionname" class="input-group-text">Position name</label>
                <input type="text"
                    class="form-control" name="positionname" id="positionname" placeholder="Position Name">
            </div>
            <button type="submit" name="" id="" class="btn btn-success ms-auto">Create Position</button>
            <a name="" id="" class="btn btn-danger ms-2" href="index.php" role="button">Cancel</a>
        </div>
    </div>
    <div class="card-footer">
        
    </div>
</form>
<?php include("../../templates/footer.php"); ?>