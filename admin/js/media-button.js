jQuery(document).ready(function($) {
  // Function to insert the button
  function insertAltTextButton() {
      if (!$('#generate-alt-text-btn').length) { // Check if the button is not already added
          // Adjust the selector based on where you want to insert the button
          $('.attachment-alt-text, .alt-text').append('<br></b><p class="alt-generate-alt-text-wrapper" style="display:inline-block;width:100%;"><input type="button" id="generate-alt-text-btn" class="button" value="Generate Alt Text"><span class="spinner"></span></p><br><br>');
      }
  }

  // Mutation observer to detect when media details are opened
  var observer = new MutationObserver(function(mutations) {
      mutations.forEach(function(mutation) {
          if (mutation.addedNodes.length) {
              insertAltTextButton();
          }
      });
  });

  // Start observing
  observer.observe(document.body, { childList: true, subtree: true });

  // Handle button click
  $(document).on('click', '#generate-alt-text-btn', function(e) {
      e.preventDefault();
    // Function to get URL parameters
       function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
      }

      var attachmentId = getUrlParameter('item'); // Get the attachment ID from URL parameter

      if (!attachmentId) {
        attachmentId = $('input[name="post_ID"]').val(); // Fallback to post_ID if not found
      }
      $('.alt-generate-alt-text-wrapper').find('span.spinner').addClass('is-active');
      // disable the button
      $('#generate-alt-text-btn').attr('disabled', 'disabled');
      $.ajax({
          url: aiAltTextGenerator.ajax_url,
          type: 'POST',
          data: {
              action: 'generate_alt_text',
              nonce: aiAltTextGenerator.nonce,
              post_id: attachmentId
          },
          success: function(response) {
              if (response.success) {
                var altText = response.data;
                $('.alt-generate-alt-text-wrapper').find('span.spinner').removeClass('is-active');
                // enable the button
                $('#generate-alt-text-btn').removeAttr('disabled');
                if($('textarea[name="_wp_attachment_image_alt"]').length) {
                  $('textarea[name="_wp_attachment_image_alt"]').val(altText);
                }

                if($('.alt-text textarea').length) {
                  $('.alt-text textarea').val(altText);
                }
              }
          }
      });
  });
});
