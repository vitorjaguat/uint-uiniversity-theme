import $ from 'jquery';

class Search {
  // 1. describe and create/initiate our object
  constructor() {
    this.openButton = $('.js-search-trigger');
    this.closeButton = $('.search-overlay__close');
    this.searchOverlay = $('.search-overlay');
    this.searchField = $('#search-term');
    this.resultsDiv = $('#search-overlay__results');
    this.events();
    this.isOverlayOpen = false;
    this.typingTimer;
    this.isSpinnerVisible = false;
    this.previousValue;
  }

  // 2. events
  events() {
    this.openButton.on('click', this.openOverlay.bind(this));
    this.closeButton.on('click', this.closeOverlay.bind(this));
    $(document).on('keydown', this.keyPressDispatcher.bind(this));
    this.searchField.on('keyup', this.typingLogic.bind(this));
  }

  // 3. methods (functions, actions...)
  typingLogic() {
    if (this.searchField.val() != this.previousValue) {
      clearTimeout(this.typingTimer);

      if (this.searchField.val()) {
        if (!this.isSpinnerVisible) {
          this.resultsDiv.html('<div class="spinner-loader"></div>');
          this.isSpinnerVisible = true;
        }
        this.typingTimer = setTimeout(this.getResults.bind(this), 1000);
      } else {
        this.resultsDiv.html('');
        this.isSpinnerVisible = false;
      }
    }
    this.previousValue = this.searchField.val();
  }

  getResults() {
    $.getJSON(
      'http://uint-university.local/wp-json/wp/v2/posts?search=' +
        this.searchField.val(),
      (posts) => {
        this.resultsDiv.html(`
            <h2 class="search-overlay__section-title">Search Results</h2>
            ${
              posts.length
                ? '<ul class="link-list min-list">'
                : '<p>No results.</p>'
            }
                ${posts
                  .map(
                    (item) =>
                      `
                    <li>
                        <a href='${item.link}'>${item.title.rendered}</a>
                    </li>
                `
                  )
                  .join('')}
            ${posts.length ? '</ul>' : ''}
            `);
      }
    );
  }

  openOverlay() {
    this.searchOverlay.addClass('search-overlay--active');
    $('body').addClass('body-no-scroll');
    this.isOverlayOpen = true;
  }

  closeOverlay() {
    this.searchOverlay.removeClass('search-overlay--active');
    $('body').removeClass('body-no-scroll');
    this.isOverlayOpen = false;
  }

  keyPressDispatcher(e) {
    const key = e.keyCode;
    if (
      key == 83 &&
      !this.isOverlayOpen &&
      !$('input, textarea').is(':focus') //only if the 's' key is not being pressed inside an input or textarea
    ) {
      this.openOverlay();
    }
    if (key == 27 && this.isOverlayOpen) {
      this.closeOverlay();
    }
    // console.log(key);
  }
}

export default Search;
