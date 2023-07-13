<!DOCTYPE html>
<html lang="en">
     <head>
          <meta charset="UTF-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>File Share</title>
     </head>
     <body>

          <h1>Share Any Important Resources</h1>
          <form action="" method="post">
               <fieldset>
                    <p>
                         <label for="title">Title: </label>
                         <input type="text" id="title" name="title"/>
                    </p>

                    <p>
                         <label for="description">Description: </label>
                         <br>
                         <textarea name="description" id="description" cols="30" rows="10"></textarea>
                         <br>
                    </p>

                    <label for="keywords">Keywords:</label><br>
                    <input type="text" name="keywords" id="keywords"><br><br>

                    <label for="files">Upload Any Documents: </label>
                    <br>
                    <input type="file" id="files" name="files" accept="image/* , video/* , application/*"/>
                    <br><br>
                    <input type="submit" value="Share!">

               </fieldset>
          </form>

         <?php
         session_start();
         include "db.inc";
         $pdo = db_connect();

         if (isset($_POST["title"]) && isset($_POST["description"]) && isset($_POST["keywords"]) && isset($_POST["files"])) {
             $email = $_SESSION['email'];
             $title = $_POST['title'];
             $description = $_POST['description'];
             $keywords = $_POST['keywords'];

             $file = $_FILES["files"];
             $fileName = $file["name"];
             $fileTempName = $file["tmp_name"];
             $fileType = $file["type"];

             if ($_FILES['files']['error'] != UPLOAD_ERR_OK) {
                 die("Upload unsuccessful!<br>\n");
             } else {
                 $filex = pathinfo(pathinfo($fileName, PATHINFO_EXTENSION));
                 $fileExLc = strtolower($filex);

                 if ($fileType != "mb4") {
                     $newFileName = uniqid() . '.' . $fileExLc;
                 } else {
                     $newFileName = uniqid("video-", true) . '.' . $fileExLc . $fileType;
                 }
                 move_uploaded_file($fileTempName, "images/" . $newFileName);

                 $sql = "INSERT INTO `file_sharing`(`email`, `title`, `description`, `keyboards`, `files`) VALUES (?,?,?,?,?)";
                 $statement = $pdo->prepare($sql);

                 $statement->bindParam(1, $email);
                 $statement->bindParam(2, $title);
                 $statement->bindParam(3, $description);
                 $statement->bindParam(4, $keywords);
                 $statement->bindParam(5, $newFileName);
                 $statement->execute();

                 echo 'File uploaded successfully.';

             }

         }
         ?>
     </body>
</html>