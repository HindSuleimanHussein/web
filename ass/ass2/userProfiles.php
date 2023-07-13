<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h2>Create User Profile</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" name="name">
        <br>
        <br>

        <label for="photo">Photo (PNG, GIF, JPEG):</label>
        <input type="file" name="photo" accept=".png, .jpg, .jpeg, .gif">
        <br>
        <br>
    
        <label for="bio">Bio:</label>
        <textarea name="bio" required></textarea>
        <br>
        <br>

        <label for="cv">CV (PDF):</label>
        <input type="file" name="cv" accept="application/pdf">
        <br>
        <br>

        <label for="area_experience">Area of Experience:</label>
        <input type="text" name="area_experience" required>
        <br>
        <br>

        <label for="level_experience">Level of Experience:</label>
        <select name="level_experience">
            <option value="default" disabled selected>Choose a Level of Experience</option>
            <option value="beginner">Beginner</option>
            <option value="intermediate">Intermediate</option>
            <option value="advanced">Advanced</option>
            <option value="expert">Expert</option>
        </select>
        <br><br>

        <label for="area_interest">Area of Interest:</label>
        <input type="text" name="area_interest" required>
        <br><br>

        <input type="submit" value="Edit Profile">
        <br>
    </form>

    <?php
    session_start();
    include "db.inc";
    $pdo = db_connect();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_SESSION['email'];

        // Retrieve the form data
        $name = $_POST['name'];
        $photo = $_FILES["photo"];
        $cv = $_FILES["cv"];
        $bio = $_POST['bio'];
        $area_experience = $_POST['area_experience'];
        $level_experience = $_POST['level_experience'];
        $area_interest = $_POST['area_interest'];

        // Check file types and move the uploaded files to a suitable location
        $validImageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $validPdfExtensions = ['pdf'];

        $photoName = $photo['name'];
        $photoSize = $photo['size'];
        $photoTmpName = $photo['tmp_name'];
        $cvName = $cv['name'];
        $cvType = $cv['type'];
        $cvSize = $cv['size'];
        $cvTmpName = $cv['tmp_name'];

        $photoExtension = strtolower(pathinfo($photoName, PATHINFO_EXTENSION));
        $cvExtension = strtolower(pathinfo($cvName, PATHINFO_EXTENSION));

        if (!in_array($photoExtension, $validImageExtensions)) {
            echo "Invalid Image Extension";
        } elseif ($photoSize > 1000000) {
            echo "Image Size Is Too Large";
        } elseif (!in_array($cvExtension, $validPdfExtensions)) {
            echo "Invalid PDF Extension";
        } else {
            $newPhotoName = uniqid() . '.' . $photoExtension;
            $newPdfName = uniqid() . '.' . $cvExtension;

            move_uploaded_file($photoTmpName, 'images/' . $newPhotoName);
            move_uploaded_file($cvTmpName, 'pdf/' . $newPdfName);

            // Insert the user profile into the database
            $sql = "INSERT INTO user_profile(email, name, photo, cv, area_experience, level_experience, area_interest, bio)
             VALUES (?,?,?,?,?,?,?,?)";

            $stmt = $pdo->prepare($sql);
            if ($stmt) {
                $stmt->bindValue(1, $email);

                $checkSql = "SELECT * FROM user_profile WHERE email = ?";
                $checkStmt = $pdo->prepare($checkSql);
                $checkStmt->bindValue(1, $email);
                $checkStmt->execute();

                $existingProfile = $checkStmt->fetch(PDO::FETCH_ASSOC);
                 if ($existingProfile) {
                     echo 'A profile has already been created for this email.';
                     header("Location: main_interface.html");
                } else {
                $stmt->bindValue(1, $email);
                $stmt->bindValue(2, $name);
                $stmt->bindValue(3, $newPhotoName);
                $stmt->bindValue(4, $newPdfName);
                $stmt->bindValue(5, $area_experience);
                $stmt->bindValue(6, $level_experience);
                $stmt->bindValue(7, $area_interest);
                $stmt->bindValue(8, $bio);

                $stmt->execute();
                echo 'User profile created successfully!';
                header("Location: main_interface.html");

            }
        }
        }
    }
    ?>
    
</body>
</html>
