document.getElementById('profile-pic-input').addEventListener('change', function(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('profile-pic');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
});

function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Open the default tab
document.getElementById("defaultOpen").click();

document.getElementById('phone').addEventListener('keypress', function (e) {
    if (!/^\d+$/.test(e.key)) {
        e.preventDefault();
    }
});

// Fetch user data and populate the form
document.addEventListener('DOMContentLoaded', function() {
    fetch('get_profile_data.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('name').placeholder = data.name;
            document.getElementById('email').placeholder = data.email;
            document.getElementById('phone').value = data.phone;
            document.getElementById('qualification').value = data.qualification;
            if(data.student_pic) {
                document.getElementById('profile-pic').src = data.student_pic;
            }
        });
});

//...

document.getElementById("save-btn").addEventListener("click", function() {
    var formData = new FormData();
    formData.append("name", document.getElementById("name").value);
    formData.append("phone", document.getElementById("phone").value);
    formData.append("qualification", document.getElementById("qualification").value);
    formData.append("profile-pic-input", document.getElementById("profile-pic-input").files[0]);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "updateprofile.php", true);
    xhr.send(formData);

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
            // Update UI here
        }
    };
});

//...
