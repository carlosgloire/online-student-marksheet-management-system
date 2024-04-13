<script>
        // JavaScript code
    const deleteButtons = document.querySelectorAll('.delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default link behavior
            const productId = this.getAttribute('data-formteacher-id');
            const popup = this.nextElementSibling;
            popup.style.display = 'block';

            const closePopup = popup.querySelector('.cancel-popup');
            closePopup.addEventListener('click', function() {
                popup.style.display = 'none';
            });
        });
    });
</script>