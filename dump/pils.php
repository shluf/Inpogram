<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cropper.js Example</title>
    <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet">
    <style>
        img {
            display: block;
            max-width: 100%;
        }
        .container {
            max-width: 640px;
            margin: 20px auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <input type="file" id="fileInput">
        <br>
        <img id="image" style="display:none;">
        <br>
        <button id="cropButton" style="display:none;">Crop and Upload</button>
    </div>
    <script src="https://unpkg.com/cropperjs"></script>
    <script>
        let cropper;
        document.getElementById('fileInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('image');
                    img.src = e.target.result;
                    img.style.display = 'block';
                    if (cropper) {
                        cropper.destroy();
                    }
                    cropper = new Cropper(img, {
                        dragMode: 'move',
                        aspectRatio: 1,
                        viewMode: 2,
                        autoCrop: false
                    });
                    // const cropperContainer = document.querySelector('.cropper-container');
                    // cropperContainer.style.width = '480px';
                    document.getElementById('cropButton').style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('cropButton').addEventListener('click', function() {
            if (cropper) {
                const canvas = cropper.getCroppedCanvas();
                canvas.toBlob(function(blob) {
                    const formData = new FormData();
                    formData.append('croppedImage', blob);
                    formData.append('originalImage', document.getElementById('fileInput').files[0]); // Menambahkan gambar asli ke FormData

                    fetch('upload.php', {
                        method: 'POST',
                        body: formData,
                    }).then(response => response.json())
                      .then(data => {
                          if (data.success) {
                              alert('Image successfully uploaded');
                          } else {
                              alert('Upload failed');
                          }
                      }).catch(error => {
                          console.error('Error:', error);
                          alert('Upload failed');
                      });
                });
            }
        });
    </script>
</body>
</html>
