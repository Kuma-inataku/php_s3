<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;
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
    'Key' => 's3/sample8918.jpg',
];
try {

    $cmd = $s3 -> getCommand('GetObject', $params);
    $request = $s3->createPresignedRequest($cmd, '+1 minutes');
    $uri = $request -> getUri();

    $url = $uri -> getScheme().'://'.$uri -> getHost().$uri -> getPath().'?'.$uri -> getQuery();
    // var_dump($url);
} catch(S3Exception $e) {
    var_dump($e -> getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S3 URL</title>
</head>
<body>
    <div>
        <h3>S3画像</h3>
        <a href="<?= $url?>" target="_blank" rel="noopener noreferrer">確認</a>
    </div>
</body>
</html>