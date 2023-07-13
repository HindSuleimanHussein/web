<!DOCTYPE html>
<html lang="en">
     <head>
          <meta charset="UTF-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Document</title>
     </head>
     <body>
          <h1>Create and Publish Articles</h1>
          <form action="knowledge_base.php" method="post">
               <fieldset>
                    <p>
                         <label for="title">Title: </label>
                         <input type="text" id="title" name="title"/>
                    </p>

                    <p>
                         <label for="description">Description of Your Article: </label>
                         <br>
                         <textarea name="description" id="description" cols="30" rows="10"></textarea>
                         <br>
                    </p>

                    <label for="body-text">Body of Your Article</label>
                    <br>
                    <textarea name="body-text" id="body-text" cols="30" rows="10"></textarea>
                    <br>

                    <label for="keywords">Keywords:</label><br>
                    <input type="text" name="keywords" id="keywords">
                    <br><br>

                    <label for="imageOrVideo">Upload Your Article's Image or Video: </label>
                    <br>
                    <input type="file" id="imageOrVideo" name="imageOrVideo" accept="image/*, video/*"/>

                    <br>
                    <input type="submit" value="Create and Publish Article">
               </fieldset>
          </form>

         <?php
         session_start();
         include "db.inc";
         $pdo = db_connect();
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $email = $_SESSION['email'];
         if (isset($_POST["title"]) && isset($_POST["description"]) && isset($_POST["body-text"]) && isset($_POST["keywords"]) && isset($_POST["imageOrVideo"])) {
             $email = $_SESSION['email'];

             $title = $_POST['title'];
             $description = $_POST['description'];
             $keywords = $_POST['keywords'];
             $body = $_POST['body-text'];

             // File upload handling
             $file = $_FILES["imageOrVideo"];
             $fileName = $file["name"];
             $fileTempName = $file["tmp_name"];
             $fileType = $file["type"];


                 if ($fileType != "mb4") {
                     $filex = pathinfo(pathinfo($fileName, PATHINFO_EXTENSION));
                     $fileExLc = strtolower($filex);
                     $newFileName = uniqid() . '.' . $fileExLc;
                 } else {
                     $filex = pathinfo(pathinfo($fileName, PATHINFO_EXTENSION));
                     $fileExLc = strtolower($filex);
                     $newFileName = uniqid("video-", true) . '.' . $fileExLc;
                 }


             $sql = "INSERT INTO `knowledge_base`(`email`, `title`, `description`, `keywords`, `body_text`, `relevant_file`) VALUES (?,?,?,?,?,?)";

             $stmt = $pdo->prepare($sql);
             if ($stmt) {
                 $stmt->bindValue(1, $email);
                 $stmt->bindValue(2, $title);
                 $stmt->bindValue(3, $description);
                 $stmt->bindValue(4, $keywords);
                 $stmt->bindValue(5, $body);
                 $stmt->bindValue(6, $newFileName);
                 $stmt->execute();
                 echo 'Article created successfully!';
                 exit;
             } else {
                 echo 'Failed to prepare the SQL statement.';
                 exit;

             }
         }
        }
         ?>

     </body>
</html>