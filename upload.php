<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\CommandPool;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$credentials = [
    'key' => $_ENV['AWS_ACCESS_KEY'],
    'secret' => $_ENV['AWS_SECRET_KEY'],
];

$bucket_version = $_ENV['BUCKET_VERSION'];
$bucket_region = $_ENV['BUCKET_REGION'];
$bucket_name = $_ENV['BUCKET_NAME'];

$s3 = new S3Client([
    'credentials' => $credentials,
    'region'  => $bucket_region,
    'version' => $bucket_version,
]);

var_dump('s3 instance created!!!');
echo '<br>';
var_dump('s3', $s3);