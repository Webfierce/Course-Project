<?php
require "header.php";
require 'includes/init.php';

if(isset($_SESSION['user_id']) && isset($_SESSION['email'])){
    $user_data = $user_obj->find_user_by_id($_SESSION['user_id']);
    if($user_data ===  false){
        header('Location: logout.php');
        exit;
    }
}
// IF USER MAKING SIGNUP REQUEST
if(isset($_POST['username']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['phone'])
 && isset($_POST['date']) && isset($_POST['gender'])){
   //echo '<h1> yes </h1>';
  $result = $user_obj->editUser($_POST['username'],$_POST['firstname'],$_POST['lastname'],$_POST['email'],$_POST['phone'],$_POST['date'],$_POST['gender'],$_FILES['image_file']);
}else{
   //echo '<h1> no </h1>';
}

// TOTAL REQUESTS
$get_req_num = $frnd_obj->request_notification($_SESSION['user_id'], false);
// TOTAL FRIENDS
$get_frnd_num = $frnd_obj->get_all_friends($_SESSION['user_id'], false);
$get_all_req_sender = $frnd_obj->request_notification($_SESSION['user_id'], true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo  $user_data->username;?></title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
</head>
<body>
    <div class="profile_container">

        <div class="inner_profile">
            <div class="img">
                <img src="includes/classes/<?php echo $user_data->user_image; ?>" alt="Profile image" height="100%">
            </div>
            <h1><?php echo  $user_data->username;?></h1>
            <nav>
            <ul>
                <li><a href="profile.php" rel="noopener noreferrer">Home</a></li>
                <li><a href="notifications.php" rel="noopener noreferrer">Requests<span class="badge <?php
                if($get_req_num > 0){
                    echo 'redBadge';
                }
                ?>"><?php echo $get_req_num;?></span></a></li>
                <li><a href="friends.php" rel="noopener noreferrer">Friends<span class="badge"><?php echo $get_frnd_num;?></span></a></li>
                <li><a href="edit-profile.php" rel="noopener noreferrer" class="active">Edit profile</a></li>
                <li><a href="logout.php" rel="noopener noreferrer">Logout</a></li>
            </ul>
        </nav>
            <div class="editBox">
              <form>
                <?php
                echo '<span>Firstname: </span><input class="editInput" type="text" value='.$user_data->user_firstname.'><br/>';
                echo '<span>Lastname: </span><input class="editInput" type="text" value='.$user_data->user_lastname.'><br/>';
                echo '<span>Email: </span><input class="editInput" type="text" value='.$user_data->user_email.'><br/>';
                echo '<span>Phone: </span><input class="editInput" type="text" value='.$user_data->user_phone.'><br/>';
                echo '<span>Date: </span><input class="editInput" type="text" value='.$user_data->user_date.'><br/>';
                echo '<span>Gender: <br/></span>';
                echo '<input type="radio" name="gender" value="m"/><span >Male</span><br/>';
                echo '<input type="radio" name="gender" value="f"/><span >Female</span><br/>';
                echo '<button type="submit" class="saveBtn">Save</button>';
                ?>
              </form>
            </div>
        </div>
    </div>
</body>
</html>
