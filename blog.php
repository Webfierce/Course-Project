<?php
require "header.php";
date_default_timezone_set('Africa/Johannesburg');
include 'includes/classes/comments.php';
include 'includes/dbh.inc.php';

require "includes/init.php";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="css/blog.css">
  </head>
  <body>
  <div id="badge">

  <div class="header">

  </div>

  <section class="all">

    <div class="info">
      <div class="total">
        <span>2</span> Comments
      </div>
      <button class="c_Btn" id="cBtn">Add Comment</button>
      <div style="clear: both;"></div>
    </div>
    <div class='list'>
    <div class='mask'></div>
    <?php
    function getComments($conn) {
      $id = $row['id'];
      $sql = "SELECT * FROM comments AND users WHERE id='$id'";
      $result = $conn->query($sql);
      while ($row = $result->fetch_assoc()) {
            echo "<section class='first'>

                     <div class='img'>
                      <img src='includes/".$row['user_image']."'  alt='Avatar' />
                     </div>

                     <div class='comments'>
                       <h3>".$row['username']."</h3>
                       <p>".$row['message']." </p>
                       <h5>".$row['date']." </h5>
                     </div>
                    </section>";
        }
     }
    ?>
    </div>
    <?php
    echo "<div class='messageBox' id='commentModal'>
             <form action='".setComments($conn)."' method='POST'>
                <input type='hidden' name='uid' hidden value='".$_SESSION['user_id']."'>
                <input type='hidden' name='date_time' hidden value='".date('Y-m-d H:i:s')."'>
                <textarea class='message' name='message' rows='4' cols='40'></textarea>
                <button class='commentBtn' type='submit' name='commentSubmit'>Comment</button>
             </form>
          </div>";
   ?>
  <script type="text/javascript">
     // Get DOM Elements
     const messageBox = document.querySelector('#commentModal');
     const modalBtn = document.querySelector('#cBtn');

     // Events
     modalBtn.addEventListener('click', openComment);
     window.addEventListener('click', outsideClick);

     // Open
     function openComment() {
       messageBox.style.display = 'block';
     }

     // Close If Outside Click
     function outsideClick(e) {
       if (e.target == messageBox) {
         messageBox.style.display = 'none';
       }
     }

  </script>
  </body>
</html>
