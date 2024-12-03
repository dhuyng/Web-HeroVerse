<style>
/* Giới hạn chiều dài của cột "Câu Hỏi" */
.table td:nth-child(5) {
    max-width: 400px; /* Đặt chiều rộng tối đa cho cột, có thể điều chỉnh */
    white-space: nowrap; /* Không xuống dòng */
    overflow: hidden; /* Ẩn nội dung tràn */
    text-overflow: ellipsis; /* Thêm dấu "..." */
}
</style>

<style>
/* Giới hạn chiều dài của cột "Tiêu đề" */
.table td:nth-child(4) {
    max-width: 200px; /* Đặt chiều rộng tối đa cho cột, có thể điều chỉnh */
    white-space: nowrap; /* Không xuống dòng */
    overflow: hidden; /* Ẩn nội dung tràn */
    text-overflow: ellipsis; /* Thêm dấu "..." */
}
</style>

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
                            <th>ID</th>
                            <th>Người xử lý</th>
                            <th>Email</th>
                            <th>Tiêu Đề</th>
                            <th>Câu Hỏi</th>
                            <th>Trạng Thái</th>
                            <th class="text-center">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody  id = 'support'>
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

<!-- Modal Template -->
<div class="modal fade" id="viewDetailModal" tabindex="-1" aria-labelledby="viewDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewDetailModalLabel">Chi Tiết Hỗ Trợ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>ID:</strong> <span id="modalSupportId"></span></p>
                <p><strong>Người xử lý:</strong> <span id="modalSupportName"></span></p>
                <p><strong>Email:</strong> <span id="modalSupportEmail"></span></p>
                <p><strong>Tiêu Đề:</strong> <span id="modalSupportTitle"></span></p>
                <p><strong>Câu Hỏi:</strong> <span id="modalSupportQuestion"></span></p>
                <p><strong>Trạng Thái:</strong> <span id="modalSupportStatus"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>


</div>




<script>
document.addEventListener('DOMContentLoaded', function () {
    document.addEventListener('click', function (event) {
        if (event.target.matches('.btn-primary[data-bs-target^="#supportModal-"]')) {
            const row = event.target.closest('tr');
            const supportId = row.querySelector('.support-id').textContent.trim();
            const supportName = row.querySelector('.support-username').textContent.trim();
            const supportEmail = row.querySelector('.support-email').textContent.trim();
            const supportTitle = row.querySelector('td:nth-child(4)').textContent.trim();
            const supportQuestion = row.querySelector('td:nth-child(5)').textContent.trim();
            const supportStatus = row.querySelector('.toggle-status-btn').textContent.trim();

            // Populate modal
            document.getElementById('modalSupportId').textContent = supportId;
            document.getElementById('modalSupportName').textContent = supportName;
            document.getElementById('modalSupportEmail').textContent = supportEmail;
            document.getElementById('modalSupportTitle').textContent = supportTitle;
            document.getElementById('modalSupportQuestion').textContent = supportQuestion;
            document.getElementById('modalSupportStatus').textContent = supportStatus;

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('viewDetailModal'));
            modal.show();
        }
    });
});


</script>

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

                        const statusEmail = {
                            1: support.email,
                            0: "_________"
                        };

                        const statusUsername = {
                            1: support.username,
                            0: "_________"
                        };

                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="support-id">${support.id}</td>
                            <td class="support-username">${statusUsername[support.is_processed]}</td>
                            <td class="support-email">${statusEmail[support.is_processed]}</td>
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

                let newTextStatus;
                let newClassStatus;
                let newEmailStatus = "_________";
                let newUsernameStatus = "_________";
                
            if (data.success) {
                if(button.textContent === statusText[1]){
                    newTextStatus = statusText[0];
                    newClassStatus = statusClass[0];
                } else {
                    newTextStatus = statusText[1];
                    newClassStatus = statusClass[1];
                    newEmailStatus = data.data.email;
                    newUsernameStatus = data.data.username;
                }
                button.textContent = newTextStatus;
                button.className = `badge toggle-status-btn ${newClassStatus}`;

                // Change the email and username in row
                const row = button.closest('tr');
                row.children[1].textContent = newUsernameStatus;
                row.children[2].textContent = newEmailStatus;

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
