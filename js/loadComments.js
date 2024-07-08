function loadComments(postId, imageUrl, postUsername, description) {
    document.getElementById('postId').value = postId;

    document.getElementById('modalImageBackground').src = imageUrl;
    document.getElementById('modalImage').src = imageUrl;

    // window.location.href = 'dashboard.php?post=' + postId;

    document.getElementById('post-desc').innerHTML = `<p><b style="margin-right: 5px;">@${postUsername}</b>${description}</p>`

    const commentContainer = document.getElementById('commentContainer');
    commentContainer.innerHTML = '';

    fetch(`method/get_comments.php?post_id=${postId}`)
      .then(response => response.json())
      .then(data => {
        data.forEach(comment => {
          const commentElement = document.createElement('div');
          commentElement.classList.add('comment');
          commentElement.innerHTML = `
        <div class="d-flex flex-start mb-4 overflow-y-auto">
          <img class="rounded-circle shadow-1-strong me-3" src="${comment.avatar}" alt="avatar" width="32" height="32" />

              <div class="">
                <p class="mb-0"><b style="margin-right: 5px;">@${comment.username}</b> ${comment.text}</p>
              
                <p style="font-size: 0.7rem">${comment.datetime}</p>
                <!--
                <div class="d-flex justify-content-between align-items-center">
                  <div class="d-flex align-items-center">
                    <a href="#!" class="link-muted me-2"><i class="fas fa-thumbs-up me-1"></i>132</a>
                    <a href="#!" class="link-muted"><i class="fas fa-thumbs-down me-1"></i>15</a>
                  </div>
                  <a href="#!" class="link-muted"><i class="fas fa-reply me-1"></i> Reply</a>
                </div>
                -->
              </div>

        </div>
      `;
          commentContainer.appendChild(commentElement);
        });
      });
  }