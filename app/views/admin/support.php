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
