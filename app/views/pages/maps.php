<div class="container-fluid py-5 text-center bg-dark">
    <h1 class="text-light mb-4" style="font-weight: bold; text-shadow: 2px 2px 10px rgba(0,0,0,0.7);">MAPS</h1>
    <div id="mapsCarousel" class="d-flex justify-content-center flex-wrap">
        <!-- Quả cầu đại diện cho các maps -->
        <div class="map-sphere" data-map="/HeroVerse/public/img/gameplay/maps/1.png" data-title="Nightmare War"></div>
        <div class="map-sphere" data-map="/HeroVerse/public/img/gameplay/maps/2.png" data-title="Frozen Abyss"></div>
        <div class="map-sphere" data-map="/HeroVerse/public/img/gameplay/maps/3.png" data-title="Necrotic Wasteland"></div>
        <div class="map-sphere" data-map="/HeroVerse/public/img/gameplay/maps/4.png" data-title="Volcanic Lands"></div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mapSpheres = document.querySelectorAll('.map-sphere');

    mapSpheres.forEach(sphereDiv => {
        const mapSrc = sphereDiv.getAttribute('data-map');
        const mapTitle = sphereDiv.getAttribute('data-title');

        // Khởi tạo Three.js cho từng quả cầu
        const renderer = new THREE.WebGLRenderer({ alpha: true });
        renderer.setSize(200, 200);
        sphereDiv.appendChild(renderer.domElement);

        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, 1, 0.1, 1000);
        camera.position.z = 2;

        const geometry = new THREE.SphereGeometry(1, 32, 32);
        const material = new THREE.MeshBasicMaterial({
            map: new THREE.TextureLoader().load(mapSrc),
            side: THREE.DoubleSide
        });
        const sphere = new THREE.Mesh(geometry, material);
        scene.add(sphere);

        function animate() {
            requestAnimationFrame(animate);
            sphere.rotation.y += 0.002;
            renderer.render(scene, camera);
        }
        animate();

        sphereDiv.style.width = '200px';
        sphereDiv.style.height = '200px';
        sphereDiv.style.margin = '20px';
        sphereDiv.style.display = 'inline-block';
        sphereDiv.style.cursor = 'pointer';
        sphereDiv.style.borderRadius = '50%'; // Chỉ giữ lại bo tròn nếu muốn

        sphereDiv.addEventListener('click', function () {
            // Hiển thị toàn màn hình hình ảnh của map
            const fullscreenOverlay = document.createElement('div');
            fullscreenOverlay.style.position = 'fixed';
            fullscreenOverlay.style.top = 0;
            fullscreenOverlay.style.left = 0;
            fullscreenOverlay.style.width = '100%';
            fullscreenOverlay.style.height = '100%';
            fullscreenOverlay.style.zIndex = 9999;
            fullscreenOverlay.style.background = `rgba(0, 0, 0, 0.9) url(${mapSrc}) center/cover no-repeat`;
            fullscreenOverlay.style.cursor = 'pointer';

            const title = document.createElement('h2');
            title.innerText = mapTitle;
            title.style.color = '#fff';
            title.style.textAlign = 'center';
            title.style.marginTop = '20px';
            title.style.textShadow = '2px 2px 8px rgba(0, 0, 0, 0.7)';
            fullscreenOverlay.appendChild(title);

            fullscreenOverlay.addEventListener('click', function () {
                document.body.removeChild(fullscreenOverlay);
            });

            document.body.appendChild(fullscreenOverlay);
        });
    });
});
</script>

<style>
.map-sphere canvas {
    border-radius: 50%;
}
</style>
