<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Courses - Course Management</title>
  <link rel="stylesheet" href="<?= base_url('assets/styles.css') ?>">
</head>

<body>
  <?php include (APPPATH . 'Views/header.php'); ?>

  <main>
    <h1>Create Course</h1>
    <form id="course-form">
      <div>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
      </div>
      <div>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
      </div>
      <div>
        <label for="instructor">Instructor:</label>
        <input type="text" id="instructor" name="instructor" required>
      </div>
      <div>
        <label for="duration">Duration (hours):</label>
        <input type="text" id="duration" name="duration" required>
      </div>
      <button type="submit">Create Course</button>
    </form>

  </main>

  <?php include (APPPATH . 'Views/footer.php'); ?>

  <script src="<?= base_url('assets/scripts.js') ?>"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#course-form').on('submit', function (e) {
        e.preventDefault();

        const apiUrl = 'http://127.0.0.1:8000/api/courses';
        const formData = {
          title: $('#title').val(),
          description: $('#description').val(),
          instructor: $('#instructor').val(),
          duration: $('#duration').val()
        };
        const token = localStorage.getItem('token');
        if (token) {

          $.ajax({
            url: apiUrl,
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Authorization': 'Bearer ' + localStorage.getItem('token')
            },
            data: JSON.stringify(formData),
            success: function (data) {
              if (data.success) {
                alert(data.message);
                window.location.href = '/courses';
              }
            },
            error: function (xhr) {
              const errors = xhr.responseJSON.errors;
              let errorMessages = '';
              for (const [key, value] of Object.entries(errors)) {
                errorMessages += `${value}\n`;
              }
              alert(errorMessages);
            }
          });
        }
        else
        {
          alert('Please login first');
          window.location.href = '/login';
        }

      });
    });
  </script>
</body>

</html>