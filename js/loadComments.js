function loadComments(postId, imageUrl, postUsername, description) {
  document.getElementById('postId').value = postId;
  document.getElementById('modalImageBackground').src = imageUrl;
  document.getElementById('modalImage').src = imageUrl;
  document.getElementById('post-desc').innerHTML = `<p><b style="margin-right: 5px;">@${postUsername}</b>${description}</p>`;
  
  const commentContainer = document.getElementById('commentContainer');
  commentContainer.innerHTML = '';
  
  fetch(`method/get_comments.php?post_id=${postId}`)
      .then(response => response.json())
      .then(data => {
          const commentsMap = new Map();
          
          // Membuat struktur komentar
          data.forEach(comment => {
              comment.replies = [];
              commentsMap.set(comment.commentid, comment);
          });
          
          // Menyusun komentar bersarang
          commentsMap.forEach(comment => {
              if (comment.replyid) {
                  const parentComment = commentsMap.get(comment.replyid);
                  if (parentComment) {
                      parentComment.replies.push(comment);
                  }
              }
          });
          
          // Render komentar
          commentsMap.forEach(comment => {
              if (!comment.replyid) {
                  renderComment(comment, commentContainer, 0);
              }
          });
          
          addReplyEventListeners();
      });
}

function renderComment(comment, container, depth) {
  const commentElement = document.createElement('div');
  commentElement.classList.add('comment');
  commentElement.setAttribute('id', `comment-${comment.commentid}`);
  commentElement.style.marginLeft = `${depth * 20}px`;
  
  commentElement.innerHTML = `
      <div class="d-flex align-items-center flex-start mb-4">
          <img class="rounded-circle shadow-1-strong me-3" src="${comment.avatar}" alt="avatar" width="32" height="32" />
          <div>
              <p class="mb-0"><b style="margin-right: 5px;">@${comment.username}</b> ${comment.text}</p>
              <div class="d-flex justify-content-between align-items-center mt-1">
                  <div class="comment-item d-flex align-items-center gap-2" data-comment-id="${comment.commentid}" data-username="${comment.username}">
                      <p style="font-size: 0.7rem; margin-bottom: 0;">${comment.datetime}</p>
                      <a class="reply-button" style="font-size: 0.7rem; text-decoration: none; cursor: pointer; color: black;"><i class="bi bi-reply-fill"></i> Reply</a>
                  </div>
              </div>
          </div>
      </div>
  `;
  
  container.appendChild(commentElement);
  
  // Render balasan secara rekursif
  if (comment.replies && comment.replies.length > 0) {
      comment.replies.forEach(reply => {
          renderComment(reply, container, depth + 1);
      });
  }
}

function addReplyEventListeners() {
  document.querySelectorAll('.reply-button').forEach(function(button) {
      button.addEventListener('click', function() {
          var commentItem = this.closest('.comment-item');
          if (!commentItem) {
              console.error('Parent comment element not found');
              return;
          }
          var parentCommentId = commentItem.dataset.commentId;
          var parentUsername = commentItem.dataset.username;
          if (!parentCommentId || !parentUsername) {
              console.error('Comment ID or username not found');
              return;
          }
          var replyToCommentIdInput = document.getElementById('ReplyToCommentId');
          var commentPostInput = document.getElementById('comment-post');
          if (replyToCommentIdInput && commentPostInput) {
              replyToCommentIdInput.value = parentCommentId;
              commentPostInput.value = `@${parentUsername} `;
              commentPostInput.focus();
          } else {
              console.error('Reply inputs not found');
          }
          console.log('Replying to comment:', parentCommentId, 'by user:', parentUsername);
      });
  });
}