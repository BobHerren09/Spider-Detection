<?php
header('Content-Type: application/json');

// Kiểm tra xem có file được tải lên không
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['error' => 'Không có file ảnh được tải lên hoặc có lỗi khi tải lên']);
    exit;
}

try {
    // Sử dụng trực tiếp file tạm thời mà PHP đã tạo
    $tempFile = $_FILES['image']['tmp_name'];

    // Chuẩn bị dữ liệu để gửi đến API Python
    $curl = curl_init();

    // Sử dụng CURLFile với file tạm thời
    $cfile = new CURLFile($tempFile, $_FILES['image']['type'], basename($_FILES['image']['name']));
    $data = ['image' => $cfile];

    curl_setopt_array($curl, [
        CURLOPT_URL => 'http://localhost:5000/predict',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    // Không cần phải xóa file tạm thời vì PHP sẽ tự động xóa nó
    // khi script kết thúc

    if ($err) {
        echo json_encode(['error' => 'Lỗi kết nối đến API: ' . $err]);
    } else {
        echo $response;
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Lỗi xử lý: ' . $e->getMessage()]);
}
?>