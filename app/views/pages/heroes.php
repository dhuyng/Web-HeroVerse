<?php
require_once(__DIR__ . "/../../controllers/HeroController.php");

$heroController = new HeroController();
$heroes = $heroController->getAllHeroes();
?>

<div class="container-fluid py-5" style="background-image: url(public/img/background/bg-0.jpg); background-size: cover;">
    <div class="text-center mb-4">
        <h1 class="mb-3 text-light" style="font-weight: bold; text-shadow: 2px 2px 10px rgba(0,0,0,0.7);">Danh Sách Heroes</h1>
        <input type="text" id="heroSearch" class="form-control w-50 mx-auto mb-4 bg-dark text-light border border-secondary" placeholder="Tìm kiếm Hero...">
    </div>

    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs justify-content-center mb-4" id="heroTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active border text-light" id="all-tab" data-category="all" type="button" role="tab">Tất cả</button>
        </li>
        <li class="nav-item">
            <button class="nav-link border border-white text-light" id="dark-hero-tab" data-category="dark" type="button" role="tab">Dark Heroes</button>
        </li>
        <li class="nav-item">
            <button class="nav-link border border-white text-light" id="light-hero-tab" data-category="light" type="button" role="tab">Light Heroes</button>
        </li>
        <li class="nav-item">
            <button class="nav-link border border-white text-light" id="my-hero-tab" data-category="my-hero" type="button" role="tab">My Heroes</button>
        </li>
    </ul>

    <!-- Hero List -->
    <div class="row bg-dark" id="heroList">
        <?php foreach ($heroes as $hero): ?>
            <div class="col-sm-6 col-md-3 mb-4 hero-item <?php echo htmlspecialchars($hero['type']); ?>">
                <div class="card text-light text-center shadow-lg border-0 h-100 hero-card" style="position: relative; background-color: #3B1E54;">
                    <a href="/HeroVerse/<?php echo urlencode($hero['name']); ?>" class="hero-link">
                        <img src="<?php echo htmlspecialchars($hero['image']); ?>" 
                             class="card-img-top img-fluid rounded-circle mx-auto mt-3 hero-img" 
                             style="width: 150px; height: 150px;" 
                             alt="<?php echo htmlspecialchars($hero['name']); ?>">
                    </a>
                    <div class="card-body" style="position: relative; z-index: 2;">
                        <h5 class="card-title text-light"><?php echo htmlspecialchars($hero['name']); ?></h5>
                        <p class="card-text text-warning">$<?php echo number_format($hero['price'], 2); ?></p>
                        <button class="btn btn-primary btn-sm buy-now-btn">Buy Now</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
document.querySelectorAll('.nav-tabs .nav-link').forEach(function (tab) {
    tab.addEventListener('click', function () {
        const category = this.getAttribute('data-category');
        const heroItems = document.querySelectorAll('.hero-item');

        // Xóa trạng thái active khỏi tất cả các tab
        document.querySelectorAll('.nav-tabs .nav-link').forEach(function (tab) {
            tab.classList.remove('active', 'bg-purple', 'text-dark');
            tab.classList.add('text-white', 'bg-black'); // Trạng thái mặc định
        });

        // Thêm trạng thái active vào tab được chọn
        this.classList.remove('text-white', 'bg-black');
        this.classList.add('active', 'bg-purple', 'text-dark'); // Trạng thái được chọn

        // Lọc danh sách Hero
        heroItems.forEach(function (item) {
            if (category === 'all' || item.classList.contains(category)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
});
</script>

<style>
.hero-card {
    transition: transform 0.4s ease-in-out, box-shadow 0.4s ease-in-out;
    border-radius: 15px;
    overflow: hidden;
    background-color: black !important;
    position: relative;
}
.hero-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 30px rgba(255, 255, 255, 0.5), 0 0 30px rgba(255, 255, 255, 0.7);
}

.hero-img {
    transition: all 0.4s ease;
}
.hero-img:hover {
    transform: scale(1.15);
    box-shadow: 0 0 25px rgba(255, 255, 255, 0.8), 0 0 50px rgba(88, 0, 176, 0.7);
}

.buy-now-btn {
    margin-top: 10px;
    font-size: 14px;
    font-weight: bold;
    background: linear-gradient(to right, #007bff, #ff007f);
    border: none;
    transition: all 0.4s ease-in-out;
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
}

.buy-now-btn:hover {
    background: linear-gradient(to left, #007bff, #ff007f); /* Xanh và hồng đổi chỗ */
    transform: scale(1.1);
    color: white;
    box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.5);
}

/* Mặc định: Không được chọn */
.nav-tabs .nav-link {
    color: white !important;
    background-color: black !important;
    transition: all 0.3s ease;
}

/* Được chọn */
.nav-tabs .nav-link.active {
    color: white !important;
    background-color: #800080 !important; /* Màu tím */
    font-weight: bold;
    transition: all 0.3s ease;
}

</style>

