<?php require 'menu.php'; ?>
<?php require 'db-connect.php';?>
<?php require 'header.php'; ?>

<form action="product.php" method="post">
    商品検索
    <input type="text" name="keyword">
    <input type="submit" value="検索">
</form>

<?php
echo '<table>';
echo '<tr><th>タイトルID</th><th>タイトル</th><th>発売日</th></tr>';

$pdo = new PDO($connect, USER, PASS);

// キーワードが送信された場合
if (isset($_POST['keyword'])) {
    $keyword = '%' . $_POST['keyword'] . '%';
    $sql = "SELECT * FROM game WHERE title LIKE :keyword";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
    $stmt->execute();
} else {
    // キーワードが送信されていない場合は全ての商品を取得
    $sql = "SELECT * FROM game";
    $stmt = $pdo->query($sql);
}

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td>', $row['title_id'], '</td>';
    echo '<td>', $row['title'], '</td>';
    echo '<td>', $row['sell'], '</td>';
    echo '</tr>';
}

echo '</table>';
?>

<?php require 'footer.php'; ?>
