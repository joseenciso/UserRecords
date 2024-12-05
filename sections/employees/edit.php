<?php
    include("../../db.php");
    include("../../templates/header.php");

    $fetchpositions=$connection->prepare("SELECT * FROM positions");
    $fetchpositions->execute();
    $positions=$fetchpositions->fetchAll(PDO::FETCH_ASSOC);

    if ( isset($_GET['id'])) {
        $id=(isset($_GET['id'])) ? $_GET['id'] : "";
        $fetch=$connection->prepare("SELECT * FROM employees WHERE id=:id");
        $fetch->bindParam(":id", $id);
        $fetch->execute();
        $info=$fetch->fetch( PDO::FETCH_LAZY);

        $firstname=$info['firstname'];
        $middlename=$info['middlename'];
        $lastname=$info['lastname'];
        $email=$info['email'];
        $photo=$info['photo'];
        $cv=$info['cv'];
        $idposition=$info['idposition'];
        $startdate=$info['startdate'];
    }

    if ( isset($_POST['id']) ) {
        $id=(isset($_POST['id'])) ? $_POST['id'] : "";

        $firstname=(isset( $_POST["firstname"]) ? $_POST["firstname"] : "");
        $middlename=(isset( $_POST["middlename"]) ? $_POST["middlename"] : "");
        $lastname=(isset( $_POST["lastname"]) ? $_POST["lastname"] : "");
        $email=(isset( $_POST["email"]) ? $_POST["email"] : "");
        $idposition=(isset( $_POST[""]) ? $_POST[""] : "");
        $startdate=(isset( $_POST[""]) ? $_POST[""] : "");
        
        $updatequery=$connection->prepare("UPDATE employees SET
            firstname=:firstname,
            middlename=:middlename,
            lastname=:lastname,
            email=:email,
            idposition=:idposition,
            startdate:startdate
            WHERE id=:id");

        $updatequery->bindParam(":firstname", $firstname);
        $updatequery->bindParam(":middlename", $middlename);
        $updatequery->bindParam(":laststname", $lastname);
        $updatequery->bindParam(":email", $email);
        $updatequery->bindParam(":idposition", $idposition);
        $updatequery->bindParam(":startdate", $startdate);
        $updatequery->bindParam(":id", $id);
        $updatequery->execute();

        $currentdate=new DateTime();
        $photo=(isset( $_FILES["photo"]['name']) ? $_FILES["photo"]['name'] : "");
        $filename_photo=($photo!="") ? $currentdate->getTimestamp()."_".$_FILES['photo']['name'] : "";
        $tmp_photo=$_FILES['photo']['tmp_name'];
        if ( $tmp_photo!="" ) {
            move_uploaded_file($tmp_photo, "./".$filename_photo);

            $select=$connection->prepare("SELECT photo FROM employees WHERE id=:id");
            $select->bindParam(":id", $id);
            $select->execute();

            $delphoto=$select->fetch( PDO::FETCH_LAZY );
            if ( isset( $delphoto['photo'] ) && $delphoto['photo']!="" ) {
                if ( file_exists( "./".$delphoto['photo']) ) {
                    unlink("./".$delphoto['photo']);
                }
            }

            $updatequery=$connection->prepare(" UPDATE emplyees SET
                photo=:photo WHERE id=:id ");
            $updatequery->bindParam(":photo", $filename_photo);
            $updatequery->bindParam(":id", $id);
            $updatequery->execute();
        }
        
        $cv=(isset( $_FILES["cv"]['name']) ? $_FILES["cv"]['name'] : "");
        $filename_cv=($cv!="") ? $currentdate->getTimestamp()."_".$_FILES['photo']['name'] : "";
        $tmp_cv=$_FILES['cv']['tmp_name'];
        if ( $tmp_cv!="" ) {
            move_uploaded_file($tmp_cv, "./".$filename_cv);

            $select=$connection->prepare("SELECT cv FROM employees WHERE id=:id");
            $select->bindParam(":id", $id);
            $select->execute();

            $delcv=$select->fetch( PDO::FETCH_LAZY );
            if ( isset( $delcv['cv'] ) && $delcv['cv']!="" ) {
                if ( file_exists( "./".$delcv['cv']) ) {
                    unlink("./".$delcv['cv']);
                }
            }

            $updatequery=$connection->prepare(" UPDATE emplyees SET
                cv=:cv WHERE id=:id ");
            $updatequery->bindParam(":cv", $filename_cv);
            $updatequery->bindParam(":id", $id);
            $updatequery->execute();
        }

        header("Location:index.php");
    }
?>

<form action="" method="POST" enctype="multipart/form-data" class="card">
    <div class="card-header">
        <h2>Edit Employee</h2>
    </div>
    <div class="card-body w-75 mx-auto">
        <div class="mb-3 w-50">
            <label for="fname" class="form-label">First Name</label>
            <input type="text" class="form-control" name="firstname" id="fname" placeholder="First Name" value="<?php echo $firstname; ?>">
        </div>
        <div class="mb-3 w-50">
            <label for="fname" class="form-label">Middle Name</label>
            <input type="text" class="form-control" name="middlename" id="mname" placeholder="Middle Name" value="<?php echo $middlename; ?>">
        </div>
        <div class="mb-3 w-50">
            <label for="lname" class="form-label">Last Name</label>
            <input type="text" class="form-control" name="lastname" id="lname" placeholder="Last Name" value="<?php echo $lastname; ?>">
        </div>
        <div class="mb-3 w-50">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="abc@mail.com" value="<?php echo $info['email']; ?>">
            <small id="emailHelpId" class="form-text text-muted">Help text</small>
        </div>
        <div class="mb-3 w-75">
            <label for="profile-picture" class="form-label">Profile Picture</label>
            <span><?php echo $info['photo']; ?></span>
            <div class="img-container d-flex">
                <input type="file" class="form-control my-auto me-2" name="photo" id="profile-picture" placeholder="Profile Picture" value="<?php echo $info['photo']; ?>">
                <img src="<?php echo $info['photo']; ?>" alt="<?php echo $info['photo']; ?>" class="w-25 ms-auto">
            </div>
        </div>
        <div class="mb-3 w-75">
            <label for="cv" class="form-label d-block">CV:</label>
            <a href="<?php echo $info['cv']; ?>"><?php echo $info['cv']; ?></a>
            <input type="file" class="form-control" name="cv" id="cv" placeholder="cv" value="<?php echo $info['cv']; ?>">
        </div>
        <div class="mb-3 w-50">
            <label for="position" class="form-label d-block">Position</label>
            <select class="form-select form-select" name="position" id="position">
                <?php foreach ( $positions as $position ) { ?>
                    <option <?php echo ($idposition == $info['idposition']) ? "SELECTED" : ""?> value="<?php echo $position['id'] ?>"><?php echo $position['positionname'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3 w-50">
            <label for="start-date" class="form-label">Start Date</label>
            <input type="date" class="form-control text-center" value="<?php echo $startdate; ?>" name="startdate" id="start-date" placeholder="start-date">
        </div>
    </div>
    <div class="card-footer text-center">
        <button type="submit" name="" id="" class="btn btn-success" role="button">Create</button>
        <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancel</a>
    </div>
</form>
<?php include("../../templates/footer.php"); ?>