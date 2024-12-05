<?php
    include("../../db.php");
    include("../../templates/header.php");

    $fetchpositions=$connection->prepare("SELECT * FROM positions");
    $fetchpositions->execute();
    $positions=$fetchpositions->fetchAll(PDO::FETCH_ASSOC);

    if ( $_POST ) {
        $firstname=(isset($_POST['firstname']) ? $_POST['firstname'] : "");
        $middlename=(isset($_POST['middlename']) ? $_POST['middlename'] : "");
        $lastname=(isset($_POST['lastname']) ? $_POST['lastname'] : "");
        $email=(isset($_POST['email']) ? $_POST['email'] : "");
        $photo=(isset($_FILES['photo']['name']) ? $_FILES['photo']['name'] : "");
        $cv=(isset($_FILES['cv']['name']) ? $_FILES['cv']['name'] : "");
        $startdate=(isset($_POST['startdate']) ? $_POST['startdate'] : "");
        $position=(isset($_POST['position']) ? $_POST['position'] : "");
    
        $conn=$connection->prepare( "INSERT INTO `employees` (`id`, `firstname`, `middlename`, `lastname`, `photo`, `cv`, `email`, `idposition`, `startdate` )
            VALUES (NULL, :firstname, :middlename, :lastname, :photo, :cv, :position, :email, :startdate)" );
        $conn->bindParam(":firstname", $firstname);
        $conn->bindParam(":middlename", $middlename);
        $conn->bindParam(":lastname", $lastname);
        $conn->bindParam(":email", $email);
        $filedate=new DateTime();
        $photoname=($photo!="") ? $filedate->getTimestamp()."_".$_FILES['photo']['name'] : "";
        $tmp_photo=$_FILES['photo']['tmp_name'];
        if($tmp_photo!="") {
            move_uploaded_file($tmp_photo, "./".$photoname);
        }
        $conn->bindParam(":photo", $photoname);
        $cvname=($cv!="") ? $filedate->getTimestamp()."_".$_FILES["cv"]["name"] : "";
        $tmp_cv=$_FILES['cv']['tmp_name'];
        if($tmp_cv!=""){
            move_uploaded_file($tmp_cv,"./".$cvname);
        }
        $conn->bindParam(":cv", $cvname);
        $conn->bindParam(":startdate", $startdate);
        $conn->bindParam(":position", $position);
        $conn->execute();
    }
?>

<form action="" method="POST" enctype="multipart/form-data" class="card">
    <div class="card-header">
        <h2>Create Employee</h2>
    </div>
    <div class="card-body w-75 mx-auto">
        <div class="mb-3">
            <label for="fname" class="form-label">First Name</label>
            <input type="text" class="form-control" name="firstname" id="fname" aria-describedby="First Name" placeholder="First Name">
        </div>
        <div class="mb-3">
            <label for="fname" class="form-label">Middle Name</label>
            <input type="text" class="form-control" name="middlename" id="mname" aria-describedby="Middle Name" placeholder="Middle Name">
        </div>
        <div class="mb-3">
            <label for="lname" class="form-label">Last Name</label>
            <input type="text" class="form-control" name="lastname" id="lname" aria-describedby="Last Name" placeholder="Last Name">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelpId" placeholder="abc@mail.com">
            <small id="emailHelpId" class="form-text text-muted">Help text</small>
        </div>
        <div class="mb-3">
            <label for="profile-picture" class="form-label">Profile Picture</label>
            <input type="file" class="form-control" name="photo" id="profile-picture" placeholder="Profile Picture" aria-describedby="fileHelpId">
        </div>
        <div class="mb-3">
            <label for="cv" class="form-label">Slect CV</label>
            <input type="file" class="form-control" name="cv" id="cv" placeholder="cv" aria-describedby="cv">
        </div>
        <div class="mb-3">
            <label for="position" class="form-label">Position</label>
            <select class="form-select form-select w-50" name="position" id="position">
                <option selected>Select position</option>
                <?php foreach ( $positions as $position ) { ?>
                    <option value="<?php echo $position['id'] ?>"><?php echo $position['positionname'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="start-date" class="form-label">Start Date</label>
            <input type="date" class="form-control w-50" name="startdate" id="start-date" placeholder="start-date">
        </div>
    </div>
    <div class="card-footer text-center">
        <button type="submit" name="" id="" class="btn btn-success" role="button">Create</button>
        <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancel</a>
    </div>
</form>
<?php include("../../templates/footer.php"); ?>