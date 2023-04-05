<?php
include('db.php');


$sql = "SELECT COUNT(email) FROM `accounts`; ";
$count_emails = mysqli_fetch_row(mysqli_query($db, $sql));
$random_num = rand(1, $count_emails[0]);
$sql = "SELECT * FROM `accounts`";
$all_emails = mysqli_fetch_all(mysqli_query($db, $sql));
$random_email = $all_emails[$random_num - 1];


if (isset($_POST['random_email'])) {
  header('Refresh: 0;');
}

// Delete Email
if (isset($_POST['del_email'])) {
  $del_email = $_POST['email_del'];
  $sql = "DELETE FROM accounts WHERE `accounts`.`email` = '$del_email'";
  mysqli_query($db, $sql);
  header('Refresh: 0;');
}

// Add New Account
if (isset($_POST['add_account'])) {
  $name_email = $_POST['add_email'];
  $password_email = $_POST['password_email'];
  if (strlen($name_email) == 0 || strlen($password_email) == 0) {
    $error = 'Input Is Empty!!';
  }

  $sql = "SELECT email FROM `accounts` WHERE email LIKE '$name_email';";
  $isset_email = mysqli_fetch_row(mysqli_query($db, $sql));
  if (isset($isset_email)) {
    $error = 'Email IS Set.';
  }

  if (!isset($isset_email) && !isset($error)) {
    $sql = "INSERT INTO `accounts` (`id`, `email`, `password`) VALUES (NULL, '$name_email', '$password_email');";
    mysqli_query($db, $sql);
    header('Refresh: 0;');
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Free Account ChatGPT | Thomas Emad</title>
</head>

<body>

  <div class="container parent">
    <h2 class="title">Free Account ChatGPT</h2>
    <form action="" method="POST">
      <input type="email" value="<?php echo $random_email[1]; ?>" disabled>
      <input type="text" value="<?php echo $random_email[2]; ?>" disabled>
      <input type="submit" name="random_email" value="New Account">
    </form>

    <details>
      <summary>
        If Any Account Don't Work, Send Here!
      </summary>
      <form action="" method="POST">
        <input type="text" name="email_del" placeholder="Write Email Don't Work.">
        <input type="submit" name="del_email" value="Delete">
      </form>
    </details>

    <details>
      <summary>
        Do You Want Add Email?
      </summary>
      <form action="" method="POST">
        <input type="text" name="add_email" placeholder="Write Email Add.">
        <input type="text" name="password_email" placeholder="Write Password. ">
        <input type="submit" name="add_account" value="Add Account">
      </form>
    </details>
    <p class="error"><?php if (isset($error)) {
                        echo $error;
                      } ?></p>

  </div>
  <footer>
    <div class="container">
      All Copyright To <a href="#" target="__blank">Thomas Emad</a>
    </div>
  </footer>
</body>

</html>