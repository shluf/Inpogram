<?php 
include "method/add_comment.php";
?>

<div class="modal fade" id="commentsModal" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
          <div class="modal-content">

            <div class="modal-body p-0" style="height: 468px;">

              <div class="container-fluid">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="row">
                      <div class="col-6 p-0">

                        <img id="modalImage" style="width: 100%; min-width: 468px; min-height: 468px; object-fit: cover; border-radius: 5px 0 0 5px" src="" alt="profile">

                      </div>
                      <div class="col-6">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="commentsModalLabel">Komentar</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>



                        <section class="overflow-y-auto" style="height: calc(468px - 62.8px);">
                          <div id="post-desc">

                          </div>
                          <div class="container" id="commentContainer">
                            <!-- Komentar akan ditambahkan di sini -->
                          </div>
                        </section>

                        <form id="commentForm" method="post" >
                          <div class="position-absolute w-100" style="bottom: -1px;">
                            <div class="row">
                              <div class="col-5 p-0">
                                <input type="hidden" id="postId" name="post_id">
                                <input type="text" class="form-control" id="comment-post" name="comment_post" placeholder="Tambah komentar..." style="border:0 solid white; border-radius:0;">
                              </div>
                              <div class="col-1 p-0">
                                <button type="submit" class="btn w-100"><i class="bi bi-send"></i></button>
                              </div>
                            </div>
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