<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhận diện loài nhện</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="main-container">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="app-header text-center mb-5">
                        <h1 class="app-title"><i class="fas fa-spider me-2"></i>Hệ thống nhận diện loài nhện</h1>
                        <p class="app-subtitle">Tải lên hình ảnh nhện để phân loại chính xác loài nhện</p>
                    </div>
                    
                    <div class="card main-card">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-md-6 upload-section">
                                    <div class="upload-container p-4">
                                        <h3 class="section-title"><i class="fas fa-upload me-2"></i>Tải lên hình ảnh</h3>
                                        
                                        <form id="uploadForm" action="classify.php" method="post" enctype="multipart/form-data">
                                            <div class="upload-area" id="uploadArea">
                                                <div class="upload-content">
                                                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                                    <p class="upload-text">Kéo thả hình ảnh hoặc nhấp để chọn</p>
                                                    <p class="upload-hint">Hỗ trợ: JPG, JPEG, PNG</p>
                                                </div>
                                                <input type="file" class="file-input" id="imageUpload" name="image" accept="image/*" required>
                                            </div>
                                            
                                            <div id="imagePreview" class="image-preview mt-3 d-none">
                                                <div class="preview-container">
                                                    <img id="preview" src="#" alt="Ảnh xem trước">
                                                    <button type="button" class="btn-remove-image" id="removeImage">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="file-info mt-2">
                                                    <span id="fileName">image.jpg</span>
                                                    <span id="fileSize">0 KB</span>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-4">
                                                <button type="submit" id="submitBtn" class="btn btn-primary btn-classify w-100">
                                                    <i class="fas fa-search me-2"></i>Nhận diện loài nhện
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 result-section">
                                    <div class="result-container p-4">
                                        <div id="loadingResult" class="text-center py-5 d-none">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Đang xử lý...</span>
                                            </div>
                                            <p class="mt-3">Đang phân tích hình ảnh...</p>
                                        </div>
                                        
                                        <div id="initialMessage" class="text-center py-5">
                                            <img src="img/spider-icon.png" alt="Spider Icon" class="initial-icon mb-4">
                                            <h4>Chưa có kết quả phân loại</h4>
                                            <p class="text-muted">Vui lòng tải lên hình ảnh nhện để bắt đầu phân loại</p>
                                        </div>
                                        
                                        <div id="result" class="d-none">
                                            <h3 class="section-title mb-4"><i class="fas fa-chart-pie me-2"></i>Kết quả phân loại</h3>
                                            
                                            <div class="result-card mb-4">
                                                <div class="result-header">
                                                    <h4>Loài nhện được nhận diện</h4>
                                                </div>
                                                <div class="result-body">
                                                    <div class="detected-species">
                                                        <img id="spiderTypeImage" src="/placeholder.svg" alt="Loài nhện" class="species-image">
                                                        <div class="species-info">
                                                            <h3 id="spiderClass"></h3>
                                                            <div class="confidence-badge">
                                                                <span>Độ tin cậy: </span>
                                                                <span id="confidence" class="badge"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="probability-section">
                                                <h4 class="mb-3">Chi tiết xác suất</h4>
                                                <div class="probability-container">
                                                    <div class="prob-item" data-index="0">
                                                        <div class="prob-label">Nhện Black Widow</div>
                                                        <div class="prob-bar-container">
                                                            <div class="prob-bar">
                                                                <div id="prob0" class="prob-fill"></div>
                                                            </div>
                                                            <div id="probText0" class="prob-value">0%</div>
                                                        </div>
                                                    </div>
                                                    <div class="prob-item" data-index="1">
                                                        <div class="prob-label">Nhện Tarantula</div>
                                                        <div class="prob-bar-container">
                                                            <div class="prob-bar">
                                                                <div id="prob1" class="prob-fill"></div>
                                                            </div>
                                                            <div id="probText1" class="prob-value">0%</div>
                                                        </div>
                                                    </div>
                                                    <div class="prob-item" data-index="2">
                                                        <div class="prob-label">Nhện Jumping</div>
                                                        <div class="prob-bar-container">
                                                            <div class="prob-bar">
                                                                <div id="prob2" class="prob-fill"></div>
                                                            </div>
                                                            <div id="probText2" class="prob-value">0%</div>
                                                        </div>
                                                    </div>
                                                    <div class="prob-item" data-index="3">
                                                        <div class="prob-label">Nhện Spiny Backed OrbWeaver</div>
                                                        <div class="prob-bar-container">
                                                            <div class="prob-bar">
                                                                <div id="prob3" class="prob-fill"></div>
                                                            </div>
                                                            <div id="probText3" class="prob-value">0%</div>
                                                        </div>
                                                    </div>
                                                    <div class="prob-item" data-index="4">
                                                        <div class="prob-label">Nhện Brown Recluse</div>
                                                        <div class="prob-bar-container">
                                                            <div class="prob-bar">
                                                                <div id="prob4" class="prob-fill"></div>
                                                            </div>
                                                            <div id="probText4" class="prob-value">0%</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Thông tin chi tiết về loài nhện - Chỉ hiển thị sau khi phân loại thành công -->
                    <div id="spiderDetails" class="card mt-4 d-none">
                        <div class="card-header">
                            <h3 class="mb-0"><i class="fas fa-info-circle me-2"></i>Thông tin chi tiết về <span id="detailSpiderName"></span></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="spider-image-gallery">
                                        <img id="spiderDetailImage" src="/placeholder.svg" alt="Hình ảnh chi tiết" class="img-fluid rounded">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="spider-info-content">
                                        <h4>Đặc điểm</h4>
                                        <p id="spiderCharacteristics"></p>
                                        
                                        <h4>Môi trường sống</h4>
                                        <p id="spiderHabitat"></p>
                                        
                                        <h4>Mức độ nguy hiểm</h4>
                                        <div id="dangerLevel" class="danger-meter">
                                            <div class="danger-level-bar">
                                                <div class="danger-level-fill"></div>
                                            </div>
                                            <div class="danger-level-labels">
                                                <span>Thấp</span>
                                                <span>Trung bình</span>
                                                <span>Cao</span>
                                            </div>
                                        </div>
                                        
                                        <h4>Lưu ý</h4>
                                        <p id="spiderNotes"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Phần so sánh các loài nhện - Chỉ hiển thị sau khi phân loại thành công -->
                    <div id="spiderComparison" class="card mt-4 d-none">
                        <div class="card-header">
                            <h3 class="mb-0"><i class="fas fa-balance-scale me-2"></i>So sánh các loài nhện</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover comparison-table">
                                    <thead>
                                        <tr>
                                            <th>Loài nhện</th>
                                            <th>Kích thước</th>
                                            <th>Màu sắc</th>
                                            <th>Độc tính</th>
                                            <th>Phân bố</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="row-black-widow">
                                            <td>
                                                <div class="spider-table-info">
                                                    <img src="img/black-widow-small.jpg" alt="Black Widow">
                                                    <span>Nhện Black Widow</span>
                                                </div>
                                            </td>
                                            <td>1.5 - 1.5 cm</td>
                                            <td>Đen bóng với đốm đỏ</td>
                                            <td><span class="badge bg-danger">Cao</span></td>
                                            <td>Bắc Mỹ, Châu Âu, Châu Á</td>
                                        </tr>
                                        <tr id="row-tarantula">
                                            <td>
                                                <div class="spider-table-info">
                                                    <img src="img/tarantula-small.jpg" alt="Tarantula">
                                                    <span>Nhện Tarantula</span>
                                                </div>
                                            </td>
                                            <td>10 - 30 cm</td>
                                            <td>Nâu, đen, xám</td>
                                            <td><span class="badge bg-warning text-dark">Trung bình</span></td>
                                            <td>Nam Mỹ, Châu Phi, Châu Á</td>
                                        </tr>
                                        <tr id="row-jumping">
                                            <td>
                                                <div class="spider-table-info">
                                                    <img src="img/jumping-small.jpg" alt="Jumping">
                                                    <span>Nhện Jumping</span>
                                                </div>
                                            </td>
                                            <td>0.4 - 2.5 cm</td>
                                            <td>Đa dạng, thường có hoa văn</td>
                                            <td><span class="badge bg-success">Thấp</span></td>
                                            <td>Toàn cầu</td>
                                        </tr>
                                        <tr id="row-orbweaver">
                                            <td>
                                                <div class="spider-table-info">
                                                    <img src="img/orbweaver-small.jpg" alt="Spiny Backed OrbWeaver">
                                                    <span>Nhện Spiny Backed OrbWeaver</span>
                                                </div>
                                            </td>
                                            <td>0.5 - 3 cm</td>
                                            <td>Sặc sỡ, thường có gai</td>
                                            <td><span class="badge bg-success">Thấp</span></td>
                                            <td>Châu Mỹ, Châu Á</td>
                                        </tr>
                                        <tr id="row-brown-recluse">
                                            <td>
                                                <div class="spider-table-info">
                                                    <img src="img/brown-recluse-small.jpg" alt="Brown Recluse">
                                                    <span>Nhện Brown Recluse</span>
                                                </div>
                                            </td>
                                            <td>0.6 - 2 cm</td>
                                            <td>Nâu nhạt đến nâu sẫm</td>
                                            <td><span class="badge bg-danger">Cao</span></td>
                                            <td>Bắc Mỹ</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    <footer class="footer mt-5 bg-dark text-white py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0">&copy; 2025  Bản quyền thuộc về anh BobDev.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-1 fw-bold">Phát triển bởi:</p>
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">Ngô Thành Đạt</li>
                    <li class="list-inline-item">|</li>
                    <li class="list-inline-item">Vũ Thành Trung</li>
                    <li class="list-inline-item">|</li>
                    <li class="list-inline-item">Nguyễn Xuân Anh Dũng</li>
                </ul>
            </div>
        </div>
    </div>
</footer>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>