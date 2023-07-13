<!DOCTYPE html>
<html lang="en">
     <head>
          <meta charset="UTF-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Document</title>
     </head>
     <body>
          <h1>Search for Valuable Information</h1>
          <fieldset>
               <form id="search-form" action="first_interface.php" method="post">
                    <div>
                         <label for="search">Search:</label>
                         <input type="search" id="search" name="search"
                                placeholder="Enter keywords, members, or topics">
                    </div>
                    <br>
                    <div>
                         <p>Select What You Need:</p>
                         <label for="relevant">Resources</label>
                         <input type="radio" name="types" id="relevant" value="relevant">
                         <br>
                         <label for="experts">Experts</label>
                         <input type="radio" name="types" id="experts" value="experts">
                         <br>
                         <label for="discussions">Relevant Discussions</label>
                         <input type="radio" name="types" id="discussions" value="discussions">
                         <br><br>
                    </div>
                    <br>
                    <div>
                         <input type="submit" value="Search">
                    </div>
               </form>
               <br>
          </fieldset>

          <br>
          <p><a href="./sign_in.php">SIGN UP</a> or <a href="./log_in.php">LOG IN</a> FOR MORE PERKS!!</p>

               <!--I wanted to say keywords and only realized it was keyboards towards the end of my project-->
         <?php
         session_start();
         include "db.inc";
         $pdo = db_connect();
         if (isset($_POST["search"])) {
             $keyword = $_POST["search"];
             $radio = $_POST["types"];
             if ($radio == "relevant") {
                 $sql = "SELECT `title`, `email`, `description` FROM `file_sharing` WHERE `keyboards`= ? or `title` = ? or `description` like CONCAT('%', ?, '%') ";
                 $statement = $pdo->prepare($sql);
                 if ($statement) {
                     $statement->bindValue(1, $keyword);
                     $statement->bindValue(2, $keyword);
                     $statement->bindValue(3, $keyword);
                     $statement->execute();

                     echo '<table border="1" width="50%" cellpadding="2">';
                     echo '<tr><th>Title</th><th>Author</th><th>Description</th></tr>';

                     while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                         echo '<tr>';
                         echo '<td>' . $row['title'] . '</td>';
                         echo '<td>' . $row['email'] . '</td>';
                         echo '<td>' . $row['description'] . '</td>';
                         echo '</tr>';
                     }

                     echo '</table>';
                 }
             }
             if ($radio == "experts") {
                 $sql = "SELECT  `level_experience`,`name`, `bio` FROM `user_profile` WHERE `level_experience` = ? or `name` = ? or `bio` like CONCAT('%', ?, '%')";
                 $statement = $pdo->prepare($sql);
                 if ($statement) {
                     $statement->bindValue(1, $keyword);
                     $statement->bindValue(2, $keyword);
                     $statement->bindValue(3, $keyword);
                     $statement->execute();

                     echo '<table border="1" width="50%" cellpadding="2">';
                     echo '<tr><th>Title</th><th>Author</th><th>Description</th></tr>';

                     while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                         echo '<tr>';
                         echo '<td>' . $row['level_experience'] . '</td>';
                         echo '<td>' . $row['name'] . '</td>';
                         echo '<td>' . $row['bio'] . '</td>';
                         echo '</tr>';
                     }

                     echo '</table>';
                 }
             }
             if ($radio == "discussions") {
                 $sql = "SELECT `title`, `email`, `description` FROM `knowledge_base` WHERE `keywords`= ? or `title` = ? or `description` like CONCAT('%', ?, '%') ";
                 $statement = $pdo->prepare($sql);
                 if ($statement) {
                     $statement->bindValue(1, $keyword);
                     $statement->bindValue(2, $keyword);
                     $statement->bindValue(3, $keyword);
                     $statement->execute();

                     echo '<table border="1" width="50%" cellpadding="2">';
                     echo '<tr><th>Title</th><th>Author</th><th>Description</th></tr>';

                     while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                         echo '<tr>';
                         echo '<td>' . $row['title'] . '</td>';
                         echo '<td>' . $row['email'] . '</td>';
                         echo '<td>' . $row['description'] . '</td>';
                         echo '</tr>';
                     }

                     echo '</table>';
                 }
             }
         }
         ?>
     </body>
</html>