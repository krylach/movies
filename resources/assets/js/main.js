$(document).ready(function() {
    if (error) {
        $('#user-form-modal').modal();
    }

    $( ".delete-movie" ).on( "submit", function( event ) {
        if (confirm('Really delete the movie?') === false) {
          event.preventDefault();
        }
    });
});