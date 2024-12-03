<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>


<div class="container-xxl bg-white p-0">
    <!-- Hero Section -->
    <div class="container-xxl bg-dark position-relative p-0">
        <div class="container-xxl py-5 bg-dark mb-5">
            <div class="container bg-dark text-center my-5 pt-5 pb-4">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Contact</h1>
            </div>
        </div>
    </div>
    <!-- Hero Section End -->

    <!-- Contact Section -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h5 class="section-title text-center text-primary fw-bold">Thông tin liên lạc</h5>
                <h1 class="mb-5">Liên hệ để được hỗ trợ</h1>
            </div>
            <div class="row g-4">
                <div class="col-12">
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <h5 class="section-title fw-bold text-start text-primary">Email</h5>
                            <p><i class="fa fa-envelope-open text-primary me-2"></i>heroverse@gmail.com</p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="section-title fw-bold text-start text-primary">Phone</h5>
                            <p><i class="fa fa-phone-alt text-primary me-2"></i>09 xxx xx xxx</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="wow fadeInUp" data-wow-delay="0.2s">
                        <form id="contactForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" placeholder="Your Name">
                                        <label for="name">Tên của bạn</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" placeholder="Your Email">
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="subject" placeholder="Subject">
                                        <label for="subject">Tiêu đề</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Leave a message here" id="message" style="height: 150px"></textarea>
                                        <label for="message">Câu hỏi của bạn sẽ được chúng tôi liên hệ và phản hồi trong thời gian sớm nhất.</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Gửi câu hỏi</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                </div>
                <div class="col-md-6 wow fadeIn" data-wow-delay="0.1s">
                    <iframe class="position-relative rounded w-100 h-100"
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15678.046317829956!2d106.6579018!3d10.772075!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ec3c161a3fb%3A0xef77cd47a1cc691e!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBCw6FjaCBraG9hIC0gxJDhuqFpIGjhu41jIFF14buRYyBnaWEgVFAuSENN!5e0!3m2!1svi!2s!4v1731050442841!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        frameborder="0" style="min-height: 350px; border:0;" allowfullscreen="" aria-hidden="false"
                        tabindex="0"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact Section End -->
</div>

<script>
document.getElementById('contactForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent the default form submission

    const subject = document.getElementById('subject').value;
    const message = document.getElementById('message').value;

    // Validate the inputs
    if (!subject || !message) {
        alert('Vui lòng điền đầy đủ thông tin.');
        return;
    }

    // Send data to the server via AJAX
    fetch('index.php?ajax=saveQuestion', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            title: subject,
            question: message,
        }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Câu hỏi của bạn đã được gửi thành công!');
                // Optionally reset the form
                document.getElementById('contactForm').reset();
            } else {
                alert('Đã xảy ra lỗi. Vui lòng thử lại.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Không thể kết nối với máy chủ.');
        });
});
</script>
