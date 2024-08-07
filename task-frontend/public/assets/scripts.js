document.addEventListener('DOMContentLoaded', function () {

  const token = localStorage.getItem('token');
  const authMenuItem = document.getElementById('auth-menu-item');

  if (token) {
    authMenuItem.innerHTML = '<a href="#" id="logout-btn">Logout</a>';
    document.getElementById('logout-btn').addEventListener('click', function (e) {
      e.preventDefault();
      localStorage.removeItem('token');
      window.location.href = '/login';
    });
  } else {
    authMenuItem.innerHTML = '<a href="/login">Login</a>';
  }

  const logoutBtn = document.getElementById('logout-btn');

  if (logoutBtn) {
    logoutBtn.addEventListener('click', function (e) {
      e.preventDefault();

      localStorage.removeItem('token');

      fetch(`127.0.0.1:8000/api/logout`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + localStorage.getItem('token') || ''
          },
          body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
          if (data.message === 'Logged out successfully') {
            window.location.href = `127.0.0.1:8000/login`;
          } else {
            console.error('Logout failed');
          }
        })
        .catch(error => console.error('Error:', error));
    });
  }
});