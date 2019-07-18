<?php
  require 'loadBucket.php';

  $bucket = getenv('AWS_BUCKET');

  $delimiter = '';
  if ($_POST['delimiter']) {
    $delimiter = $_POST['delimiter'];
  }
  if ($_POST['prefix']) {
    $prefix = $_POST['prefix'];
  }
  $objects = $s3->listObjectsV2([
    'Bucket' => getenv('AWS_BUCKET'),
    'Delimiter' => $delimiter,
    'Prefix' => $prefix,
  ]);

  $list = $objects->get('Contents') ? $objects->get('Contents') : [];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf8">
    <title>List</title>
  </head>
  <body>
    <a href="/">Back</a>
    <h1>List</h1>
    <br />
    <form action="list.php" method="POST">
      <lable>Delimiter: </lable><input type="text" name="delimiter">
      <lable>Prefix: </lable><input type="text" name="prefix">
      <input type="submit" value="Filter">
    </form>
    <br />
    <table>
      <thead>
        <tr>
          <th>File</th>
        </tr>
      </thead>
      <?php foreach($list as $item): 
        $key = $item['Key'];
        $url = $s3->getObjectUrl($bucket, $key);
      ?>
      <tr>
        <td><a href="<?php echo $url; ?>" download><?php echo $key; ?></a></td> 
      </tr>
      <?php endforeach; ?>
    </table>
    <br />
  </body>
</html>
