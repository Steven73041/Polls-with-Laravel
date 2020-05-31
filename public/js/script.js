$(document).ready(function () {
    var k = 0;
    $('form#vote button.add').click(function (e) {
        e.preventDefault();
        $('<div class="form-group"><input class="form-control" type="text" name="answer[]" required/></div>').insertBefore($(this));
        k++;
        return false;
    });

    $('form#vote button.delete').click(function (e) {
        e.preventDefault();
        if (k > 0) {
            $(this).parent().find('.form-group:last-of-type').remove();
            k--;
        } else {
            alert("1 Επιλογή είναι υποχρεωτική");
        }
    });

    $('form#create_users button.delete').click(function (e) {
        e.preventDefault();
        if (k > 0) {
            $(this).parent().find('.form-group:last-of-type').remove();
            k--;
        } else {
            alert("1 Χρήστης τουλάχιστον είναι υποχρεωτικός.");
        }
    });

    $('form#create_users button.add').click(function (e) {
        e.preventDefault();
        $('<div class="form-group"><input class="form-control mb-3" placeholder="email" type="email" name="email[]" required/><input class="form-control mb-3" type="text" name="name[]" placeholder="Ονοματεπώνυμο"/></div>').insertBefore($(this));
        k++;
        return false;
    });

    $('[data-toggle="tooltip"]').tooltip()
});
