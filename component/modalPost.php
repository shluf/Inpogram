<div class="modal fade" id="commentsModal" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-body p-0">

        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="container-comment flex-xl-row row">
                <img id="modalImageBackground" src="" class="modalImageBackground"></img>

                <div class="modalImageContainer col-xl-6 p-0">

                  <img id="modalImage" class="modalImage" src="" alt="profile">

                </div>
                <div class="comment-content col-xl-6">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="commentsModalLabel">Komentar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>



                  <section class="comments overflow-y-auto">
                    <div id="post-desc">

                    </div>
                    <div class="container pb-5" id="commentContainer">
                      <!-- Komentar akan ditambahkan di sini -->

                    </div>
                  </section>

                  <form id="commentForm">
                    <span id="replyContainer" class="px-3 pt-3 d-none" style="position: absolute;
                      bottom: 25px;
                      margin-left: 10px;
                      padding-bottom: 20px;
                      background-color: #e4e4e4;
                      border-radius: 15px 15px 0 0;
                      width: 100%;
                      max-width: 520px;">
                      <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div style="border-left: solid #c2506e;">
                          <p class="m-0 px-2 pb-0" style="font-size: 0.8rem;">Membalas</p>
                          <p id="replyingUsername" class="m-0 pt-0 px-2"></p>
                        </div>
                        <span class="btn" onclick="closeReply()">
                          <i class="bi bi-x"></i>
                        </span>
                      </div>
                    </span>
                    <div class="commentForm position-absolute d-flex flex-row rounded shadow" style="bottom: 10px; max-width: 545px;">

                      <input type="hidden" name="reply_comment_id" id="ReplyToCommentId" value="">
                      <input type="hidden" id="postId" name="post_id">
                      <input type="text" class="form-control" id="comment-post" name="comment_post" placeholder="Tambah komentar..." style="border:0 solid white; background-color: transparent; border-radius:0;">

                      <button type="submit" class="btn w-25"><i class="bi bi-send"></i></button>


                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
