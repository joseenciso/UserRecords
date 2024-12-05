<?php 
    include("../../db.php");
    include("../../templates/header.php");

    $connemployees=$connection->prepare( "SELECT *,
        ( SELECT positionname FROM positions
            WHERE positions.id=employees.idposition limit 1 ) as position
        FROM employees" );
    $connemployees->execute();
    $employeeslist=$connemployees->fetchAll( PDO::FETCH_ASSOC);

    if ( isset( $_GET['id'])) {
        $id=( isset($_GET['id']))  ? $_GET['id'] : "";
        $file_select=$connection->prepare("SELECT photo,cv FROM employees WHERE id=:id");
        $file_select->bindParam("id", $id);
        $file_select->execute();
        $photo_cv=$file_select->fetch(PDO::FETCH_LAZY);
        print_r($photo_cv);
        if( isset($photo_cv['photo']) && $photo_cv['photo']!="" ) {
            if( file_exists("./".$photo_cv['photo']) ) {
                unlink("./".$photo_cv['photo']);
            }
        }
        if( isset($photo_cv['cv']) && $photo_cv!="" ){
            if ( file_exists("./".$photo_cv['cv']) ) {
                unlink("./".$photo_cv['cv']);
            }
        } 
        $del=$connection->prepare("DELETE FROM emplyees WHERE id=:id");
        $del->bindParam(":id", $id);
        $del->execute();
        header("Location: index.php");
    }
?>
<div class="card">
    <div class="card-header d-flex">
        <h2>List Employees</h2></th>
        <a href="create.php" class="btn btn-primary w-25 ms-auto" role="button">New Employee</a>
    </div>
    <table class="table table-responsive p-2" id="table_id">
        <thead>
            <tr>
                <th scope="col" class="text-center">Photo</th>
                <th scope="col">Name</th>
                <th scope="col">CV</th>
                <th scope="col">Position</th>
                <th scope="col">Start Date</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody class="card-body">
            
            <?php foreach( $employeeslist as $employee ){ ?>
                <tr class="">
                    <td class="w-25 text-center">
                        <img class="img-fluid rounded" src="<?php echo $employee['photo']; ?>" alt="<?php echo $employee['photo']; ?>" srcset="" />
                    </td>
                    <td><?php echo $employee['firstname']." ".$employee['lastname']; ?></td>
                    <td><?php echo $employee['cv']; ?></td>
                    <td><?php echo $employee['position']; ?></td>
                    <td><?php echo $employee['startdate']; ?></td>
                    <td class="text-center">
                        <a href="edit.php?id=<?php echo $employee['id']?>" class="btn btn-info">Edit</a>
                        <a href="index.php?id=<?php echo $employee['id']?>" class="btn btn-danger">Delete</a>
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