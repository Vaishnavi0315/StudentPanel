document.getElementById('language').addEventListener('change', function() {
    var language = this.value;
    if (language === 'english') {
        window.location.href = 'instructionPage.php'; // Replace 'englishPage.html' with the actual page URL
    } else if (language === 'hindi') {
        window.location.href = 'hindiPage.html'; // Replace with the actual page URL for Hindi
    } else if (language === 'marathi') {
        window.location.href = ''; // Replace with the actual page URL for Marathi
    } else if (language === 'gujarati') {
        window.location.href = 'gujaratiPage.html'; // Replace with the actual page URL for Gujarati
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
    
