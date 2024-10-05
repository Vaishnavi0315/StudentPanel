document.getElementById('start-button').addEventListener('click', function() {
    if (confirm('Are you sure you want to start the assessment?')) {
        window.location.href = 'assessmentPage2.php'; // Replace 'assessment.html' with the actual URL of the assessment page
    }
});