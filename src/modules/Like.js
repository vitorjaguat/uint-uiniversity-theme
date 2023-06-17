import $ from 'jquery';

class Like {
  constructor() {
    this.events();
  }

  events() {
    $('.like-box').on('click', this.ourClickDispatcher.bind(this));
  }

  //Methods:
  ourClickDispatcher(e) {
    var currentLikeBox = $(e.target).closest('.like-box');

    if (currentLikeBox.attr('data-exists') == 'yes') {
      this.deleteLike(currentLikeBox);
    } else {
      this.createLike(currentLikeBox);
    }
  }

  createLike(currentLikeBox) {
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      }, //pass a nonce to authorize the request in the server; the nonce is generated in functions.php, see universityData
      url: universityData.root_url + '/wp-json/university/v1/manageLike',
      type: 'POST',
      data: {
        professorId: currentLikeBox.data('professor'), //or you can add ?professorId=789 to the end of the url
      },
      success: (response) => {
        currentLikeBox.attr('data-exists', 'yes'); //update heart to a filled heart (see single-professor.php)
        var likeCount = parseInt(currentLikeBox.find('.like-count').html(), 10);
        likeCount++;
        currentLikeBox.find('.like-count').html(likeCount);
        currentLikeBox.attr('data-like', response);
        console.log(response);
      },
      error: (response) => {
        console.log(response);
      },
    });
  }

  deleteLike(currentLikeBox) {
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      }, //pass a nonce to authorize the request in the server; the nonce is generated in functions.php, see universityData
      url: universityData.root_url + '/wp-json/university/v1/manageLike',
      data: {
        like: currentLikeBox.attr('data-like'),
      },
      type: 'DELETE',
      success: (response) => {
        currentLikeBox.attr('data-exists', 'no'); //update heart to a filled heart (see single-professor.php)
        var likeCount = parseInt(currentLikeBox.find('.like-count').html(), 10);
        likeCount--;
        currentLikeBox.find('.like-count').html(likeCount);
        currentLikeBox.attr('data-like', '');
        console.log(response);
      },
      error: (response) => {
        console.log(response);
      },
    });
  }
}

export default Like;
