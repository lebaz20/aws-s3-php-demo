<?php
  require 'loadBucket.php';

  $bucket = getenv('AWS_BUCKET');

  if ($_POST['key']) {
    try {
      $result = $s3->deleteObject([
        'Bucket' => getenv('AWS_BUCKET'),
        'Key' => $_POST['key'],
      ]);
    } catch (S3Exception $e) {
        var_dump($e->getMessage());
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf8">
    <title>Delete</title>
  </head>
  <body>
    <a href="/">Back</a>
    <h1>Delete</h1>
    <br />
    <form action="delete.php" method="POST">
      <lable>Key</lable><input type="text" name="key">
      <input type="submit" value="Delete">
    </form>
  </body>
</html>
