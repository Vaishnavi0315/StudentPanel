function load () {
    document.getElementById('assess2').style="display:none;";
    document.getElementById('assess3').style="display:none;";
    document.getElementById('check').value="Save and Next";
}
// Array containing IDs of the assessment divs
const assessments = ['assess1', 'assess2', 'assess3'];
//, 'assess4',     'assess5', 'assess6', 'assess7', 'assess8',     'assess9', 'assess10'

// Variable to keep track of the current assessment index
let currentAssessmentIndex = 0;
/*
function SaveNext() {
    // Hide the current assessment div
    document.getElementById(assessments[currentAssessmentIndex]).style.display = 'none';

    // Increment the current assessment index
    currentAssessmentIndex++;

    // Check if there are more assessments to display
    if (currentAssessmentIndex < assessments.length) {
        // Show the next assessment div
        document.getElementById(assessments[currentAssessmentIndex]).style.display = 'block';
    } else {
        // Handle the case when there are no more assessments to display
        // For example, show a completion message or hide the button
        console.log('All assessments completed');
    }
    
    // Update any other elements if needed
    document.getElementById('check').value = "Save and Next";
}*/
function Previous() {
    document.getElementById(assessments[currentAssessmentIndex]).style.display = 'none';

    // Decrement the current assessment index
    if (currentAssessmentIndex > 0) {
        currentAssessmentIndex--;
    }

    // Show the previous assessment div
    document.getElementById(assessments[currentAssessmentIndex]).style.display = 'block';
}
function SaveNext() {
    
    document.getElementById(assessments[currentAssessmentIndex]).style.display = 'none';

    currentAssessmentIndex++;

    if (currentAssessmentIndex < assessments.length) {
      
        document.getElementById(assessments[currentAssessmentIndex]).style.display = 'block';
    } else {
        
         document.getElementById('assessment-form1').submit();
    }

    
    if (currentAssessmentIndex === assessments.length -1) {
        // Enable the Save and Submit button
        document.getElementById('saveSubmit').style.display = 'none';
        // Disable the Save and Next button
        document.getElementById('saveNext').style.display = 'none';
    } else {
        // Ensure the Save and Submit button is hidden
        document.getElementById('saveSubmit').style.display = 'none';
        // Ensure the Save and Next button is shown
        document.getElementById('saveNext').style.display = 'block';
    }

    // Update any other elements if needed
    document.getElementById('check').value = "Save and Next";
}
function check () {
    
    var che= document.getElementById('check').value;
    if(che=="Login")
    {
    document.getElementById('assess2').style="display:none;";
    document.getElementById('assess1').style="display:block;";
    document.getElementById('check').value="Save and Next";
    }
    else
    {
        document.getElementById('assess2').style="height:100%;";
        document.getElementById('assess1').style="display:none";
        document.getElementById('check').value="Save and Next";
    }
    
}
function saveAssessment() {
    const form = document.getElementById('assessment-form');
    const formData = new FormData(form);

    fetch('save_assessment2.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) // Parse JSON response
    .then(data => {
        if (data.success) {
            // Redirect to assessmentPage2.html
            window.location.href = 'assessmentPage2.html';
        } else {
            alert('Error saving assessment.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error saving assessment.');
    });
}
 document.getElementById('save-and-submit').addEventListener('click', function(event) {
    event.preventDefault();
    saveAssessment();
});
