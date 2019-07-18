<?php
  require 'loadBucket.php';

  $bucket = getenv('AWS_BUCKET');

  if ($_POST['key']) {
    $object = $s3->getObject([
      'Bucket' => getenv('AWS_BUCKET'),
      'Key' => $_POST['key'],
      'Prefix' => $prefix,
    ]);
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf8">
    <title>Get</title>
  </head>
  <body>
    <a href="/">Back</a>
    <h1>Get</h1>
    <br />
    <form action="get.php" method="POST">
      <lable>Key</lable><input type="text" name="key">
      <input type="submit" value="Fetch">
    </form>
    <br />
    <?php 
    if ($object) {
      echo $object->get('Body')->getContents();
    } else {
      echo 'File content will appear here.';
    }
    ?>
    <br />    
  </body>
</html>
