<?php
  require __DIR__.'/../vendor/autoload.php';

  use Aws\S3\S3Client;
  use Aws\S3\Exception\S3Exception;

  //Create a S3Client
  $s3 = new Aws\S3\S3Client([
      'version' => 'latest',
      'region' => 'eu-west-2'
  ]);
?>