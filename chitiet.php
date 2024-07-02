<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_tintuc";

// Kết nối tới cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy ID bài đăng từ URL
$id = $_GET['id'];

// Truy vấn dữ liệu bài đăng dựa trên ID
$sql = "SELECT title, content, image FROM db_baidang WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Lấy dữ liệu bài đăng
    $row = $result->fetch_assoc();
} else {
    echo "Bài đăng không tồn tại.";
    exit;
}

include("footer.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row["title"]; ?> - Tin Tức Nhanh</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./thietke/style.css">
    <link rel="stylesheet" href="./font icon/themify-icons-font/themify-icons/themify-icons.css">
</head>
<body>
<div id="main">
<div id="header">
        <h1 class="h1"><a href="index.php">Tin Tức Nhanh</a></h1>
        <div id="nav">
            <li><a href="index.php">Tin mới</a></li>
            <li><a href="favorites.php">Bài viết đã thích</a></li>
            <li><a href="dang-bai.php">Độc giả đăng bài</a></li>
            <?php if(isset($_SESSION['username'])): ?>
                <p class="dangnhap"><a href="logout.php">Đăng xuất</a></p>
                <p class="welcome">Chào, <?php echo $_SESSION['username']; ?></p>
            <?php else: ?>
                <p class="dangnhap"><a href="dangnhap.php">Đăng nhập</a></p>
            <?php endif; ?>
            <div class="search-btn">
                <a href="search.php"><i class="search-icon ti-search"></i></a>
            </div>
        </div>
    </div>

    <div id="content">
        <div class="post">
            <h2><?php echo $row["title"]; ?></h2>
            <?php
            if ($row["image"]) {
                echo '<img src="' . $row["image"] . '" alt="' . $row["title"] . '">';
            }
            ?>
            <p><?php echo $row["content"]; ?></p>
            <form method="post" action="add_to_favorites.php">
                <input type="hidden" name="post_id" value="<?php echo $id; ?>">
                <button type="submit" name="add_to_favorites" class="favorite-btn">Thêm vào yêu thích</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>

<?php
$conn->close();
?>
