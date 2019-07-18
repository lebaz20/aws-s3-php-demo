<?php
  require 'loadBucket.php';

  if ($_FILES['file']){
    $file = $_FILES['file'];

    // File details
    $name = $file['name'];
    $tmpName = $file['tmp_name'];
    $explodedName = explode('.', $name);
    $extension = strtolower(end($explodedName));

    // To be saved locally file details
    $key = md5(uniqid());
    $localName = "{$key}.{$extension}";
    $localPath = __DIR__."/../uploads/{$localName}";

    // Save file locally temporarily
    move_uploaded_file($tmpName, $localPath);
    
    $acl = 'public-read';
    if ($_POST['private'] && $_POST['private'] === 'on') {
      $acl = 'private';
    }
    $key = $name;
    if ($_POST['path']) {
      $key = trim($_POST['path'], '/')."/{$name}";
    }
    try {
      // Upload data.
      $result = $s3->putObject([
          'Bucket' => getenv('AWS_BUCKET'), // bucket name
          'Key'    => $key, // file path inside bucket
          'Body'   => fopen($localPath, 'rb'), // file itself
          'ACL'    => $acl // file access rules [https://docs.aws.amazon.com/AmazonS3/latest/dev/acl-overview.html#canned-acl]
      ]);

      // Delete temporary file on success
      unlink($localPath);

      // Print the URL to the object.
      echo $result['ObjectURL'] . PHP_EOL;
    } catch (S3Exception $e) {
        var_dump($e->getMessage());
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf8">
    <title>Upload</title>
  </head>
  <body>
    <a href="/">Back</a>
    <h1>Upload</h1>
    <br />
    <form action="put.php" method="POST" enctype="multipart/form-data">
      <fieldset>
        <label>file</label>
        <input type="file" name="file">
      </fieldset>
      <br />
      <fieldset>
        <label>path</label>
        <input type="text" name="path">
      </fieldset>
      <br />
      <fieldset>
        <label>private</label>
        <input type="checkbox" name="private">
      </fieldset>
      <br />
      <input type="submit" value="Upload">
    </form>
    <br />
  </body>
</html>
