const popup = document.querySelector('.popup');
const deleteIcon = document.querySelectorAll('.delete');
const cancelPopup = document.querySelector('.cancel-popup');

deleteIcon.forEach(deleteIcon => {
    deleteIcon.onclick = function() {
        popup.classList.remove('hidden-popup');
    }
});
cancelPopup.onclick = function() {
    popup.classList.add('hidden-popup');
}