<?php require 'menu.php'; ?>
<?php require 'db-connect.php';?>
<?php require 'header.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $deleteId = $_POST['delete'];

    // データベースから商品を削除するクエリを実行
    $pdo = new PDO($connect, USER, PASS);
    $sql = "DELETE FROM game WHERE title_id = :title_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':title_id', $deleteId, PDO::PARAM_INT);
    $stmt->execute();
}

echo '<table>';
echo '<tr><th>タイトルID</th><th>タイトル</th><th>発売日</th></tr>';
$pdo = new PDO($connect, USER, PASS);

$sql = "SELECT * FROM game";
$stmt = $pdo->query($sql);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td>', $row['title_id'], '</td>';
    echo '<td>', $row['title'], '</td>';
    echo '<td>', $row['sell'], '</td>';
    echo '<td>';
    echo '<form method="post" action=""><input type="hidden" name="delete" value="' . $row['title_id'] . '">';
    echo '<input type="submit" value="削除"></form>';
    echo '</td>';
    echo '</tr>';
}

echo '</table>';
?>

<?php require 'footer.php'; ?>
