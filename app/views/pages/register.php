<div id="bgCanvas" style="height: 100%;"></div> <!-- Canvas cho Three.js -->

<div class="register-form bg-dark">
    <h2 class="display-5 text-white">Đăng ký</h2>
    <?php
    if (isset($_SESSION['error'])) {
        echo "<p class='error-message'>{$_SESSION['error']}</p>";
        unset($_SESSION['error']);
    }
    ?>
    <form id="registerForm" class="bg-dark text-center" action="register" method="POST" onsubmit="return validateForm()">
        <input type="text" id="username" name="username" placeholder="Username (4-20 ký tự)" required minlength="4" maxlength="20">
        <input type="email" id="email" name="email" placeholder="Email" required>
        <input type="password" id="password" name="password" placeholder="Password (6-20 ký tự)" required minlength="6" maxlength="20">
        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
        <button type="submit" class="btn btn-primary">Đăng ký</button>
        <p id="error-message" class="text-danger" style="display: none;"></p>
    </form>
    <script>
        function validateForm() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const errorMessage = document.getElementById('error-message');

            if (password !== confirmPassword) {
                errorMessage.style.display = 'block';
                errorMessage.textContent = 'Passwords do not match!';
                return false; // Prevent form submission
            }

            errorMessage.style.display = 'none';
            return true; // Allow form submission
        }
    </script>
    <p>Nếu bạn đã có tài khoản <a href="login">Đăng nhập ở đây</a>.</p>
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
    .register-form {
        position: relative;
        margin: 5vh auto;
        background: rgba(255, 255, 255, 0.85);
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        width: 90%;
        max-width: 400px;
    }
    .register-form h2 {
        margin-bottom: 20px;
        font-size: 24px;
        color: #333;
        text-align: center;
    }
    .register-form input[type="text"],
    .register-form input[type="email"],
    .register-form input[type="password"],
    .register-form button {
        width: 100%;
        padding: 12px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        font-size: 16px;
    }
    .register-form button {
        background-color: #6a0dad; /* Purple color */
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .register-form button:hover {
        background-color: #4b0082; /* Darker Purple */
    }
    .register-form p {
        margin-top: 15px;
        text-align: center;
    }
    .register-form .error-message {
        color: red;
        text-align: center;
        margin-bottom: 15px;
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script>
    // Three.js Image Effect with Increased Number of Images
    const canvas = document.createElement('canvas');
    document.getElementById('bgCanvas').appendChild(canvas);

    const renderer = new THREE.WebGLRenderer({ canvas });
    renderer.setSize(window.innerWidth, window.innerHeight);

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    camera.position.z = 5;

    // Load texture
    const textureLoader = new THREE.TextureLoader();
    const texture = textureLoader.load('public/img/account.png');

    // Create planes with images
    const imagePlanes = [];
    const imageCount = 100; // Increased number of images
    for (let i = 0; i < imageCount; i++) {
        const geometry = new THREE.PlaneGeometry(0.8, 0.8); // Smaller plane size for more images
        const material = new THREE.MeshBasicMaterial({ map: texture, transparent: true });
        const plane = new THREE.Mesh(geometry, material);

        plane.position.x = (Math.random() - 0.5) * 20;
        plane.position.y = (Math.random() - 0.5) * 20;
        plane.position.z = (Math.random() - 0.5) * 20;
        plane.rotation.z = Math.random() * Math.PI * 2;

        scene.add(plane);
        imagePlanes.push(plane);
    }

    function animate() {
        requestAnimationFrame(animate);

        // Rotate images for a dynamic effect
        imagePlanes.forEach(plane => {
            plane.rotation.z += 0.01;
            plane.position.y += Math.sin(Date.now() * 0.001 + plane.position.x) * 0.005; // Floating effect with slight randomness
        });

        renderer.render(scene, camera);
    }
    animate();

    window.addEventListener('resize', () => {
        renderer.setSize(window.innerWidth, window.innerHeight);
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
    });

    // Form Validation with JavaScript
    // const registerForm = document.getElementById('registerForm');
    // registerForm.addEventListener('submit', function (event) {
    //     const password = document.getElementById('password').value;
    //     const confirmPassword = document.getElementById('confirmPassword').value;

    //     if (password !== confirmPassword) {
    //         alert('Mật khẩu không khớp. Vui lòng kiểm tra lại.');
    //         event.preventDefault(); // Ngăn chặn việc gửi form
    //     }
    // });
</script>
