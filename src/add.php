<?php require 'menu.php'; ?>
<?php require 'db-connect.php'; ?>
<?php require 'header.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $sell = $_POST['sell'];

    try {
        $pdo = new PDO($connect, USER, PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO game (title, sell) VALUES (:title, :sell)";
        $stmt = $pdo->prepare($sql);
    
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':sell', $sell, PDO::PARAM_STR);
    
        $stmt->execute();
    
        echo "商品が追加されました。";
    } catch (PDOException $e) {
        echo "エラー: " . $e->getMessage();
    }
}
?>

<!-- 商品情報入力フォーム -->
<form action="addinput.php" method="post">
    タイトル<input type="text" name="title" required><br>
    発売日<input type="date" name="sell" required><br>
    <button type="submit">追加</button>
</form>

<?php require 'footer.php'; ?>

