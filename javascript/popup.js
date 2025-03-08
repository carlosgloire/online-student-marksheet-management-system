 // JavaScript code
 const deleteButtons = document.querySelectorAll('.delete');
 const popup = document.querySelector('.popup');
 const cancelPopupButton = document.querySelector('.cancel-popup');
 const deletePopupButton = document.querySelector('.delete-popup');

 deleteButtons.forEach(button => {
     button.addEventListener('click', function(event) {
         event.preventDefault(); // Prevent the default link behavior
         const studentId = this.getAttribute('data-formteacher-id');

         // Show the popup
         popup.classList.remove('hidden-popup');

         // Attach event listeners to the cancel and delete buttons
         cancelPopupButton.addEventListener('click', function() {
             // Hide the popup
             popup.classList.add('hidden-popup');
         });

         deletePopupButton.addEventListener('click', function() {
             // Redirect to the delete page with the student ID
             window.location.href = `delete_student.php?student_id=${studentId}`;
         });
     });
 });

 /*-------------------------------/
OUR MENU 
---------------------------------*/
// Get all menu icons
const menuIcons = document.querySelectorAll('.menu-icon');
const exitIcons = document.querySelectorAll('.exit-icon');
const nav = document.querySelector('nav');

// Loop through each menu icon
menuIcons.forEach(function(icon) {
    icon.addEventListener('click', function() {
        nav.classList.add('active');
        exitIcons.style.display = 'flex'; // Adds 'active' class to open the menu
    });
});

// Loop through each exit icon
exitIcons.forEach(function(icon) {
    icon.addEventListener('click', function() {
        nav.classList.remove('active');
        exitIcons.style.display = 'none'; // Removes 'active' class to close the menu
    });
});