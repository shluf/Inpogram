<div class="app">
    <main class="upload-container">
        <h1 class="feed-title">Upload</h1>
        <form class="row g-3" action="upload.php" method="post" enctype="multipart/form-data">
            <div class="col-md-12 form-container">
                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control" name="caption" placeholder="Add Caption" id="floatingTextarea" style="height: 100px;"><?= isset($_GET['caption']) ? trim($_GET['caption']) : null; ?></textarea>
                        <label for="floatingTextarea">Add Caption</label>
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
                        </div>
                    </div>
                </div>
                <i><?= $notification ?></i>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Posting</button>
                    <button type="reset" class="btn btn-secondary">Clear</button>
                </div>
        </form>
    </main>
</div>

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
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>