<div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="text-center">
            <h5 class="section-title text-center text-primary fw-bold">Event</h5>
            <h1 class="mb-5">Newest</h1>
        </div>
        <div class="owl-carousel testimonial-carousel">
            <div class="testimonial-item bg-transparent border rounded p-4">
                <i class="text-primary mb-3"></i>
                <h5 class="mb-3"> <a href=""> the New Hero: Undying Fury </a></h5>
                <div class="d-flex align-items-center">
                    <img class="img-fluid flex-shrink-0" src="public/img/carousel/carousel-2.png">

                </div>
            </div>
            <div class="testimonial-item bg-transparent border rounded p-4">
                <i class="text-primary mb-3"></i>
                <h5 class="mb-3"> <a href="">New Private Campaigns Unveiled </a></h5>
                <div class="d-flex align-items-center">
                    <img class="img-fluid flex-shrink-0" src="public/img/carousel/carousel-3.png">

                </div>
            </div>

            <div class="testimonial-item bg-transparent border rounded p-4">
                <i class="text-primary mb-3"></i>
                <h5 class="mb-3"> <a href=""> the New Hero: Undying Fury </a></h5>
                <div class="d-flex align-items-center">
                    <img class="img-fluid flex-shrink-0" src="public/img/carousel/carousel-2.png">

                </div>
            </div>

            <div class="testimonial-item bg-transparent border rounded p-4">
                <i class="text-primary mb-3"></i>
                <h5 class="mb-3"> <a href="">New Private Campaigns Unveiled </a></h5>
                <div class="d-flex align-items-center">
                    <img class="img-fluid flex-shrink-0" src="public/img/carousel/carousel-3.png">

                </div>
            </div>
            <?php foreach ($events as $event): ?>
                <div class="testimonial-item bg-transparent border rounded p-4">
                    <i class="text-primary mb-3"></i>
                    <h5 class="mb-3"> <a href="<?= 'event_item?item=' . $event['id'] ?>"><?= $event['title'] ?> </a></h5>
                    <div class="d-flex align-items-center">
                        <a href="<?= 'event_item?item=' . $event['id'] ?>">
                            <img class="img-fluid flex-shrink-0" src="public/img/event/<?= $event['image'] ?>">
                        </a>

                    </div>
                </div>
            <?php endforeach; ?>



        </div>
    </div>

    <div class="container py-5">
        <div class="text-center">
            <h1 class="mb-5">More Events</h1>
        </div>
        <div class="row align-items-center mb-4">
            <!-- Event 1 -->
            <div class="col-md-6">
                <h5 class="mb-3"> <a href=""> <a href="join_squad_event">Join the Squad! - Become a part of us </a></h5>
                <p></p>
                <p>Submit your CV and take the first step toward joining our dynamic and passionate team. We are always
                    looking for talented individuals who are ready to collaborate, innovate, and grow with us!</p>
            </div>
            <div class="col-md-6">
                <img class="img-fluid w-100 rounded" src="public/img/gameplay/maps/map-10.jpg" alt="Event Image">
            </div>
        </div>
        <div class="row align-items-center mb-4">
            <!-- Event 2 -->
            <div class="col-md-6 order-md-2">
                <h5 class="mb-3"> <a href="">Nightmare Wars Begin </a></h5>
                <p>The Nightmare War begins, bringing forth chaos and challenges like never before. Brace yourself as
                    heroes rise to battle the darkness and restore peace to the realm.</p>
            </div>
            <div class="col-md-6 order-md-1">
                <img class="img-fluid w-100 rounded" src="public/img/gameplay/maps/map-11.jpg" alt="Event Image">
            </div>
        </div>
        <!-- Populate events -->
        <?php if (count($events) > 0): ?>
            <?php for ($i = 0; $i < count($events); $i++): ?>
                <?php $event = $events[$i]; ?>
                <?php if ($i % 2 == 0): ?>
                    <!-- Left style -->
                    <div class="row align-items-center mb-4">
                        <div class="col-md-6">
                            <h5 class="mb-3"> <a href="<?= 'event_item?item=' . $event['id'] ?>"><?= $event['title'] ?> </a></h5>
                            <p><?= $event['description'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <a href="<?= 'event_item?item=' . $event['id'] ?>">
                                <img class="img-fluid w-100 rounded" src="public/img/event/<?= $event['image'] ?>"
                                    alt="Event Image">
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Right style -->
                    <div class="row align-items-center mb-4">
                        <div class="col-md-6 order-md-2">
                            <h5 class="mb-3"> <a href="<?= 'event_item?item=' . $event['id'] ?>"><?= $event['title'] ?> </a></h5>
                            <p><?= $event['description'] ?></p>
                        </div>
                        <div class="col-md-6 order-md-1">
                            <a href="<?= 'event_item?item=' . $event['id'] ?>">
                                <img class="img-fluid w-100 rounded" src="public/img/event/<?= $event['image'] ?>"
                                    alt="Event Image">
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endfor; ?>
        <?php else: ?>
            <h5>No on going events.</h5>
        <?php endif; ?>

    </div>
</div>