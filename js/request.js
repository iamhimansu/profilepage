//Handling multiple MakeRequests
function MakeRequests() {
  //Grabbing form for submission
  var form = document.querySelector('.send-request');

  var page_url = $('#page_url').val();
  //Modifying and appending form data
  var formData = new FormData(form);
  formData.append('page_name', `https://profilepage.com/${page_url}`);
  //Axios sending multiple POST n GET MakeRequests
  function send_post_request() {
    return axios
      .post('controllers/links.Handler.php', formData)
      .then(function (response) {
        $('.links-collector').html(
          `<div class="d-flex align-items-center justify-content-center update-spinner">
                <div class="spinner-border" role="status" aria-hidden="true"></div></div>`
        );
        console.log(response);

        function send_get_request() {
          return axios
            .get('controllers/show.links.Handler.php')
            .then(function (response) {
              $('.links-collector').html(response.data);
              console.log(response);
            })
            .catch(function (response) {
              console.log(response);
            });
        }
        send_get_request();
      })
      .catch(function (response) {
        console.log(response);
      });
  }
  send_post_request();
}
