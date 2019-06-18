<?php
// user.php
class User{
    protected $db;
    protected $user_name;
    protected $user_firstname;
    protected $user_lastname;
    protected $user_email;
    protected $user_phone;
    protected $user_date;
    protected $user_gender;
    protected $user_pass;
    protected $hash_pass;

    function __construct($db_connection){
        $this->db = $db_connection;
    }

    // SING UP USER
    function singUpUser($username, $firstname, $lastname, $email, $phone, $date, $gender){
        try{
            $this->user_name = trim($username);
            $this->user_firstname = trim($firstname);
            $this->user_lastname = trim($lastname);
            $this->user_email = trim($email);
            $this->user_phone = trim($phone);
            $this->user_date = trim($date);
            $this->user_gender = trim($gender);

            if(!empty($this->user_name) && !empty($this->user_firstname) && !empty($this->user_lastname) && !empty($this->user_email)){

                if (filter_var($this->user_email, FILTER_VALIDATE_EMAIL)) {
                    $check_email = $this->db->prepare("SELECT * FROM `users` WHERE user_email = ?");
                    $check_email->execute([$this->user_email]);

                    if($check_email->rowCount() > 0){
                        return ['errorMessage' => 'This Email Address is already registered. Please Try another.'];
                    }
                    else{
                      $file = $_FILES['image_file'];

                      $fileName = $_FILES['image_file']['name'];
                      $fileTmpName = $_FILES['image_file']['tmp_name'];
                      $fileSize = $_FILES['image_file']['size'];
                      $fileError = $_FILES['image_file']['error'];
                      $fileType = $_FILES['image_file']['type'];

                      $fileExt = explode('.', $fileName);
                      $fileActualExt = strtolower(end($fileExt));

                      $allowed = array('jpg', 'jpeg', 'png');
                      if (in_array($fileActualExt, $allowed)) {
                        if ($fileError === 0) {
                          if ($fileSize < 500000) {
                            $fileNameNew = uniqid('', true).".".$fileActualExt;
                            $fileDestination = 'uploads/'.$fileNameNew;
                            move_uploaded_file($fileTmpName, $fileDestination);
                            include "password_inc.php";
                            $sql = "INSERT INTO `users` (user_firstname, user_lastname, username, user_email, user_phone, user_date, user_gender, user_password, user_image) VALUES(:user_firstname, :user_lastname, :username, :user_email, :user_phone, :user_date, :user_gender, :user_password, :user_image)";


                            $sign_up_stmt = $this->db->prepare($sql);
                            //BIND VALUES
                            $sign_up_stmt->bindValue(':user_firstname',$this->user_firstname, PDO::PARAM_STR);
                            $sign_up_stmt->bindValue(':user_lastname',$this->user_lastname, PDO::PARAM_STR);
                            $sign_up_stmt->bindValue(':username',htmlspecialchars($this->user_name), PDO::PARAM_STR);
                            $sign_up_stmt->bindValue(':user_email',$this->user_email, PDO::PARAM_STR);
                            $sign_up_stmt->bindValue(':user_phone',$this->user_phone, PDO::PARAM_STR);
                            $sign_up_stmt->bindValue(':user_date',$this->user_date, PDO::PARAM_STR);
                            $sign_up_stmt->bindValue(':user_gender',$this->user_gender, PDO::PARAM_STR);
                            $sign_up_stmt->bindValue(':user_password', $hashedPwd, PDO::PARAM_STR);
                            // INSERTING IMAGE
                            $sign_up_stmt->bindValue(':user_image', $fileDestination, PDO::PARAM_STR);
                            $sign_up_stmt->execute();
                            return ['successMessage' => 'You have signed up successfully.'];

                          } else {
                             return ['errorMessage' => 'Your uploaded file is to big!'];
                           }
                        } else {
                           return ['errorMessage' => 'There was an error trying to upload your file, please try again.'];
                         }
                      } else {
                         return ['errorMessage' => 'Incorrect file type. Only jpg, jpeg and png is allowed!'];
                       }

                    }
                }
                else{
                    return ['errorMessage' => 'Invalid email address!'];
                }
            }
            else{
                return ['errorMessage' => 'Please fill in all the required fields.'];
            }
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // LOGIN USER
    function loginUser($email, $password){

        try{
            $this->user_email = trim($email);
            $this->user_password = trim($password);

            $find_email = $this->db->prepare("SELECT * FROM `users` WHERE user_email = ?");
            $find_email->execute([$this->user_email]);

            if($find_email->rowCount() === 1){
                $row = $find_email->fetch(PDO::FETCH_ASSOC);

                $pwdCheck = password_verify($this->user_password, $row['user_password']);
                if($pwdCheck == true){
                    $_SESSION = ['user_id' => $row['id'],'email' => $row['user_email']];
                    header('Location: home.php');
                }
                else{
                    return ['errorMessage' => 'Invalid password'];
                }

            }
            else{
                return ['errorMessage' => 'Invalid email address!'];
            }

        }
        catch (PDOException $e) {
            die($e->getMessage());
        }

    }

    // EDIT USER
    function editUser($username, $firstname, $lastname, $email, $phone, $date, $gender){
        try{
            $this->user_name = trim($username);
            $this->user_firstname = trim($firstname);
            $this->user_lastname = trim($lastname);
            $this->user_email = trim($email);
            $this->user_phone = trim($phone);
            $this->user_date = trim($date);
            $this->user_gender = trim($gender);

            if(!empty($this->user_name) && !empty($this->user_firstname) && !empty($this->user_lastname) && !empty($this->user_email)){

                if (filter_var($this->user_email, FILTER_VALIDATE_EMAIL)) {
                    $check_email = $this->db->prepare("SELECT * FROM `users` WHERE user_email = ?");
                    $check_email->execute([$this->user_email]);

                    if($check_email->rowCount() > 0){
                        return ['errorMessage' => 'This Email Address is already registered. Please Try another.'];
                    }
                    else{
                      $uploads_dir = 'uploads/';
                      foreach ($_FILES["image_file"]["error"] as $key => $error) {
                          if ($error == UPLOAD_ERR_OK) {
                              $tmp_name = $_FILES["image_file"]["tmp_name"][$key];
                              // basename() may prevent filesystem traversal attacks;
                              // further validation/sanitation of the filename may be appropriate
                              $name = basename($_FILES["image_file"]["name"][$key]);
                              move_uploaded_file($tmp_name, "$uploads_dir/$name");
                              include "password_inc.php";
                              $id = $_SESSION['user_id'];
                              $sql = "UPDATE users SET user_firstame=?, user_lastname=?, username=?, user_email=?, user_phone=?, user_date=?, user_gender=?,user_password=?, user_image=? WHERE id='$id'";
                              $stmt= $dpo->prepare($sql);
                              $stmt->execute([$this->user_firstname, $this->user_lastname, $this->user_name, $this->user_email, $this->user_phone, $this->user_date, $this->user_gender, $hashedPwd, $fileDestination]);
                              return ['successMessage' => 'Your information has saved successfully.'];
                          }
                      }


                    }
                }
                else{
                    return ['errorMessage' => 'Invalid email address!'];
                }
            }
            else{
                return ['errorMessage' => 'Please fill in all the required fields.'];
            }
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // FIND USER BY ID
    function find_user_by_id($id){
        try{
            $find_user = $this->db->prepare("SELECT * FROM `users` WHERE id = ?");
            $find_user->execute([$id]);
            if($find_user->rowCount() === 1){
                return $find_user->fetch(PDO::FETCH_OBJ);
            }
            else{
                return false;
            }
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // FETCH ALL USERS WHERE ID IS NOT EQUAL TO MY ID
    function all_users($id){
        try{
            $get_users = $this->db->prepare("SELECT id, username, user_image FROM `users` WHERE id != ?");
            $get_users->execute([$id]);
            if($get_users->rowCount() > 0){
                return $get_users->fetchAll(PDO::FETCH_OBJ);
            }
            else{
                return false;
            }
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
?>
