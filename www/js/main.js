document.addEventListener('DOMContentLoaded', function() {
    // Các phần tử DOM
    const uploadForm = document.getElementById('uploadForm');
    const uploadArea = document.getElementById('uploadArea');
    const imageUpload = document.getElementById('imageUpload');
    const imagePreview = document.getElementById('imagePreview');
    const preview = document.getElementById('preview');
    const removeImage = document.getElementById('removeImage');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const submitBtn = document.getElementById('submitBtn');
    const result = document.getElementById('result');
    const initialMessage = document.getElementById('initialMessage');
    const loadingResult = document.getElementById('loadingResult');
    const spiderDetails = document.getElementById('spiderDetails');
    const spiderComparison = document.getElementById('spiderComparison');
    
    // Thông tin chi tiết về các loài nhện
    const spiderInfo = {
        'Nhện Black Widow': {
            image: 'img/black-widow.jpg',
            characteristics: 'Nhện Black Widow có màu đen bóng với hình đồng hồ cát màu đỏ đặc trưng ở bụng. Cơ thể nhỏ nhưng có hình dạng rõ ràng với chân dài và mảnh.',
            habitat: 'Thường sống ở những nơi tối, khô ráo như gầm nhà, khe đá, thùng gỗ, hoặc các góc tối trong nhà kho.',
            dangerLevel: 80,
            notes: 'Nọc độc của Black Widow rất nguy hiểm, có thể gây đau đớn dữ dội và các triệu chứng thần kinh. Cần được điều trị y tế ngay lập tức nếu bị cắn.'
        },
        'Nhện Tarantula': {
            image: 'img/tarantula.jpg',
            characteristics: 'Nhện Tarantula có kích thước lớn, thân phủ lông dày, chân to và khỏe. Màu sắc đa dạng từ nâu đến đen tùy loài.',
            habitat: 'Sống trong hang đất ở các vùng nhiệt đới và cận nhiệt đới, một số loài thích nghi với môi trường sa mạc.',
            dangerLevel: 40,
            notes: 'Mặc dù trông đáng sợ nhưng hầu hết các loài tarantula không gây nguy hiểm cho con người. Nọc độc thường chỉ gây đau và sưng tại chỗ.'
        },
        'Nhện Jumping': {
            image: 'img/jumping.jpg',
            characteristics: 'Nhện Jumping có kích thước nhỏ, thân hình gọn gàng, mắt lớn và phát triển. Có khả năng nhảy xa gấp nhiều lần chiều dài cơ thể.',
            habitat: 'Phân bố rộng rãi, thường sống trên cây cối, tường nhà, và các bề mặt có ánh sáng mặt trời.',
            dangerLevel: 10,
            notes: 'Hoàn toàn vô hại với con người, thậm chí còn có lợi vì săn các côn trùng gây hại. Thường được coi là loài nhện thân thiện.'
        },
        'Nhện Spiny Backed OrbWeaver': {
            image: 'img/orbweaver.jpg',
            characteristics: 'Có hình dạng độc đáo với phần bụng cứng, thường có gai và màu sắc rực rỡ. Kích thước nhỏ đến trung bình.',
            habitat: 'Thường dệt mạng nhện hình tròn ở những khu vực có cây cối, vườn hoa và bụi rậm.',
            dangerLevel: 5,
            notes: 'Hoàn toàn vô hại với con người. Nổi bật với khả năng dệt mạng nhện phức tạp và đẹp mắt, giúp kiểm soát côn trùng.'
        },
        'Nhện Brown Recluse': {
            image: 'img/brown-recluse.jpg',
            characteristics: 'Màu nâu nhạt đến nâu sẫm, có dấu hiệu hình violin màu nâu đậm trên phần đầu ngực. Kích thước trung bình.',
            habitat: 'Thích sống ở những nơi ít người qua lại, tối và khô như tủ quần áo, gác mái, kho chứa đồ.',
            dangerLevel: 75,
            notes: 'Nọc độc có thể gây hoại tử da nghiêm trọng. Cần được điều trị y tế nếu bị cắn. Tuy nhiên, chúng hiếm khi tấn công trừ khi bị đe dọa.'
        }
    };
    
    // Xử lý kéo thả hình ảnh
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight() {
        uploadArea.classList.add('border-primary');
    }
    
    function unhighlight() {
        uploadArea.classList.remove('border-primary');
    }
    
    uploadArea.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length) {
            imageUpload.files = files;
            updateImagePreview(files[0]);
        }
    }
    
    // Hiển thị ảnh xem trước khi người dùng chọn file
    imageUpload.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            updateImagePreview(file);
        }
    });
    
    function updateImagePreview(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            imagePreview.classList.remove('d-none');
            imagePreview.classList.add('fade-in');
            
            // Hiển thị thông tin file
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
        }
        reader.readAsDataURL(file);
    }
    
    function formatFileSize(bytes) {
        if (bytes < 1024) return bytes + ' bytes';
        else if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        else return (bytes / 1048576).toFixed(1) + ' MB';
    }
    
    // Xử lý nút xóa ảnh
    removeImage.addEventListener('click', function() {
        imagePreview.classList.add('d-none');
        imageUpload.value = '';
    });
    
    // Xử lý form submit
    uploadForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!imageUpload.files.length) {
            alert('Vui lòng chọn một hình ảnh để phân loại');
            return;
        }
        
        const formData = new FormData(this);
        
        // Hiển thị trạng thái đang xử lý
        initialMessage.classList.add('d-none');
        result.classList.add('d-none');
        loadingResult.classList.remove('d-none');
        
        submitBtn.disabled = true;
        
        fetch('classify.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Khôi phục nút submit
            submitBtn.disabled = false;
            loadingResult.classList.add('d-none');
            
            if (data.error) {
                alert('Lỗi: ' + data.error);
                initialMessage.classList.remove('d-none');
                return;
            }
            
            // Hiển thị kết quả
            updateResults(data);
            
            // Hiển thị thông tin chi tiết về loài nhện được phát hiện
            showSpiderDetails(data.class);
            
            // Hiển thị bảng so sánh và đánh dấu loài được phát hiện
            showSpiderComparison(data.class);
        })
        .catch(error => {
            submitBtn.disabled = false;
            loadingResult.classList.add('d-none');
            initialMessage.classList.remove('d-none');
            alert('Lỗi: ' + error.message);
        });
    });
    
    function updateResults(data) {
        // Cập nhật thông tin loài nhện
        document.getElementById('spiderClass').textContent = data.class;
        
        // Cập nhật hình ảnh loài nhện
        const spiderTypeImage = document.getElementById('spiderTypeImage');
        spiderTypeImage.src = spiderInfo[data.class].image;
        spiderTypeImage.alt = data.class;
        
        // Cập nhật độ tin cậy
        const confidenceElement = document.getElementById('confidence');
        const confidenceValue = (data.confidence * 100).toFixed(2);
        confidenceElement.textContent = confidenceValue + '%';
        
        // Đặt màu cho badge độ tin cậy
        if (confidenceValue >= 80) {
            confidenceElement.className = 'badge bg-success';
        } else if (confidenceValue >= 50) {
            confidenceElement.className = 'badge bg-warning text-dark';
        } else {
            confidenceElement.className = 'badge bg-danger';
        }
        
        // Cập nhật thanh tiến trình cho từng loài
        const probabilities = data.all_probabilities;
        for (const [className, prob] of Object.entries(probabilities)) {
            const index = {
                'Nhện Black Widow': 0,
                'Nhện Tarantula': 1,
                'Nhện Jumping': 2,
                'Nhện Spiny Backed OrbWeaver': 3,
                'Nhện Brown Recluse': 4
            }[className];
            
            const percentage = (prob * 100).toFixed(2);
            const probBar = document.getElementById(`prob${index}`);
            
            // Sử dụng animation để cập nhật thanh tiến trình
            setTimeout(() => {
                probBar.style.width = `${percentage}%`;
            }, 100);
            
            document.getElementById(`probText${index}`).textContent = `${percentage}%`;
            
            // Đánh dấu loài có xác suất cao nhất
            const probItem = document.querySelector(`.prob-item[data-index="${index}"]`);
            if (className === data.class) {
                probItem.style.backgroundColor = '#f0e6ff';
                probItem.style.borderLeft = '4px solid var(--primary-color)';
                probBar.style.backgroundColor = '#6a1b9a';
            } else {
                probItem.style.backgroundColor = '';
                probItem.style.borderLeft = '';
                probBar.style.backgroundColor = '';
            }
        }
        
        // Hiển thị kết quả
        result.classList.remove('d-none');
        result.classList.add('slide-up');
    }
    
    function showSpiderDetails(spiderClass) {
        // Cập nhật thông tin chi tiết về loài nhện
        const info = spiderInfo[spiderClass];
        
        document.getElementById('detailSpiderName').textContent = spiderClass;
        document.getElementById('spiderDetailImage').src = info.image;
        document.getElementById('spiderCharacteristics').textContent = info.characteristics;
        document.getElementById('spiderHabitat').textContent = info.habitat;
        document.getElementById('spiderNotes').textContent = info.notes;
        
        // Cập nhật mức độ nguy hiểm
        const dangerFill = document.querySelector('.danger-level-fill');
        dangerFill.style.width = `${info.dangerLevel}%`;
        
        // Hiển thị thẻ chi tiết
        spiderDetails.classList.remove('d-none');
        spiderDetails.classList.add('slide-up');
        
        // Thêm độ trễ để tạo hiệu ứng
        setTimeout(() => {
            dangerFill.style.width = `${info.dangerLevel}%`;
        }, 300);
    }
    
    function showSpiderComparison(spiderClass) {
        // Đánh dấu loài nhện được phát hiện trong bảng so sánh
        const rows = document.querySelectorAll('.comparison-table tbody tr');
        rows.forEach(row => {
            row.classList.remove('highlighted');
        });
        
        const rowId = {
            'Nhện Black Widow': 'row-black-widow',
            'Nhện Tarantula': 'row-tarantula',
            'Nhện Jumping': 'row-jumping',
            'Nhện Spiny Backed OrbWeaver': 'row-orbweaver',
            'Nhện Brown Recluse': 'row-brown-recluse'
        }[spiderClass];
        
        const highlightedRow = document.getElementById(rowId);
        if (highlightedRow) {
            highlightedRow.classList.add('highlighted');
        }
        
        // Hiển thị bảng so sánh
        spiderComparison.classList.remove('d-none');
        spiderComparison.classList.add('slide-up');
    }
});