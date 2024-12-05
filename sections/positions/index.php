<?php
    include("../../db.php");

    if( $_POST ) {
        $positionname=( isset( $_POST["positionname"]) ? $_POST["positionname"] : "");
        $createposition=$connection->prepare( "INSERT INTO positions( id, positionname )
            VALUES ( null, :positionname)");
        // Asign values from POST
        $createposition->bindParam( ":positionname", $positionname );
        $createposition->execute();
        header("location:index.php");
    }

    if ( isset($_GET['positionid']) ) {
        $positionid=( isset($_GET['positionid'])) ? $_GET['positionid'] : "";
        $position=$connection->prepare( "DELETE FROM positions WHERE id=:id" );
        $position->bindParam( ":id", $positionid );
        $position->execute();
        header("Location:index.php");
    }

    $fetching=$connection->prepare("SELECT * FROM `positions`");
    $fetching->execute();
    $position_list=$fetching->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../../templates/header.php"); ?>

<div class="card">
    <div class="card-header d-flex">
        <h2>Positions</h2>
        <form class="ms-auto" action="" method="POST" enctype="multipart/form-data">
            <div class="input-group">
                <input type="text"
                    class="form-control" name="positionname" id="positionname" placeholder="Create New Position">
                    <button type="submit" name="" id="" class="btn btn-success">Create</button>
            </div>
        </form>
    </div>
    
    <table class="table table-responsive">
        <thead>
            <tr>
                <th scope="col" class="text-center">ID</th>
                <th scope="col">Position Name</th>
                <th scope="col" class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="card-body ">
            <?php foreach( $position_list as $position ) { ?>
                <tr class="">
                    <td scope="row" class="text-center"><?php echo $position['id'] ?></td>
                    <td><?php echo $position['positionname'] ?></td>
                    <td class="d-flex justify-content-center">
                        <a href="edit.php?positionid=<?php echo $position['id']; ?>" role="button" name="button-edit" id="btn-edit" class="btn btn-primary me-2">Edit</a>
                        <!--a href="index.php?positionid=<?php echo $position['id'];  ?>" role="button" name="button-delete" id="btn-delete" class="btn btn-danger">Delete</!--a-->
                        <a href="javascript:deletePosition(<?php echo $position['id']; ?>)" role="button" name="button-delete" id="btn-delete" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="card-footer text-muted">
        
    </div>
</div>

<script>
    function deletePosition(id) {
        //alert(id);
        Swal.fire( {
            title: `You are about to delete position with ID ${id} Do you wish to continue`,
            //showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Delete',
            //denyButtonText: 'Cancel',
        }).then( (result)  => {
            if ( result.isConfirmed ) {
                Swal.fire( 'Deleted!', '', 'Success');
                window.location=`index.php?positionid=${id}`;
            } else if ( result.isDenied ) {
                Swal.fire( 'Transaction cancelled', '', 'Info' );
            }
        });
    }
</script>

<?php include("../../templates/footer.php"); ?>