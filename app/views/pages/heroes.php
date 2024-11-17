<div class="container-fluid py-5 " style="background-image: url(public/img/background/bg-0.jpg); background-size: cover ">
    <div class="text-center mb-4">
        <h1 class="mb-3 text-light" style="font-weight: bold; text-shadow: 2px 2px 10px rgba(0,0,0,0.7);">Hero List</h1>
        <input type="text" id="heroSearch" class="form-control w-50 mx-auto mb-4 bg-dark text-light border border-secondary" placeholder="Search heroes by name...">
    </div>

    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs justify-content-center mb-4" id="heroTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link border border-white text-light" id="all-tab" data-category="all" type="button" role="tab">All</button>
        </li>
        <li class="nav-item">
            <button class="nav-link border border-white  text-light" id="dark-hero-tab" data-category="dark-hero" type="button" role="tab">Dark Heroes</button>
        </li>
        <li class="nav-item">
            <button class="nav-link border border-white  text-light" id="light-hero-tab" data-category="light-hero" type="button" role="tab">Light Heroes</button>
        </li>
        <li class="nav-item">
            <button class="nav-link border border-white  text-light" id="my-hero-tab" data-category="my-heroes" type="button" role="tab">My Heroes</button>
        </li>
    </ul>

    <!-- Hero List -->
    <div class="row bg-dark" id="heroList">
        <?php
        // Danh sách các heroes
        $heroes = [
            ["name" => "Dragneel", "image" => "public/img/gameplay/heroes/ava-1.png", "category" => "dark-hero"],
            ["name" => "Zara", "image" => "public/img/gameplay/heroes/ava-7.png", "category" => "light-hero"],
            ["name" => "Kael", "image" => "public/img/gameplay/heroes/ava-3.png", "category" => "dark-hero"],
            ["name" => "Drake", "image" => "public/img/gameplay/heroes/ava-6.png", "category" => "light-hero"],
            ["name" => "Veras", "image" => "public/img/gameplay/heroes/ava-2.png", "category" => "dark-hero"],
            ["name" => "Faye", "image" => "public/img/gameplay/heroes/ava-9.png", "category" => "light-hero"],
            ["name" => "Aira", "image" => "public/img/gameplay/heroes/ava-5.png", "category" => "dark-hero"],
            ["name" => "Ryn", "image" => "public/img/gameplay/heroes/ava-8.png", "category" => "light-hero"],
            ["name" => "Vex", "image" => "public/img/gameplay/heroes/ava-4.png", "category" => "dark-hero"],
            ["name" => "Kain", "image" => "public/img/gameplay/heroes/ava-10.png", "category" => "light-hero"],
        ];

        // Hiển thị danh sách heroes
        foreach ($heroes as $hero) {
            echo '
            <div class="col-sm-6 col-md-3 mb-4 hero-item ' . $hero["category"] . '">
                <div class="card text-light text-center shadow-lg border-0 h-100 hero-card" style="position: relative; background-color: #3B1E54;">
                    <div class="threejs-container"></div> <!-- Three.js container for particles -->
                    <a href="app/views/heroes/' . strtolower($hero["name"]) . '.php" class="hero-link">
                        <img src="' . $hero["image"] . '" class="card-img-top img-fluid rounded-circle mx-auto mt-3 hero-img" style="width: 150px; height: 150px;" alt="' . $hero["name"] . '">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title text-light">' . $hero["name"] . '</h5>
                        <p class="card-text text-warning">$100</p>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script>
document.getElementById('heroSearch').addEventListener('input', function () {
    var input = this.value.toLowerCase();
    var heroItems = document.querySelectorAll('.hero-item');

    heroItems.forEach(function (item) {
        var heroName = item.querySelector('.card-title').textContent.toLowerCase();
        if (heroName.includes(input)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
});

document.querySelectorAll('.nav-tabs .nav-link').forEach(function (tab) {
    tab.addEventListener('click', function () {
        var category = this.getAttribute('data-category');
        var heroItems = document.querySelectorAll('.hero-item');

        heroItems.forEach(function (item) {
            if (category === 'all' || item.classList.contains(category)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });

        document.querySelectorAll('.nav-tabs .nav-link').forEach(function (t) {
            t.classList.remove('active');
            t.style.backgroundColor = 'rgba(0, 0, 0, 0.75)';
            t.style.color = '#bbb';
            t.style.boxShadow = 'none';
        });
        this.classList.add('active');
        this.style.backgroundColor = 'rgba(88, 0, 176, 0.9)';
        this.style.color = '#fff';
        this.style.boxShadow = '0 0 10px rgba(255, 255, 255, 0.7), 0 0 15px rgba(255, 255, 255, 0.5)';
    });
});

document.querySelectorAll('.hero-card').forEach(function (card) {
    const container = card.querySelector('.threejs-container');
    const renderer = new THREE.WebGLRenderer({ alpha: true });
    renderer.setSize(300, 300); // Adjust the size for better coverage
    container.appendChild(renderer.domElement);

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, 1, 0.1, 1000);
    camera.position.z = 10;

    const particleCount = 500;
    const particlesGeometry = new THREE.BufferGeometry();
    const positions = [];
    const velocities = [];

    // Exclusion zone around hero image
    const circleRadius = 1.5; // Match this to the hero image radius
    const centerX = 0;
    const centerY = 0;

    for (let i = 0; i < particleCount; i++) {
        let x, y, z;
        do {
            x = (Math.random() - 0.5) * 10;
            y = (Math.random() - 0.5) * 10;
            z = (Math.random() - 0.5) * 10;
        } while (Math.sqrt((x - centerX) ** 2 + (y - centerY) ** 2) < circleRadius); // Exclude particles inside the circle

        positions.push(x);
        positions.push(y);
        positions.push(z);

        velocities.push((Math.random() - 0.5) * 0.02);
        velocities.push((Math.random() - 0.5) * 0.02);
        velocities.push((Math.random() - 0.5) * 0.02);
    }

    particlesGeometry.setAttribute('position', new THREE.Float32BufferAttribute(positions, 3));
    const particlesMaterial = new THREE.PointsMaterial({
        color: 0x8a2be2,
        size: 0.1,
        transparent: true,
        opacity: 0.8,
    });

    const particleSystem = new THREE.Points(particlesGeometry, particlesMaterial);
    scene.add(particleSystem);

    function animate() {
        requestAnimationFrame(animate);
        const positions = particlesGeometry.attributes.position.array;

        for (let i = 0; i < particleCount; i++) {
            positions[i * 3] += velocities[i * 3];     // Update x position
            positions[i * 3 + 1] += velocities[i * 3 + 1]; // Update y position
            positions[i * 3 + 2] += velocities[i * 3 + 2]; // Update z position

            if (positions[i * 3] > 5 || positions[i * 3] < -5) velocities[i * 3] *= -1;
            if (positions[i * 3 + 1] > 5 || positions[i * 3 + 1] < -5) velocities[i * 3 + 1] *= -1;
            if (positions[i * 3 + 2] > 5 || positions[i * 3 + 2] < -5) velocities[i * 3 + 2] *= -1;
        }

        particlesGeometry.attributes.position.needsUpdate = true;
        particleSystem.rotation.y += 0.001;
        particleSystem.rotation.x += 0.001;
        renderer.render(scene, camera);
    }

    animate();

    // Control particle visibility on hover
    card.addEventListener('mouseenter', function () {
        particleSystem.visible = true;
    });

    card.addEventListener('mouseleave', function () {
        particleSystem.visible = false;
    });

    particleSystem.visible = false; // Initially hide the particles
});
</script>

<style>
/* Hero Card Styles */
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

/* Hero Image Styles */
.hero-img {
    transition: all 0.4s ease;
}
.hero-img:hover {
    transform: scale(1.15);
    box-shadow: 0 0 25px rgba(255, 255, 255, 0.8), 0 0 50px rgba(88, 0, 176, 0.7);
}

/* Tab Button Hover Effect */
.nav-tabs .nav-link:hover {
    background-color: rgba(88, 0, 176, 0.7) !important;
    color: #fff !important;
}

.threejs-container {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 0;
}
</style>

