<!-- Start Header Area -->
<header class="header-area header-wide">
    <!-- main header start -->
    <div class="main-header d-none d-lg-block">
        <!-- header top start -->
        <!-- header middle area start -->
        <div class="header-main-area sticky">
            <div class="container">
                <div class="row align-items-center position-relative">

                    <!-- start logo area -->
                    <div class="col-lg-2">
                        <a href="<?= BASE_URL ?>">
                            <div class="logo">
                                <img src="assets/img/logo/logo3.png" alt="Brand Logo" style="width: 150px;">
                        </a>
                    </div>
                </div>
                <!-- start logo area -->

                <!-- main menu area start -->
                <div class="col-lg-6 position-static">
                    <div class="main-menu-area">
                        <div class="main-menu">
                            <!-- main menu navbar start -->
                            <nav class="desktop-menu">
                                <ul>
                                    <li><a href="<?= BASE_URL ?>">Trang chủ</a></li>

                                    <!-- Hiển thị danh mục -->
                                    <li><a href="#">Sản phẩm <i class="fa fa-angle-down"></i></a>
                                        <ul class="dropdown">
                                            <?php if (isset($listDanhMuc) && ! empty($listDanhMuc)): ?>
                                                <?php foreach($listDanhMuc as $danhMuc):?>
                                                    <li>
                                                        <a href="<?= BASE_URL . '?act=danh-muc&danh_muc_id=' . $danhMuc['id']; ?>">
                                                        <?= $danhMuc['ten_danh_muc']?>
                                                        </a>
                                                    </li>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                <?php endif; ?>
                                        </ul>
                                    </li>
                                    <!--  -->
                                    
                                    <li><a href="#">Giới thiệu</a></li>
                                    <li><a href="#">Liên Hệ</a></li>
                                </ul>
                            </nav>
                            <!-- main menu navbar end -->
                        </div>
                    </div>
                </div>

                <!-- mini cart area start -->
                <div class="col-lg-4">
                    <div class="header-right d-flex align-items-center justify-content-xl-between justify-content-lg-end">
                        <div class="header-search-container">
                            <button class="search-trigger d-xl-none d-lg-block"><i class="pe-7s-search"></i></button>
                            <form class="header-search-box d-lg-none d-xl-block">
                                <input type="text" placeholder="nhập tên sản phẩm" class="header-search-field">
                                <button class="header-search-btn"><i class="pe-7s-search"></i></button>
                            </form>
                        </div>
                        <div class="header-configure-area">
                            <ul class="nav justify-content-end">
                                <label for="">
                                    <?php
                                    if (isset($_SESSION['user_client'])) {
                                        echo $_SESSION['user_client'];
                                        // var_dump($_SESSION['user_client']);
                                        // die;
                                    }
                                    ?>
                                </label>
                                <li class="user-hover">
                                    <a href="#">
                                        <i class="pe-7s-user"></i>
                                    </a>
                                    <ul class="dropdown-list">
                                        <?php
                                        if (!isset($_SESSION['user_client'])) { ?>

                                            <li><a href="<?= BASE_URL . '/?act=login' ?>">Đăng nhập</a></li>
                                            <li><a href="<?= BASE_URL . '/?act=dangky' ?>">Đăng ký</a></li>

                                        <?php } else {
                                        ?>

                                            <li><a href="">Tài khoản </a></li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="<?= BASE_URL . '?act=logout-client' ?>"
                                                    onclick="return confirm('Đăng xuất tài khoản ')">
                                                    <i class="fas fa-sign-out-alt"></i>Đăng xuất
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#" class="minicart-btn">
                                        <i class="pe-7s-shopbag"></i>
                                        <div class="notification">2</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- mini cart area end -->

            </div>
        </div>
    </div>
    <!-- header middle area end -->
    </div>
    <!-- main header start -->
</header>
<!-- end Header Area -->