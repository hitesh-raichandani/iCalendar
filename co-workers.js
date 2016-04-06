function showHide(e) {
    $(e).closest('.workplace-name-employee-wrapper').find('.all-employee-display').toggle("medium");
}

function createEmployee() {
    response = new Array();
    $.ajax({
        url: "getCoworkers.php",
        type: "POST",
        success: function(msg) {
            response = msg;
            displayEmployees(response)
        },
        dataType: "json"
    });
}

function displayEmployees(response) {
    console.log(response)
    var workplace = [];
    workplace.push(response['workplace']);
    var name = []
    var pictures = []
    var positions = []
    for (var i in response['users']) {
        name.push(response['users'][i]['name'])
        pictures.push(response['users'][i]['picture'])
        positions.push(response['users'][i]['position'])
    }
    var i, j;

    for (i = 0; i < workplace.length; i++) {
        var workWrapper = document.createElement('div');
        workWrapper.className = 'workplace-name-employee-wrapper effect2';

        var header = document.createElement('div');
        header.className = 'workplace-name-header';

        var wn = document.createElement('h2');
        wn.innerHTML = workplace[i];

        var wnDiv = document.createElement('div');
        wnDiv.className = 'workplace-name-div';
        wnDiv.appendChild(wn);

        var button = document.createElement('div');
        button.className = 'toggle-button';

        var img1 = document.createElement("img");
        img1.src = "down.png";

        var headerWrapper = document.createElement('div');
        headerWrapper.className = 'workplace-name-button-wrapper';

        button.appendChild(img1);
        button.setAttribute("onclick", "showHide(this)");

        headerWrapper.appendChild(wnDiv);
        headerWrapper.appendChild(button);
        header.appendChild(headerWrapper);

        workWrapper.appendChild(header);

        var allEmployee = document.createElement('div');
        allEmployee.className = 'all-employee-display';

        for (j = 0; j < name.length; j++) {
            var employee = document.createElement('div');
            employee.className = 'employee-details-display efect2';

            var wrapper = document.createElement('div');
            wrapper.className = 'image-name-wrapper';

            var img = document.createElement("img");
            if (pictures[j] == null || pictures[j].length < 1) {
                img.src = "https://www.justpark.com/media/img/misc/avatar-st.png";
            } else {
                img.src = pictures[j]
            }

            var iContainer = document.createElement('div');
            iContainer.className = 'image-container';

            var dummy = document.createElement('div');
            dummy.className = 'dummy';

            var image = document.createElement('div');
            image.className = 'employee-picture';

            var centerer = document.createElement('div');
            centerer.className = 'centerer';

            image.appendChild(centerer);
            image.appendChild(img);

            iContainer.appendChild(dummy);
            iContainer.appendChild(image);
            wrapper.appendChild(iContainer);

            var h = document.createElement('h3');
            h.innerHTML = name[j];

            var n = document.createElement('div');
            n.className = 'employee-name';

            var position = document.createElement('div');
            position.className = 'employee-position';
            position.innerHTML = positions[j];

            n.appendChild(h);
            wrapper.appendChild(n);
            wrapper.appendChild(position);
            employee.appendChild(wrapper);
            allEmployee.appendChild(employee);
        }

        workWrapper.appendChild(allEmployee);
        document.getElementById('all-workplace-display').appendChild(workWrapper);
    }
}