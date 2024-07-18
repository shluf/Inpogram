
<div class="modal fade" id="commentsModal" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
          <div class="modal-content">

            <div class="modal-body p-0" style="height: 400px;">

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



                        <section class="overflow-y-auto" style="height: calc(400px - 62.8px)">
                          <div id="post-desc">

                          </div>
                          <div class="container pb-5" id="commentContainer">
                            <!-- Komentar akan ditambahkan di sini -->

                          </div>
                        </section>

                        <form id="commentForm">
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
      