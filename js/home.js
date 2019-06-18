// Get DOM Elements
const modal = document.querySelector('#post-modal');
const modalBtn = document.querySelector('#postBtn');
const closeBtn = document.querySelector('.close');
const closeBut = document.querySelector('.closeBtn');

// Events
modalBtn.addEventListener('click', openModal);
closeBtn.addEventListener('click', closeModal);
window.addEventListener('click', outsideClick);

// Open
function openModal() {
  modal.style.display = 'block';
}

function openModal2() {
  forgotModal.style.display = 'block';
  modal.style.display = 'none';
}

// Close
function closeModal() {
  modal.style.display = 'none';
  forgotModal.style.display = 'none';
}

function closeModal2() {
  forgotModal.style.display = 'none';
}

// Close If Outside Click
function outsideClick(e) {
  if (e.target == modal) {
    modal.style.display = 'none';
    forgotModal.style.display = 'none';
  }
}

function outsideClick(e) {
  if (e.target == forgotModal) {
    modal.style.display = 'none';
    forgotModal.style.display = 'none';
  }
}
