<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\CommandPool;
use Aws\S3\Exception\S3Exception;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$credentials = [
    'key' => $_ENV['AWS_ACCESS_KEY'],
    'secret' => $_ENV['AWS_SECRET_KEY'],
];

$bucket_version = $_ENV['BUCKET_VERSION'];
$bucket_region = $_ENV['BUCKET_REGION'];
$bucket_name = $_ENV['BUCKET_NAME'];

// インスタンス生成
$s3 = new S3Client([
    'credentials' => $credentials,
    'region'  => $bucket_region,
    'version' => $bucket_version,
]);

$params = [
    'Bucket' => $bucket_name,
    'Key' => 's3/sample'.mt_rand(1, 10000).'.jpg',
    'SourceFile'   => 'image/luffy.png',
];

try {
    $result = $s3->putObject($params);
    var_dump($result['ObjectURL']);
} catch (S3Exception $e) {
    echo $e -> getMessage();
}

var_dump('s3 saved!!!');
