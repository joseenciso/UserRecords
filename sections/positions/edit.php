<?php
    include ( "../../db.php");

    if ( isset( $_GET['positionid'] )){

        $positionid=( isset( $_GET['positionid'] )) ? $_GET['positionid'] : "";
        $fetchposition=$connection->prepare( "SELECT * FROM positions WHERE id=:id" );
        $fetchposition->bindParam(":id", $positionid);
        $fetchposition->execute();
        $positioninfo=$fetchposition->fetch( PDO::FETCH_LAZY);
        $positionname=$positioninfo["positionname"];
    }
    
    if ( $_POST ) {
        $positionname=( isset( $_POST["positionname"]) ? $_POST["positionname"] : "" );
        $editposition=$connection->prepare( "UPDATE positions SET positionname=:positionname
            WHERE id=:id" );
        $editposition->bindParam( ":positionname", $positionname );
        $editposition->bindParam( ":id", $positionid );
        $editposition->execute();
        header("Location:index.php");
    }
?>

<?php include("../../templates/header.php"); ?>

<form class="card" action="" method="POST" enctype="multipart/form-data">
    <div class="card-header">
        <h2>Edit Position</h2>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="positionname" class="form-label">Position name</label>
            <input type="text"
                class="form-control" name="positionname" id="positionname" placeholder="Position Name" value="<?php echo $positionname; ?>">
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex">
            <button type="submit" name="" id="" class="btn btn-success mx-auto">Edit Position</button>
            <a name="" id="" class="btn btn-danger mx-auto" href="index.php" role="button">Cancel</a>
        </div>
    </div>
</form>
<?php include("../../templates/footer.php"); ?>