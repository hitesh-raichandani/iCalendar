$('input').on('focusin', function() {
    $(this).parent().find('label').addClass('active');
});

$('input').on('focusout', function() {
    if (!this.value) {
        $(this).parent().find('label').removeClass('active');
    }
});

// function for uploading profile picture
$(function() {
    $('#profile_image').change(function(e) {

        var img = URL.createObjectURL(e.target.files[0]);
        $('.image').attr('src', img);
    });
});

// Add workplace dynamic insertion
/*
var register_workplace = ['work1', 'work2', 'work3', 'work4'];
$(function() {
  var workplace = document.createElement('select');
  workplace.className = 'styled-select green semi-square';

  for(var i = 0; i < register_workplace.length; i++)
  {
    var op = document.createElement('option');
    op.innerHTML = register_workplace[i];
    op.value = register_workplace[i];
    workplace.appendChild (op);
  }
  var d = document.createElement('div');
  d.appendChild(workplace);
  // $("#update-button").before(d);
  document.getElementById('add-workplace').appendChild(d);
});
*/

function updateUser() {
    name = document.getElementById('fullname').value
    address = document.getElementById('address').value
    phone = document.getElementById('phone').value
    email = document.getElementById('email').value
    position = document.getElementById('position').value
    workplace = document.getElementById('workplace').value
    picture = document.getElementById('profile_image_src').src

    console.log(picture);

    $.ajax({
        method: 'get',
        url: 'update_user.php',
        data: {
            'fullname': name,
            'address': address,
            'phone': phone,
            'email': email,
            'position': position,
            'workplace': workplace,
            'picture': picture
        },
        success: function(data) {
            document.getElementById('fullname').value = name
            document.getElementById('address').value = address
            document.getElementById('phone').value = phone
            document.getElementById('email').value = email
            document.getElementById('position').value = position
            document.getElementById('workplace').value = workplace
        }
    });
}

// Gauhe displaying no of shifts this week
$(function() {

    var g2 = new JustGage({
        id: "gauge2",
        value: 4, //give this value dynamically to change the display in guage
        min: 0,
        max: 7,
        title: "Shifts",
        label: 'this Week'

    });

    $(window).resize(function() {
        $('#gauge2')[0].innerHTML = '';

        var g2 = new JustGage({
            id: "gauge2",
            value: 4,
            min: 0,
            max: 7,
            title: "Shifts",
            label: 'this Week'

        });
    });

});