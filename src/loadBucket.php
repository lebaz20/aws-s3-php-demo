<?php
  require __DIR__.'/../vendor/autoload.php';

  use Aws\S3\S3Client;
  use Aws\S3\Exception\S3Exception;

  // Create a S3Client
  // Credentials are read from environment
  // through .env which is used in docker image
  $s3 = new Aws\S3\S3Client([
      'version' => 'latest',
      'region' => getenv('AWS_REGION')
  ]);
?>