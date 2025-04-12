from flask import Flask, request, jsonify
from flask_cors import CORS
import tensorflow as tf
import numpy as np
from PIL import Image
import io
import base64

app = Flask(__name__)
CORS(app)

# Tải mô hình
model = tf.keras.models.load_model('spider_classification_model.h5')

# Định nghĩa các lớp
classes = {
    0: 'Nhện Black Widow',
    1: 'Nhện Tarantula',
    2: 'Nhện Jumping',
    3: 'Nhện Spiny Backed OrbWeaver',
    4: 'Nhện Brown Recluse'
}

def preprocess_image(image, target_size=(224, 224)):
    # Chuyển đổi kích thước ảnh
    image = image.resize(target_size)
    # Chuyển đổi thành mảng numpy
    image_array = tf.keras.preprocessing.image.img_to_array(image)
    # Mở rộng kích thước batch
    image_array = np.expand_dims(image_array, axis=0)
    # Chuẩn hóa ảnh
    processed_image = image_array / 255.0
    return processed_image

@app.route('/predict', methods=['POST'])
def predict():
    if 'image' not in request.files:
        return jsonify({'error': 'Không tìm thấy ảnh'}), 400
    
    file = request.files['image']
    
    try:
        # Đọc và xử lý ảnh
        image = Image.open(io.BytesIO(file.read()))
        processed_image = preprocess_image(image)
        
        # Dự đoán
        predictions = model.predict(processed_image)
        predicted_class_index = np.argmax(predictions[0])
        predicted_class = classes[predicted_class_index]
        confidence = float(predictions[0][predicted_class_index])
        
        # Trả về kết quả
        return jsonify({
            'class': predicted_class,
            'confidence': confidence,
            'all_probabilities': {classes[i]: float(predictions[0][i]) for i in range(len(classes))}
        })
    
    except Exception as e:
        return jsonify({'error': str(e)}), 500

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)