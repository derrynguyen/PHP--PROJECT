<?php
require_once './Class/Product.php';
require_once './Class/Database.php';

$product = new Product();
$perPage = 6;
$totalProducts = $product->getTotalCount();
$totalPages = ceil($totalProducts / $perPage);

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$page = max(1, min($page, $totalPages));

$offset = ($page - 1) * $perPage;

$products = $product->loadAll($offset, $perPage);


// Xử lý tìm kiếm sản phẩm dựa trên từ khóa
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $products = $product->searchProducts($keyword, $offset, $perPage);
    $totalProducts = count($products);
    $totalPages = ceil($totalProducts / $perPage);
} else {
    // Xử lý lọc theo giá
    if (isset($_GET['pricetype'])) {
        $priceType = $_GET['pricetype'];
        if ($priceType == 1) {
            $products = $product->filterByPrice('desc', $offset, $perPage);
        } elseif ($priceType == 2) {
            $products = $product->filterByPrice('asc', $offset, $perPage);
        }
    }
    // Xử lý lọc theo thương hiệu
    elseif (isset($_GET['brand'])) {
        $brandId = $_GET['brand'];
        $products = $product->filterByBrand($brandId, $offset, $perPage);
    }
    // Hiển thị tất cả sản phẩm
    else {
        $products = $product->loadAll($offset, $perPage);
    }
}

?>
<style>
    button {
        margin-top: 3vh;
        width: 40%;
        border: none;
        outline: none;
        padding: 15px;
        border-radius: 5px;
        background-color: black;
        color: white;
        font-family: ThanhHai;
        cursor: pointer;


    }

    button .text {
        text-decoration: none;
        color: white
    }

    button:hover .text {
        background-color: #ac0046;
        color: white;
    }
</style>


<body>
    <div class="container">
        <!-- Header -->
        <?php include "Inc/header.php" ?>

        <div class="store">
            <div class="navbar">
                <h3>Cửa hàng</h3>
                <div class="input">
                    <form action="" method="GET">
                        <input style="width: 30vh;" type="text" name="keyword" placeholder="Tìm kiếm sản phẩm..." />
                        <button style="width: 30vh;" class="text" type="submit">Tìm kiếm</button>
                        <button style="width: 30vh;" type="button">
                            <a class="text" href="store.php?page=1">Reset</a>
                        </button>

                    </form>
                </div>

                <div class="pagination">
                    <?php if ($page > 1) { ?>
                        <a href="?page=<?php echo $page - 1; ?>" class="prev">Lùi lại</a>
                    <?php } ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                        <a href="?page=<?php echo $i; ?>" <?php if ($i == $page)
                               echo 'class="active"'; ?>>
                            <?php echo $i; ?>
                        </a>
                    <?php } ?>

                    <?php if ($page < $totalPages) { ?>
                        <a href="?page=<?php echo $page + 1; ?>" class="next">Tiếp theo</a>
                    <?php } ?>
                </div>
                <h3 style="margin-top:3vh;">Chọn lọc</h3>
                <div class="input" style="margin-top:3vh;">
                    <form action="" method="GET">
                        <select class="select" name="pricetype" style="width: 30vh;">
                            <option class="optiontype" value="1">Cao đến thấp</option>
                            <option class="optiontype" value="2">Thấp đến cao</option>
                        </select>
                        <button type="submit" style="width: 30vh;" class="text">Lọc</button>
                    </form>
                </div>
                <div class="input">
                    <form action="" method="GET">
                        <select class="select" name="brand" style="width: 30vh;">
                            <option class="optiontype" value="1">Daikin</option>
                            <option class="optiontype" value="2">LG</option>
                            <option class="optiontype" value="3">Toshiba</option>
                            <option class="optiontype" value="4">Sharp</option>
                            <option class="optiontype" value="5">SAM SUNG</option>
                            <option class="optiontype" value="6">Panasonic</option>

                        </select>
                        <button type="submit" style="width: 30vh;" class="text">Lọc</button>
                    </form>
                </div>

            </div>

            <div class="product">
                <div class="list_product">
                    <?php if (!empty($products)) { ?>
                        <?php foreach ($products as $product) { ?>
                            <div class="box">
                                <div class="img">
                                    <img src="<?php echo $product->imgur; ?>" />
                                </div>
                                <p class="name">
                                    <?php echo $product->name_product; ?>
                                </p>
                                <p class="brand">
                                    <?php echo $product->brand_id; ?>
                                </p>
                                <div class="price">
                                    <span>
                                        <?php echo number_format($product->price_product, 0, ',', '.') . ' VNĐ'; ?>
                                    </span>
                                </div>
                                <div class="btn">
                                    <button>
                                        <a class="text" href="detail.php?id=<?php echo $product->id; ?>">Xem chi tiết</a>
                                    </button>
                                </div>
                            </div>
                        <?php } ?>

                    <?php } else { ?>
                        <p>Không có sản phẩm.</p>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- footer -->
        <?php include "Inc/footer.php" ?>
    </div>






</body>