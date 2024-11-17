<?php include(__DIR__ . '/../layouts/header.php'); ?>
<?php include(__DIR__ . '/../layouts/navbar.php'); ?>

<div class="container-fluid text-white py-5 bg-dark">
    <h1 class="text-center mb-4 fw-bold" style="color: #00FF00">DRAGNELL</h1>
    <div class="row">
        <!-- Column 1: GIF and Buy Button -->
        <div class="col-md-6 text-center">
            <div class="position-relative mb-4">
                <img src="public/img/gameplay/heroes/dragneel.gif" alt="Dragneel" class="hero-gif" id="dragneelGif">
                <div class="hero-shadow"></div> <!-- Bóng dưới Dragneel -->
            </div>
            <div class="text-center mb-4">
                <p class="card-text text-warning">$100</p>
                <button class="unlock-btn">Unlock</button>

            </div>

            <!-- Hidden Storyline Section -->
            <div id="storyline" class="bg-dark text-light p-4 rounded shadow-lg" style="display: none;">
                <h2 class="text-center mb-3">The Legend of Dragneel</h2>
                <p>
                    Dragneel, known as the last of the Fire Dragon kin, has wandered the realm seeking justice and vengeance for his fallen brethren. 
                    His path is shrouded in mystery, but those who have witnessed his power speak of a dragon's soul burning within, 
                    capable of turning the tides of any battle. With unparalleled strength, unmatched agility, and a heart forged in flames, 
                    Dragneel stands as the ultimate protector against the forces of darkness.
                </p>
            </div>
        </div>

        <!-- Column 2: Skills -->
        <div class="col-md-6">
            <h2 class="text-center mb-4">Special Skills</h2>
            <div class="row text-center">
                <!-- Skill 1 -->
                <div class="col-md-6 mb-4">
                    <img src="public/img/skills/skill-1.png" alt="Skill 1" class="skill-img" data-bs-toggle="modal" data-bs-target="#skill1Modal">
                    <p class="mt-2">Skill 1: Flame Burst</p>
                </div>
                <!-- Skill 2 -->
                <div class="col-md-6 mb-4">
                    <img src="public/img/skills/skill-2.png" alt="Skill 2" class="skill-img" data-bs-toggle="modal" data-bs-target="#skill2Modal">
                    <p class="mt-2">Skill 2: Dragon Claw</p>
                </div>
                <!-- Skill 3 -->
                <div class="col-md-6 mb-4">
                    <img src="public/img/skills/skill-3.png" alt="Skill 3" class="skill-img" data-bs-toggle="modal" data-bs-target="#skill3Modal">
                    <p class="mt-2">Skill 3: Roar of the Ancients</p>
                </div>
                <!-- Skill 4 -->
                <div class="col-md-6 mb-4">
                    <img src="public/img/skills/skill-4.png" alt="Skill 4" class="skill-img" data-bs-toggle="modal" data-bs-target="#skill4Modal">
                    <p class="mt-2">Skill 4: Dragon Flight</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Skill Modals -->
<!-- Modal 1 -->
<div class="modal fade" id="skill1Modal" tabindex="-1" aria-labelledby="skill1ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title" id="skill1ModalLabel">Flame Burst</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Dragneel unleashes a burst of flames, dealing massive damage to enemies in a radius. Effective against multiple targets.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal 2 -->
<div class="modal fade" id="skill2Modal" tabindex="-1" aria-labelledby="skill2ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title" id="skill2ModalLabel">Dragon Claw</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Dragneel strikes with his dragon claw, dealing high single-target damage. This skill has a chance to critically hit.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal 3 -->
<div class="modal fade" id="skill3Modal" tabindex="-1" aria-labelledby="skill3ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title" id="skill3ModalLabel">Roar of the Ancients</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                A mighty roar that stuns nearby enemies, reducing their attack speed and power for a short duration.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal 4 -->
<div class="modal fade" id="skill4Modal" tabindex="-1" aria-labelledby="skill4ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title" id="skill4ModalLabel">Dragon Flight</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Dragneel soars into the air, evading attacks and gaining increased movement speed. Ideal for repositioning in battle.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
.hero-gif {
    width: 400px; /* Tăng kích thước GIF */
    height: auto;
    transition: transform 0.4s, box-shadow 0.4s;
    cursor: pointer;
}

.hero-shadow {
    width: 150px;
    height: 30px;
    background: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
    position: absolute;
    bottom: -20px;
    left: 50%;
    transform: translateX(-50%);
    filter: blur(8px);
}

.skill-img {
    width: 80px; /* Giảm kích thước hình ảnh kỹ năng để nhỏ hơn */
    height: 80px;
    cursor: pointer;
    transition: transform 0.3s, box-shadow 0.3s;
}
.skill-img:hover {
    transform: scale(1.2);
    box-shadow: 0 0 10px rgba(255, 215, 0, 0.8);
}

.unlock-btn {
    margin-top: 20px;
    background-color: #6a0dad;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 1.2rem;
    transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
}
.unlock-btn:hover {
    background-color: #4b0082;
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(75, 0, 130, 0.5);
}
</style>

<script>
document.getElementById('dragneelGif').addEventListener('click', function() {
    const storyline = document.getElementById('storyline');
    if (storyline.style.display === 'none' || storyline.style.display === '') {
        storyline.style.display = 'block';
        storyline.classList.add('animate__animated', 'animate__fadeIn');
    } else {
        storyline.style.display = 'none';
    }
});
</script>

<?php include(__DIR__ . '/../layouts/footer.php'); ?>
