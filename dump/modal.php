<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <!-- <div class="modal-header">
                  
                </div> -->
            <div class="modal-body p-0">

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-6 p-0">
                                    <img style="max-width: 100%;" src="<?php echo $row['Image']; ?>" alt="profile">
                                </div>
                                <div class="col-6">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Komentar</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <section>
                                        <div class="container overflow-y-auto">
                                            <p><b style="margin-right: 5px;">@<?php echo $row['Username']; ?></b><?php echo $row['DESCRIPTION']; ?></p>

                                            <div class="row d-flex justify-content-center">
                                                <div class="col-12">
                                                    <div class="d-flex flex-start mb-4">
                                                        <img class="rounded-circle shadow-1-strong me-3" src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(32).webp" alt="avatar" width="65" height="65" />
                                                        <div class="card w-100">
                                                            <div class="card-body p-4">
                                                                <div class="">
                                                                    <h5>Johny Cash</h5>
                                                                    <p class="small">3 hours ago</p>
                                                                    <p>
                                                                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque
                                                                        ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus
                                                                        viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla.
                                                                        Donec lacinia congue felis in faucibus ras purus odio, vestibulum in
                                                                        vulputate at, tempus viverra turpis.
                                                                    </p>

                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div class="d-flex align-items-center">
                                                                            <a href="#!" class="link-muted me-2"><i class="fas fa-thumbs-up me-1"></i>132</a>
                                                                            <a href="#!" class="link-muted"><i class="fas fa-thumbs-down me-1"></i>15</a>
                                                                        </div>
                                                                        <a href="#!" class="link-muted"><i class="fas fa-reply me-1"></i> Reply</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                    <form method="post">
                                        <div class="position-absolute bottom-0 w-100">
                                            <div class="row">
                                                <div class="col-5 p-0">
                                                    <input type="text" class="form-control" id="comment-post" name="comment-post" placeholder="Tambah komentar..." style="border:0 solid white; border-radius:0;">
                                                </div>
                                                <div class="col-1 p-0">
                                                    <button type="submit" class="btn w-75">Kirim</button>
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