document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.tab-link');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', function(event) {
            event.preventDefault();

            // Remove active class from all tabs and content
            tabs.forEach(item => item.classList.remove('active'));
            contents.forEach(content => content.classList.remove('active'));

            // Add active class to the clicked tab and corresponding content
            tab.classList.add('active');
            const activeTabContent = document.querySelector(tab.getAttribute('href'));
            activeTabContent.classList.add('active');
        });
    });
});

// get the popup container and the reschedule button
const popup = document.getElementById('reschedule-popup');
const rescheduleBtn = document.querySelectorAll('.edit');

// add event listener to each reschedule button
rescheduleBtn.forEach(btn => {
    btn.addEventListener('click', () => {
        // toggle the visibility of the popup
        popup.classList.toggle('show');
    });
});

// add event listener to the popup container to close it when clicked outside
document.addEventListener('click', (e) => {
    if (e.target!== popup &&!popup.contains(e.target)) {
        popup.classList.remove('show');
    }
});
  
// JavaScript to handle the logout action
        function logout() {
            window.location.href = 'logout.php';
        }

        // Add event listener to logout button
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('.logout').addEventListener('click', logout);
        });