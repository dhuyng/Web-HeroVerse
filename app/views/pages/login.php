<div id="bgCanvas" style="height: 100%;"></div> <!-- Canvas cho Three.js -->


<!-- Xác thực role User hay Admin ở CSDL -->
<div class="login-form bg-dark">
    <h2 class="display-5 text-white">Đăng nhập</h2>
    <?php
    if (isset($_SESSION['error'])) {
        echo "<p class='error-message'>{$_SESSION['error']}</p>";
        unset($_SESSION['error']);
    }
    ?>
    <form class="bg-dark text-center" action="" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn btn-primary">LOG IN</button>
    </form>
    <p> Nếu bạn chưa có tài khoản <a href="/HeroVerse/register">Đăng ký ở đây</a>.</p>
</div>

<style>
    #bgCanvas {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        overflow: hidden;
    }
    .login-form {
        position: relative;
        margin: 5vh auto;
        background: rgba(255, 255, 255, 0.85);
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        width: 90%;
        max-width: 400px;
    }
    .login-form h2 {
        margin-bottom: 20px;
        font-size: 24px;
        color: #333;
        text-align: center;
    }
    .login-form input[type="text"],
    .login-form input[type="password"],
    .login-form button {
        width: 100%;
        padding: 12px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        font-size: 16px;
    }
    .login-form button {
        background-color: #6a0dad;
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .login-form button:hover {
        background-color: #4b0082; 
    }
    .login-form p {
        margin-top: 15px;
        text-align: center;
    }
    .login-form .error-message {
        color: red;
        text-align: center;
        margin-bottom: 15px;
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script>
    // Particle background effect with Three.js
    const canvas = document.createElement('canvas');
    document.getElementById('bgCanvas').appendChild(canvas);

    const renderer = new THREE.WebGLRenderer({ canvas });
    renderer.setSize(window.innerWidth, window.innerHeight);

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    camera.position.z = 5;

    // Create particle system
    const particlesCount = 1000;
    const positions = new Float32Array(particlesCount * 3);
    for (let i = 0; i < particlesCount * 3; i++) {
        positions[i] = (Math.random() - 0.5) * 10; // Spread out particles
    }

    const particlesGeometry = new THREE.BufferGeometry();
    particlesGeometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));

    const particlesMaterial = new THREE.PointsMaterial({
        color: 0x9b59b6, // Changed to purple color (hex code for a purple shade)
        size: 0.05,
        transparent: true,
        opacity: 0.8,
        blending: THREE.AdditiveBlending,
    });

    const particles = new THREE.Points(particlesGeometry, particlesMaterial);
    scene.add(particles);

    function animate() {
        requestAnimationFrame(animate);

        // Rotate particles for a dynamic effect
        particles.rotation.x += 0.001;
        particles.rotation.y += 0.001;

        renderer.render(scene, camera);
    }
    animate();

    window.addEventListener('resize', () => {
        renderer.setSize(window.innerWidth, window.innerHeight);
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
    });
</script>
