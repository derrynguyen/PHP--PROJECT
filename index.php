<style>
    button {
        margin-top: 3vh;
        width: 40%;
        border: none;
        outline: none;
        padding: 15px;
        border-radius: 5px;
        background-color: white;
        color: black;
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

        <div class="main">

            <div class="main_tent">
                <div class="top">
                    <div class="img">
                        <img src="./Image/banner1.png" />
                    </div>

                </div>
                <div class="bottom">
                    <div class="btn">
                        <button>
                            <a class="text" href="store.php">Xem sản phẩm</a>
                        </button>
                    </div>
                    <div class="btn">
                        <button>
                            <a class="text" href="cart.php">Giỏ hàng</a>
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- footer -->
        <?php include "Inc/footer.php" ?>
    </div>
</body>