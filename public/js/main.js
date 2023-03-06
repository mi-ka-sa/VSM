jQuery(document).ready(function($) {
    $('#score-div').on('click', '.fa', function(e) {
        const id = $(this).data('tid');
        const value = $(this).data('value');
        $.ajax({
            url: 'score/add',
            type: 'POST',
            data: { id: id, value: value },
            success: function(res) {
                location.reload();
            },
            error: function() {
                alert('Error: not response from Controller');
            },
        });
    });

    $('#score-div').on('click', '.delete-score', function(e) {
        const id = $(this).data('tid');
        $.ajax({
            url: 'score/delete',
            type: 'POST',
            data: { id: id },
            success: function(res) {
                location.reload();
            },
            error: function() {
                alert('Error: not response from Controller');
            },
        });
    });

    $('#score-div').on('click', '.buttom-wishlist', function(e) {
        const id = $(this).data('tid');
        const action = $(this).data('action');
        $.ajax({
            url: 'wishlist/' + action,
            type: 'POST',
            data: { id: id },
            success: function(res) {
                location.reload();
            },
            error: function() {
                alert('Error: not response from Controller');
            },
        });
    });
});