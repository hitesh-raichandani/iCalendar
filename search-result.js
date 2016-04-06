function createEmployee() {
    response = new Array();
    start_date = $("#date-fmt").val() + " " + $("#ftime").val()
    end_date = $("#date-fmt").val() + " " + $("#ttime").val()
    console.log(start_date)
    console.log(end_date)
    $.ajax({
        url: "getSearchResults.php",
        type: "POST",
        data: {
            'start': start_date,
            'end': end_date
        },
        success: function(msg) {
            var userName = msg;
            console.log(msg)
            window.location.href = "search-result.php";
        },
        dataType: "json"
    });
}

function displayEmployees(name, pics) {
    console.log(name);
    for (var i = 0; i < name.length; i++) {
        var employee = document.createElement('div');
        employee.className = 'employee-details-display effect2';

        var wrapper = document.createElement('div');
        wrapper.className = 'image-name-wrapper';

        var img = document.createElement("img");
        img.src = pics[i];

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
        h.innerHTML = name[i];

        var n = document.createElement('div');
        n.className = 'employee-name';
        n.appendChild(h);
        wrapper.appendChild(n);
        employee.appendChild(wrapper);
        document.getElementById('all-employee-display').appendChild(employee);
    }
    // var name = ['Hitesh Raichandani', 'Kush Ahuja', 'Andrew Seaman', 'Kartikey Garg', 'Sai Srinivas'];
    // var j;

    // var workWrapper = document.createElement('div');
    // workWrapper.className = 'workplace-name-employee-wrapper effect2';

    // var header = document.createElement('div');
    // header.className = 'workplace-name-header effect2';

    // var wn = document.createElement('h2');
    // wn.innerHTML = "Workplace Name";

    // header.appendChild(wn);

    // workWrapper.appendChild(header);


    // var employee = document.createElement('div');
    // employee.className = 'employee-details-display';

    // for(j = 0; j < name.length; j++)
    // {

    // 	var wrapper = document.createElement('div');
    // 	wrapper.className = 'image-name-wrapper';

    // 	var img = document.createElement("img");
    // 	img.src="https://www.justpark.com/media/img/misc/avatar-st.png";

    // 	var iContainer = document.createElement('div');
    // 	iContainer.className = 'image-container';

    // 	var dummy = document.createElement('div');
    // 	dummy.className = 'dummy';

    // 	var image = document.createElement('div');
    // 	image.className = 'employee-picture';

    // 	var centerer = document.createElement('div');
    // 	centerer.className = 'centerer';

    // 	image.appendChild(centerer);
    // 	image.appendChild(img);

    // 	iContainer.appendChild(dummy);
    // 	iContainer.appendChild(image);
    // 	wrapper.appendChild(iContainer);

    // 	var h = document.createElement('h3');
    // 	h.innerHTML = name[j];

    // 	var n = document.createElement('div');
    // 	n.className = 'employee-name';
    // 	n.appendChild(h);
    // 	wrapper.appendChild(n);
    // 	employee.appendChild(wrapper);
    // }
    // workWrapper.appendChild(employee);
    // document.getElementById('all-workplace-display').appendChild(workWrapper);
}