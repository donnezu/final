<?php
require 'menu.php';
require 'db-connect.php';
require 'header.php';

try {
    $pdo = new PDO($connect, USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = htmlspecialchars($_POST['title']);
        $sell = $_POST['sell'];
        $title_id = $_POST['title_id'];

        if (empty($title)) {
            echo 'タイトルを入力してください。';
        } elseif (empty($sell)) {
            echo '日付を入力してください';
        } else {
            $sql = $pdo->prepare('UPDATE game SET title=?, sell=? WHERE title_id=?');
            $result = $sql->execute([$title, $sell, $title_id]);

            if ($result) {
                echo '更新に成功しました';
            } else {
                echo '更新に失敗しました';
            }
        }
    }

    echo '<hr>';
    echo '<table>';
    echo '<tr><th>タイトルID</th><th>更新</th></tr>';

    $stmt = $pdo->query('SELECT * FROM game');

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>', $row['title_id'], '</td>';
        echo '<td><form method="post" action=""><input type="hidden" name="title_id" value="' . $row['title_id'] . '"><input type="text" name="title" value="' . htmlspecialchars($row['title']) . '"><input type="date" name="sell" value="' . $row['sell'] . '"><input type="submit" value="更新"></form></td>';
        echo '</tr>';
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
} finally {
    require 'footer.php';
}
?>
