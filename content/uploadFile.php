<div class="app">
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Gambar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="edit-container">
                        <img id="image" style="width: 360px;">
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <i id="saveNotif"></i>
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                    <button type="button" class="btn btn-primary" id="saveCropButton">Save</button>
                </div>
            </div>
        </div>
    </div>

    <main class="upload-container">
        <h1 class="feed-title">Upload</h1>
        <form class="row g-3">
            <div class="col-md-12 form-container">
                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control rounded" name="caption" placeholder="Add Caption" id="caption" style="height: 100px; resize: none;"><?= isset($_GET['caption']) ? trim($_GET['caption']) : null; ?></textarea>
                        <label for="caption">Tambahkan Caption</label>
                    </div>
                </div>
                <div class="frame rounded">
                    <div class="center rounded" id="preview-container">
                        <div class="title" id="drop-title">
                            <h2>Drop file to upload</h2>
                        </div>

                        <div class="dropzone" id="dropzone">
                            <img src="http://100dayscss.com/codepen/upload.svg" class="upload-icon" />
                            <input type="file" name="fileToUpload" id="fileToUpload" class="upload-input form-control" onchange="previewFile()">
                            <input type="hidden" name="croppedImage" id="croppedImage">
                        </div>
                    </div>
                </div>
            </form>
                <i><?= $notification ?></i>
                <div class="text-center">
                    <button id="uploadImageButton" class="btn btn-primary">Posting</button>
                    <button type="button" class="btn btn-outline-primary" style="display: none;" id="editButton" data-bs-toggle="modal" data-bs-target="#editModal">
                        Edit
                    </button>
                </div>
    </main>
</div>


<script src="https://unpkg.com/cropperjs"></script>
<script>
    function previewFile() {
        const previewContainer = document.getElementById('preview-container');
        const dropzone = document.getElementById('dropzone');
        const title = document.getElementById('drop-title');
        const file = document.getElementById('fileToUpload').files[0];
        const reader = new FileReader();

        reader.addEventListener("load", function() {

            dropzone.style.opacity = 0;
            title.style.opacity = 0;
            previewContainer.style.backgroundImage = `url(${reader.result})`;
            previewContainer.style.backgroundSize = 'cover';

            // Auto-crop to 1:1 aspect ratio
            const img = document.createElement('img');
            img.src = reader.result;
            img.onload = function() {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                const size = Math.min(img.width, img.height);
                canvas.width = size;
                canvas.height = size;
                ctx.drawImage(img, (img.width - size) / 2, (img.height - size) / 2, size, size, 0, 0, size, size);
                const croppedImageURL = canvas.toDataURL();
                previewContainer.style.backgroundImage = `url(${croppedImageURL})`;
                previewContainer.style.backgroundSize = 'cover';

                // Prepare for upload
                canvas.toBlob(function(blob) {
                    document.getElementById('croppedImage').value = URL.createObjectURL(blob);
                });
            };
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }
    }

    document.getElementById('saveCropButton').addEventListener('click', function() {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas();
            canvas.toBlob(function(blob) {
                const formData = new FormData();
                formData.append('croppedImage', blob);
                
                const url = URL.createObjectURL(blob);
                const previewContainer = document.getElementById('preview-container');
                previewContainer.style.backgroundImage = `url(${url})`;
                previewContainer.style.backgroundSize = 'cover';
                document.getElementById('croppedImage').value = url;
                
                const saveNotif = document.getElementById('saveNotif');
                saveNotif.innerHTML = '| Perubahan disimpan';
                setTimeout(() => {
                    saveNotif.innerHTML = '';
                }, 2000);
            });
        }
        // var myModal = new bootstrap.Modal(document.getElementById("editModal"), {});
        // myModal.hide();
    });


        let cropper;
        document.getElementById('fileToUpload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('image');
                    img.src = e.target.result;
                    // img.style.display = 'block';
                    if (cropper) {
                        cropper.destroy();
                    }

                    let minWidth = window.innerWidth < 574 ? 240 : 466;
                    // console.log(minWidth);
                    cropper = new Cropper(img, {
                        minContainerWidth: minWidth,
                        minContainerHeight: minWidth - 200,
                        dragMode: 'move',
                        aspectRatio: 1,
                        viewMode: 2,
                        autoCropArea: 1
                    });
                    // console.log(window.innerWidth);
                    document.getElementById('editButton').style.display = 'inline';
                }
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('uploadImageButton').addEventListener('click', function(e) {
        e.preventDefault();
        const formData = new FormData();
        const caption = document.getElementById('caption').value;
        const croppedBlobURL = document.getElementById('croppedImage').value;


        if (croppedBlobURL) {
            fetch(croppedBlobURL)
            .then(res => res.blob())
            .then(blob => {
                formData.append('caption', caption);
                formData.append('croppedImage', blob);
                formData.append('originalImage', document.getElementById('fileToUpload').files[0]);

                fetch('method/uploadPost.php', {
                    method: 'POST',
                    body: formData,
                }).then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          alert('Postingan berhasil diupload');
                      } else {
                          alert('Upload gagal');
                      }
                  }).catch(error => {
                      console.error('Error:', error);
                      alert('Upload gagal');
                  });
            });
        }
        else {
            alert('Gambar blob tidak tersedia.');
        }
    });
    </script>