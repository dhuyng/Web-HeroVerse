<?php
// Thêm mã PHP xử lý form upload CV và bình luận nếu cần
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin người dùng từ form
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $cv = $_FILES['cv'];

    // Xử lý lưu trữ file CV
    $cvPath = 'uploads/' . basename($cv["name"]);
    move_uploaded_file($cv["tmp_name"], $cvPath);

    // Thông báo sau khi upload thành công
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Thành công!</strong> CV của bạn đã được gửi đi thành công.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
}
?>

<!-- Start of main content -->
<div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <!-- Title Section -->
        <div class="text-center mb-5">
            <h1 class="text-center text-primary fw-bold display-4">JOIN OUR SQUAD</h1>
            <p class="lead text-muted mb-4">
                Join us by uploading your CV. We will contact you via email for an interview.
            </p>

            <img class="rounded img-fluid mb-4 shadow-lg" src="public/img/gameplay/maps/map-10.jpg" alt="Event Image" style="max-height: 400px; object-fit: cover; border-radius: 15px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">

            <h2 class="mb-5 mt-5 text-dark">Submit Your CV</h2>
        </div>

        <!-- Countdown Timer -->
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div id="countdown" class="countdown mb-4 p-4 text-dark rounded shadow-lg">
                    <h5 class="fw-bold text-primary">Time Remaining:</h5>
                    <span id="time" class="fw-bold fs-4"></span>
                </div>
            </div>
        </div>

        <!-- CV Submission Form -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="POST" enctype="multipart/form-data" class="form-container shadow-lg p-4 rounded bg-light border border-primary">
                    <div class="mb-3">
                        <label for="name" class="form-label text-dark fs-5">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label text-dark fs-5">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label text-dark fs-5">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="cv" class="form-label text-dark fs-5">Upload CV</label>
                        <input type="file" class="form-control" id="cv" name="cv" accept=".pdf,.docx,.doc" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-3 py-2 fs-5">Submit CV</button>
                </form>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="container py-5 comments-section">
            <h2 class="text-center text-light mb-4">Comments</h2>

            <!-- Form for leaving a comment -->
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form method="POST" action="submit_comment.php" class="bg-white p-4 rounded shadow-sm">
                        <div class="mb-3">
                            <label for="comment" class="form-label text-dark fs-5">Leave a Comment</label>
                            <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 fs-5">Submit Comment</button>
                    </form>
                </div>
            </div>

            <!-- Displaying Comments -->
            <div class="mt-5">
                <h4 class="text-light">Recent Comments</h4>
                <ul class="list-group">
                    <!-- Example Comments -->
                    <li class="list-group-item p-3 shadow-sm">John Doe: Great opportunity!</li>
                    <li class="list-group-item p-3 shadow-sm">Jane Smith: Excited to join the team!</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Countdown Timer Script -->
<script>
    // Countdown Timer (Set deadline for submission)
    const deadline = new Date('2024-11-30T23:59:59').getTime();
    const timerElement = document.getElementById('time');

    function updateCountdown() {
        const now = new Date().getTime();
        const timeRemaining = deadline - now;

        if (timeRemaining <= 0) {
            timerElement.innerHTML = 'The deadline has passed.';
            clearInterval(countdownInterval);
        } else {
            const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

            timerElement.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
        }
    }

    // Update the countdown every second
    const countdownInterval = setInterval(updateCountdown, 1000);
</script>
