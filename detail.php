<?php
require_once './Class/Product.php';
require_once './Class/Database.php';
require_once './Class/Cart.php';
session_start();
$product = new Product();
$cart = new Cart();

// Lấy ID người dùng từ session
$id_user = $_SESSION['login_detail']['id'];

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $productInfo = $product->getProductById($id);

    if ($productInfo) {
        if (isset($_POST['add_to_cart'])) {
            // Lấy thông tin sản phẩm từ form
            $name_product = $productInfo->name_product;
            $brand_id = $productInfo->brand_id;
            $price_product = $productInfo->price_product;
            $imgur = $productInfo->imgur;
            $amount_product = $_POST['amount_product'];
            $total = 0;

            // Thêm sản phẩm vào giỏ hàng (cart) và lưu vào cơ sở dữ liệu
            $cart->addCartItem($id_user, $name_product, $brand_id, $price_product, $imgur, $amount_product, $total);

            // Chuyển hướng người dùng đến trang giỏ hàng hoặc trang sản phẩm (tuỳ vào yêu cầu của bạn)
            header("Location: cart.php"); // Điều hướng đến trang giỏ hàng
            exit();
        }
        ?>

        <body>
            <div class="container">
                <!-- Header -->
                <?php include "Inc/header.php" ?>

                <div class="detail">
                    <div class="main_detail">
                        <div class="left">
                            <div class="img">
                                <img src="<?php echo $productInfo->imgur; ?>" />
                            </div>
                        </div>
                        <div class="right">
                            <div class="brand">
                                <p>Hãng sản xuất: <span>
                                        <?php echo $productInfo->brand_id; ?>
                                    </span></p>
                            </div>
                            <div class="name">
                                <p>Tên sản phẩm: <span>
                                        <?php echo $productInfo->name_product; ?>
                                    </span></p>
                            </div>
                            <div class="desc">
                                <p>Miêu tả: <span>
                                        <?php echo $productInfo->desc_product; ?>
                                    </span></p>
                            </div>
                            <div class="price">
                                <p>Giá: <span>
                                        <?php echo number_format($productInfo->price_product, 0, ',', '.') . ' VNĐ'; ?>
                                    </span></p>
                            </div>
                            <div class="amount">
                                <p>Tình trạng: <span>Còn hàng</span></p>
                            </div>
                            <?php if (!empty($id_user)) { ?>
                                <form method="post" action="">
                                    <input type="number" value="1" min="1" max="100" placeholder="Nhập số lượng..."
                                        name="amount_product" />
                                    <div class="btn">
                                        <button type="submit" name="add_to_cart">Thêm giỏ hàng</button>
                                    </div>
                                </form>
                            <?php } else { ?>
                                <p>Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.</p>
                            <?php } ?>
                            <div class="btn">
                                <button type="submit">
                                    <a style="color:white;text-decoration: none;" href="store.php">Quay lại cửa hàng</a>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- footer -->
                <?php include "Inc/footer.php" ?>
            </div>
        </body>
        <?php
    } else {
        echo "Sản phẩm không tồn tại.";
    }
} else {
    echo "Không tìm thấy mã sản phẩm.";
}
?>