<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Course Management</title>
  <link rel="stylesheet" href="<?= base_url('assets/styles.css') ?>">
</head>

<body>
  <?php include (APPPATH . 'Views/header.php'); ?>

  <main>
    <section>
      <h2>Login</h2>
      <form id="login-form" class="forms">
        <div>
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div>
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Login</button>
      </form>
      <p>Don't have an account? <a href="<?= base_url('register') ?>">Register here</a></p>
    </section>
  </main>

  <?php include (APPPATH . 'Views/footer.php'); ?>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="<?= base_url('assets/scripts.js') ?>"></script>
  <script>
    $(document).ready(function () {
      $('#login-form').on('submit', function (event) {
        event.preventDefault();

        const apiUrl = 'http://127.0.0.1:8000/api/login';
        const formData = {
          email: $('#email').val(),
          password: $('#password').val(),
        };

        $.ajax({
          url: apiUrl,
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          data: JSON.stringify(formData),
          success: function (data) {
            localStorage.setItem('token', data.access_token);
            alert('Logged in successfully');            
            window.location.href = '/home';
          },
          error: function (xhr) {
            console.error(xhr.responseText);
          }
        });
      });
    });
  </script>
</body>

</html>