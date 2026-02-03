function showToast(type, title, message) {
  let toast = document.getElementById('toast');
  let icon = document.getElementById('toast-icon');
  let titleElement = document.getElementById('toast-title');
  let messageElement = document.getElementById('toast-message');
  
  toast.classList.remove('toast-show', 'toast-success', 'toast-info', 'toast-warning', 'toast-error');
  
  toast.classList.add(type, 'toast-show');
  
  titleElement.textContent = title;
  messageElement.textContent = message;
  
  switch(type) {
      case 'toast-success': icon.className = 'ri-checkbox-circle-line toast-icon'; break;
      case 'toast-info': icon.className = 'ri-information-line toast-icon'; break;
      case 'toast-warning': icon.className = 'ri-alert-line toast-icon'; break;
      case 'toast-error': icon.className = 'ri-close-circle-line toast-icon'; break;
  }
  
  setTimeout(closeToast, 3000);
}

function closeToast() {
  document.getElementById('toast').classList.remove('toast-show');
}