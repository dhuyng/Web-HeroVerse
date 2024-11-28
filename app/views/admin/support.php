<div class="container mt-5">
    <h3 class="text-center mb-4 text-primary">Hỗ Trợ Khách Hàng</h3>

    <!-- Thanh tìm kiếm -->
    <form method="GET" action="" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo họ tên, email hoặc tiêu đề..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit" class="btn btn-primary">Tìm Kiếm</button>
        </div>
    </form>

    <!-- Bảng hiển thị biểu mẫu liên hệ -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th id = 'support'>ID</th>
                            <th>Họ Tên</th>
                            <th>Email</th>
                            <th>Tiêu Đề</th>
                            <th>Câu Hỏi</th>
                            <th>Trạng Thái</th>
                            <th class="text-center">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Lọc kết quả theo từ khóa tìm kiếm
                        $search = isset($_GET['search']) ? strtolower(trim($_GET['search'])) : '';

                        for ($i = 1; $i <= 5; $i++):
                            $hoTen = "Nguyễn Văn A";
                            $email = "example{$i}@email.com";
                            $tieuDe = "Tiêu Đề {$i}";

                            // Kiểm tra nếu không có từ khóa hoặc có từ khóa và dữ liệu khớp
                            if (empty($search) || strpos(strtolower($hoTen), $search) !== false || strpos(strtolower($email), $search) !== false || strpos(strtolower($tieuDe), $search) !== false):
                                $isProcessed = $i % 2 == 0;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $hoTen; ?></td>
                            <td><?php echo $email; ?></td>
                            <td><?php echo $tieuDe; ?></td>
                            <td>Câu hỏi của người dùng...</td>
                            <td>
                                <?php if ($isProcessed): ?>
                                    <span class="badge bg-success">Đã Xử Lý</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Chưa Xử Lý</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#supportModal-<?php echo $i; ?>">Xem Chi Tiết</button>
                                <button class="btn btn-sm btn-danger">Xóa</button>
                            </td>
                        </tr>
                        <?php
                            endif;
                        endfor;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('index.php?ajax=getAllSupports', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log(data.data);
                const supportTableBody = document.getElementById('support');
                supportTableBody.innerHTML = '';

                // Populate Support Table
                if (data.data.length > 0) {
                    data.data.forEach(support => {
                        const statusClass = {
                            1: "bg-success",
                            0: "bg-warning text-dark"
                        };

                        const statusText = {
                            1: "Đã Xử Lý",
                            0: "Chưa Xử Lý"
                        };

                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="support-id">${support.id}</td>
                            <td>${support.username}</td>
                            <td>${support.email}</td>
                            <td>${support.title}</td>
                            <td>${support.question}</td>
                            <td>
                                <button class="badge toggle-status-btn ${statusClass[support.is_processed]}">${statusText[support.is_processed]}</button>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#supportModal-${support.id}">Xem Chi Tiết</button>
                                <button class="btn btn-sm btn-danger delete-support-btn">Xóa</button>
                            </td>
                        `;

                        supportTableBody.appendChild(tr);
                    });
                } else {
                user.innerHTML = '<tr><td colspan="7" class="text-center">Không có dữ liệu</td></tr>';
            
            }
        } else {
            console.error('Fetch error:', data.message);
            alert('Không thể tải dữ liệu hỗ trợ.');
        }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Đã xảy ra lỗi khi tải dữ liệu hỗ trợ. Vui lòng thử lại sau.');
        })
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Add event listener for delete buttons
    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('delete-support-btn')) {
            const row = event.target.closest('tr'); // Get the closest table row
            if (!row) {
                alert('Error: Unable to locate the row.');
                return;
            }

            const supportIdElement = row.querySelector('.support-id'); // Find the element with the Support ID
            if (!supportIdElement) {
                alert('Error: Support ID not found.');
                return;
            }

            const supportId = supportIdElement.textContent.trim(); // Fetch and trim the Support ID
            if (!supportId) {
                alert('Error: Invalid Support ID.');
                return;
            }

            // Confirm before deleting
            if (confirm(`Bạn có chắc chắn muốn xóa hỗ trợ với ID: ${supportId}?`)) {
                deleteSupport(supportId, row);
            }
        }
    });
});

// Function to delete the support record via AJAX
function deleteSupport(supportId, row) {
    const errorContainer = document.getElementById('errorMessages') || createErrorContainer();
    fetch('support.php?ajax=deleteSupport', {
        method: 'POST',
        body: JSON.stringify({ id: supportId }),
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
    })
        .then((response) => {
            if (!response.ok) throw new Error('Network response was not ok.');
            return response.json();
        })
        .then((data) => {
            errorContainer.innerHTML = ''; // Clear previous messages

            if (data.success) {
                row.remove(); // Remove the table row on success
                errorContainer.innerHTML = `
                    <div class="alert alert-success" role="alert">
                        Hỗ trợ đã được xóa thành công.
                    </div>
                `;
            } else {
                errorContainer.innerHTML = `
                    <div class="alert alert-danger" role="alert">
                        ${data.message || 'Không thể xóa hỗ trợ.'}
                    </div>
                `;
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            errorContainer.innerHTML = `
                <div class="alert alert-danger" role="alert">
                    Có lỗi xảy ra khi xóa hỗ trợ. Vui lòng thử lại sau.
                </div>
            `;
        });
}

// Helper to create a message container if not present
function createErrorContainer() {
    const container = document.createElement('div');
    container.id = 'errorMessages';
    document.body.prepend(container); // Add it to the top of the body
    return container;
}


</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    // Add event listener for toggle buttons
    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('toggle-status-btn')) {
            const row = event.target.closest('tr'); // Find the table row
            const supportIdElement = row.querySelector('.support-id'); // Get the ID element


            if (!supportIdElement) {
                alert('Error: Support ID not found.');
                return;
            }

            const supportId = supportIdElement.textContent.trim(); // Extract the ID
            if (!supportId) {
                alert('Error: Invalid Support ID.');
                return;
            }

            toggleSupportStatus(supportId, event.target); // Pass the button for UI updates
        }
    });
});

// Function to send an AJAX request to toggle the status
function toggleSupportStatus(supportId, button) {
    fetch('support.php?ajax=toggleSupportStatus', {
        method: 'POST',
        body: JSON.stringify({ id: supportId }),
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
    })
        .then((response) => {
            if (!response.ok) throw new Error('Network response was not ok.');
            return response.json();
        })
        .then((data) => {
                console.log(data);

                const statusClass = {
                    1: "bg-success",
                    0: "bg-warning text-dark"
                };

                const statusText = {
                    1: "Đã Xử Lý",
                    0: "Chưa Xử Lý"
                };

            if (data.success) {
                // Update button text based on the new status
                const newTextStatus = button.textContent === statusText[1] ? statusText[0] : statusText[1];
                const newClassStatus = button.textContent === statusText[1] ? statusClass[0] : statusClass[1];
                button.textContent = newTextStatus;
                button.className = `badge toggle-status-btn ${newClassStatus}`;
                alert(`Status updated to: ${newTextStatus}`);
            } else {
                alert(data.message || 'Failed to toggle support status.');
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('An error occurred while toggling the status.');
        });
}

</script>
