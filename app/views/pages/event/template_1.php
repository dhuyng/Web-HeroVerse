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
            <h1 class="text-center text-primary fw-bold display-4"><?= strtoupper(htmlspecialchars($event['title'])) ?></h1>
            <p class="lead text-muted mb-4">
                Join us by uploading your CV. We will contact you via email for an interview.
                <div><?= htmlspecialchars($event['description']) ?></div>
            </p>

            <img class="rounded img-fluid mb-4 shadow-lg" src="public/img/event/<?=$event['image']?>" alt="Event Image" style="max-height: 400px; object-fit: cover; border-radius: 15px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">

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
                    <form class="bg-white p-4 rounded shadow-sm" id="commentForm">
                        <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>" />
                        <input type="hidden" name="user_id" value="<?=$_SESSION['user']['id'] ?? null ?>" />
                        <div class="mb-3">
                            <label for="comment" class="form-label text-dark fs-5">Leave a Comment</label>
                            <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
                        </div>
                        <div id="commentResult"></div>
                        <button type="submit" class="btn btn-primary w-100 py-2 fs-5">Submit Comment</button>
                    </form>
                </div>
            </div>

            <!-- Displaying Comments -->
            <div class="mt-5">
                <h4>Recent Comments</h4>
                <ul class="list-group" id="comments-list">
                    <?php if (count($comments) > 0): ?>
                            <?php foreach ($comments as $comment): ?>
                                <li class="list-group-item p-3 shadow-sm" data-id="<?= $comment['id'] ?>">
                                    <div class="comment-content">
                                        <strong><?= htmlspecialchars($comment['username']) ?></strong>
                                        <p class="comment-text"><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                                        <small class="text-muted d-block">
                                            <?= date('F j, Y, g:i a', strtotime(htmlspecialchars($comment['created_at']))) ?>
                                        </small>
                                    </div>
                                    <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
                                        <div class="admin-edit-controls d-none">
                                            <textarea class="form-control edit-comment-text"><?= htmlspecialchars($comment['content']) ?></textarea>
                                            <div class="mt-2">
                                                <label for="visibility-<?= $comment['id'] ?>">Visibility:</label>
                                                <select id="visibility-<?= $comment['id'] ?>" class="form-select comment-visibility">
                                                    <option value="visible" <?= $comment['status'] === 'visible' ? 'selected' : '' ?>>Visible</option>
                                                    <option value="hidden" <?= $comment['status'] === 'hidden' ? 'selected' : '' ?>>Hidden</option>
                                                </select>
                                            </div>
                                            <div class="mt-2">
                                                <button class="btn btn-sm btn-success save-comment">Save</button>
                                                <button class="btn btn-sm btn-secondary cancel-edit">Cancel</button>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                    <?php else: ?>
                        <p class="p-3">Be the first to comment on this event.</p>
                    <?php endif ?>
                </ul>
                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <nav aria-label="Page navigation" id="pagination-controls">
                        <ul class="pagination">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                                    <button class="page-link" data-page="<?= $i ?>"><?= $i ?></button>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Countdown Timer Script -->
