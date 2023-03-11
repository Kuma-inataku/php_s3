<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// S3登録
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

$prefix = 's3/';
// S3バケットの画像を全て取得
$list = $s3->listObjects([
    'Bucket' => $bucket_name,
    'Prefix' => $prefix,
]);

$baseUrl = "https://s3-{$bucket_region}.amazonaws.com";
$bucket = "aws-php-bucket";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
    <?php foreach ($list['Contents'] as $img) { ?>
        <img src="<?= $baseUrl ?>/<?= $bucket_name ?>/<?= $img['Key'] ?>" height='100' loading='lazy'>
    <?php } ?>
    </div>
</body>
</html>