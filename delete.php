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
$list = $s3->listObjects([
    'Bucket' => $bucket_name,
    'Prefix' => $prefix,
]);

// if (isset($_POST['A']) && $_POST['A']) {
//     $result = $s3->getObject([
//         'Bucket' => $bucket_name,
//         'Key' => $_POST['image'],
//     ]);
// }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>削除</title>
    <script>
        function submitForm() {
            const frm = document.getElementById('frm');
            frm.submit();
        }
    </script>
</head>
<body>
    <div class="m-3">
    <h2>削除</h2>
    <div>
        <div>画像を選択</div>
        <!-- セレクトボックス -->
        <form action="destroy.php" method="post" name="frm" id="frm">
            <select name="image" id="">
                <?php foreach ($list['Contents'] as $image) { ?>
                    <option value="<?= $image['Key'] ?>"><?= $image['Key'] ?></option>
                <?php } ?>
            </select>
            <input type="submit" value="delete">
        </form>
    </div>
    <hr>
    <div class="m-3">
        <a href="index.php">HOME</a>
    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>