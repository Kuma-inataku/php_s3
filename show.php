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
// TODO: 選択したS3バケットの画像を取得
$list = $s3->listObjects([
    'Bucket' => $bucket_name,
    'Prefix' => $prefix,
]);
$count = count($list);

// TOOD: パス名だけで画像情報取得できる？
$result = $s3->getObject([
    'Bucket' => $bucket_name,
    'Key' => 's3/sample2368.jpg',
]);
echo '<pre>';
var_dump($result['Body']);
echo '</pre>';
exit;
$baseUrl = "https://s3-{$bucket_region}.amazonaws.com";
$bucket = "aws-php-bucket";
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>詳細</title>
</head>
<body>
    <div class="m-3">
    <h2>詳細</h2>
    <!-- // TOOD: バイナリファイルから画像を取得する方法は？ -->
    <img src="<?= $result['Body']?>" alt="">
    <div>
        <div>画像を選択</div>
        <!-- TOOD: セレクトボックス -->
        <select name="" id="">
            <?php foreach ($list['Contents'] as $image) { ?>
                <option value="<?= $image['Key'] ?>"><?= $image['Key'] ?></option>
            <?php } ?>
        </select>
    </div>
    <hr>
    <div>
        <?php if (isset($_POST['A']) && $_POST['A']) { ?>
            <div>選択した画像</div>
            <img src="" alt="">
        <?php } else { ?>
            <div class="bg-danger fw-bold text-light">画像を選択してください</div>
        <?php } ?>
    </div>
    <div class="m-3">
        <a href="index.php">HOME</a>
    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>