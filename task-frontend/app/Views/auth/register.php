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
    <h1>Register</h1>
    <form id="register-form">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name"><br>
      <label for="email">Email:</label>
      <input type="email" id="email" name="email"><br>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password"><br>
      <label for="password_confirmation">Confirm Password:</label>
      <input type="password" id="password_confirmation" name="password_confirmation"><br>
      <button type="submit">Register</button>
    </form>
  </main>

  <?php include (APPPATH . 'Views/footer.php'); ?>

  <script src="<?= base_url('assets/scripts.js') ?>"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#register-form').on('submit', function (event) {
        event.preventDefault();

        const apiUrl = 'http://127.0.0.1:8000/api/register';
        const formData = {
          name: $('#name').val(),
          email: $('#email').val(),
          password: $('#password').val(),
          password_confirmation: $('#password_confirmation').val(),
        };

        $.ajax({
          url: apiUrl,
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          data: JSON.stringify(formData),
          success: function (data) {
            alert('Registered successfully');
            window.location.href = '/login';
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