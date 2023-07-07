<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css">

   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <?php
   include 'config.php';

   $message = array(); // Initialize an empty array for storing messages

   if (isset($_POST['submit'])) {
      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
      $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

      $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email'") or die('query failed');

      if (mysqli_num_rows($select) > 0) {
         $message[] = 'User already exists!';
      } else {
         mysqli_query($conn, "INSERT INTO `user_form`(name, email, password) VALUES('$name', '$email', '$pass')") or die('query failed');
         $message[] = 'Registered successfully!';
         header('location: login.php');
      }
   }
   ?>

   <div class="form-container">
      <form action="" method="post">
         <h3>Register Now</h3>
         <?php if (!empty($message)) : ?>
            <div class="alert alert-danger">
               <?php foreach ($message as $msg) : ?>
                  <p><?php echo $msg; ?></p>
               <?php endforeach; ?>
            </div>
         <?php endif; ?>
         <div class="mb-3">
            <input type="text" name="name" required placeholder="Enter username" class="form-control" pattern="[A-Za-z]{3,20}" title="Username must be between 3 and 20 characters (only alphabetic characters)">
         </div>
         <div class="mb-3">
            <input type="email" name="email" required placeholder="Enter email" class="form-control">
         </div>
         <div class="mb-3">
            <input type="password" name="password" required placeholder="Enter password" class="form-control">
         </div>
         <div class="mb-3">
            <input type="password" name="cpassword" required placeholder="Confirm password" class="form-control">
         </div>
         <input type="submit" name="submit" class="btn btn-primary" value="Register Now">
         <p>Already have an account? <a href="login.php">Login Now</a></p>
      </form>
   </div>

   <!-- Bootstrap JS -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
