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
    // 'SaveAs' => './download/path.jpg', // ファイルとして保存する時に使用
];

try {
    $result = $s3->getObject($params);
    $len = $result['ContentLength'];

    //ファイルを表示
    header("Content-Type: {$result['ContentType']}");
    echo $result['Body'];

    //ファイルダウンロード
    header('Content-Type: application/force-download;');
    header('Content-Length: '.$len);
    header('Content-Disposition: attachment; filename="sample8918.jpg"');

    echo $result['Body'];
} catch(S3Exception $e) {
    var_dump($e -> getMessage());
}
