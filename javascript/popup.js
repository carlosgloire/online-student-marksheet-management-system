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