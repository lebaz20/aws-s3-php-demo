<?php
  use Aws\S3\S3Client;
  use Aws\S3\Exception\S3Exception;

  //Create a S3Client
  $s3 = new Aws\S3\S3Client([
      'version' => 'latest',
      'region' => 'us-east-1'
  ]);
  var_dump(getenv());
  $bucket = 'test';
  $keyname = '*** Your Object Key ***';
  try {
    // Upload data.
    $result = $s3->putObject([
        'Bucket' => $bucket,
        'Key'    => $keyname,
        'Body'   => 'Hello, world!',
        'ACL'    => 'public-read'
    ]);

    // Print the URL to the object.
    echo $result['ObjectURL'] . PHP_EOL;
} catch (S3Exception $e) {
    var_dump($e);
}
?>