<script>
    // Countdown Timer (Set deadline for submission)
    const deadline = new Date('<?=date('Y-m-d\\TH:i:s', strtotime($event['end_time']))?>').getTime();
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const commentForm = document.getElementById('commentForm');
        const commentResult = document.getElementById('commentResult');
        const commentsList = document.querySelector('.comments-section .list-group');

        commentForm.addEventListener('submit', (event) => {
            event.preventDefault();

            commentResult.innerHTML = '';
            const formData = new FormData(event.target);
            const submitButton = commentForm.querySelector('button[type="submit"]');
            submitButton.disabled = true;

            <?php if(!isset($_SESSION['user']['id'])): ?>
                commentResult.innerHTML = `
                    <div class="alert alert-danger" role="alert">
                        Please login first!
                    </div>
                `;
                submitButton.disabled = false;
                return;
            <?php endif ?>

            const sendData = {};
            formData.forEach((value, key) => {
                sendData[key] = value;
            });
            fetch('index.php?ajax=addComment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(sendData),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        commentResult.innerHTML = `
                            <div class="alert alert-success" role="alert">
                                Comment uploaded!
                            </div>
                        `;

                        // Append new comment to the list
                        const newComment = document.createElement('li');
                        newComment.className = 'list-group-item p-3 shadow-sm';
                        // Format the date using Intl.DateTimeFormat
                        let formattedDate = new Intl.DateTimeFormat('en-US', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: 'numeric',
                            minute: 'numeric',
                            hour12: true, // Ensures 12-hour format
                        }).format(new Date(data.comment.created_at));
                        formattedDate = formattedDate.replace(/\s([APM]{2})$/, (match) => match.toLowerCase());
                        newComment.innerHTML = `
                            <strong>${data.comment.username}</strong>
                            <p>${data.comment.content}</p>
                            <small class="text-muted d-block">${formattedDate}</small>
                        `;
                        commentsList.prepend(newComment);

                        // Clear the form
                        commentForm.reset();
                    } else {
                        // Show error message
                        commentResult.innerHTML = `
                            <div class="alert alert-danger" role="alert">
                                Error: ${data.message}
                            </div>
                        `;
                    }
                })
                .catch(err => {
                    console.error('Error: ', err);
                    commentResult.innerHTML = `
                        <div class="alert alert-danger" role="alert">
                            An unexpected error occurred. Please try again.
                        </div>
                    `;
                })
                .finally(() => {
                    submitButton.disabled = false;
                });
        });
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const commentsList = document.getElementById('comments-list');
    const paginationControls = document.getElementById('pagination-controls');

    const loadComments = (page) => {
        const eventId = new URLSearchParams(window.location.search).get('item');

        fetch(`index.php?ajax=getComments&item=${eventId}&page=${page}`)
            .then(response => response.json())
            .then(data => {
                if (data.comments) {
                    // Clear current comments
                    commentsList.innerHTML = '';

                    // Add new comments
                    data.comments.forEach(comment => {
                        const commentHtml = `
                            <li class="list-group-item p-3 shadow-sm">
                                <strong>${comment.username}</strong>
                                <p>${comment.content.replace(/\n/g, '<br>')}</p>
                                <small class="text-muted d-block">
                                    ${new Date(comment.created_at).toLocaleString('en-US', {
                                        month: 'long',
                                        day: 'numeric',
                                        year: 'numeric',
                                        hour: 'numeric',
                                        minute: '2-digit',
                                        hour12: true,
                                    })}
                                </small>
                            </li>`;
                        commentsList.innerHTML += commentHtml;
                    });

                    // Update active page in pagination
                    const buttons = paginationControls.querySelectorAll('button');
                    buttons.forEach(button => button.parentElement.classList.remove('active'));
                    paginationControls.querySelector(`button[data-page="${data.currentPage}"]`).parentElement.classList.add('active');
                }
            })
            .catch(error => console.error('Error loading comments:', error));
    };

    // Attach click event to pagination buttons
    paginationControls.addEventListener('click', (event) => {
        if (event.target.tagName === 'BUTTON') {
            const page = event.target.getAttribute('data-page');
            loadComments(page);
        }
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
    const commentsList = document.getElementById('comments-list');

    commentsList.addEventListener('click', (event) => {
        const commentItem = event.target.closest('.list-group-item');
        console.log(commentItem);
        console.log(event.target);
        if (!commentItem) return;

        const isAdmin = <?= json_encode(isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin') ?>;

        if (isAdmin) {
            const editControls = commentItem.querySelector('.admin-edit-controls');
            const commentTextElement = commentItem.querySelector('.comment-text');

            if (!editControls.classList.contains('d-none')) return;

            // Enable edit mode
            editControls.classList.remove('d-none');
            commentTextElement.style.display = 'none';

            // Cancel edit functionality
            const cancelButton = editControls.querySelector('.cancel-edit');
            if (!cancelButton.hasListener) {
                cancelButton.addEventListener('click', (event) => {
                    event.stopPropagation();
                    console.log("clicked");
                    editControls.classList.add('d-none');
                    commentTextElement.style.display = 'block';
                });
                cancelButton.hasListener = true;
            }
                

            // Save comment functionality
            const saveButton = editControls.querySelector('.save-comment');
            if (!saveButton.hasListener) {
                saveButton.addEventListener('click', (event) => {
                    console.log('+1 click');
                    event.stopPropagation();
                    const newContent = editControls.querySelector('.edit-comment-text').value;
                    const newStatus = editControls.querySelector('.comment-visibility').value;
                    const commentId = commentItem.getAttribute('data-id');

                    fetch(`index.php?ajax=editComment`, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: commentId, content: newContent, status: newStatus })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            commentTextElement.textContent = newContent;
                            alert('Comment updated successfully!');
                        } else {
                            alert('Failed to update comment.');
                        }
                        editControls.classList.add('d-none');
                        commentTextElement.style.display = 'block';
                    });
                });
                saveButton.hasListener = true;
            }
        }
    });
});

</script>