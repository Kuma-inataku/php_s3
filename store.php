<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// DBとS3へ登録するファイル名設定

// DB登録

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

$image = fopen($_FILES["image"]["tmp_name"], 'r');
// S3へ保存
try {
    $result = $s3->putObject([
        'Bucket' => $bucket_name,
        'Key' => 's3/sample'.mt_rand(1, 10000).'.jpg',
        'Body'   => $image,
    ]);
} catch (S3Exception $e) {
    // TODO: 失敗時は新規登録画面にリダイレクト
    var_dump($e -> getMessage());
}

// リダイレクト
echo "
    <script>
        alert('done');
        location.href = 'index.php';
    </script>
    ";
exit;
