<?php

// Insert Comments into database
function setComments($conn) {
  if (isset($_POST['commentSubmit'])) {
    $uid = $_POST['uid'];
    $date = $_POST['date_time'];
    $message = $_POST['message'];

    $sql = "INSERT INTO comments (c_id, date, message) VALUES ('$uid', '$date', '$message')";
    $result = $conn->query($sql);
  } 
}

?>
