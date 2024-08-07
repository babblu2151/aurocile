<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Course - Course Management</title>
  <link rel="stylesheet" href="<?= base_url('assets/styles.css') ?>">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <?php include (APPPATH . 'Views/header.php'); ?>
  <main>
    <h1>Edit Course</h1>
    <form id="course-form">
      <input type="hidden" id="course-id" name="course_id" value="<?= $lessonId ?>">
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
      <button type="submit">Update Course</button>
    </form>
  </main>
  <?php include (APPPATH . 'Views/footer.php'); ?>

  <script src="<?= base_url('assets/scripts.js') ?>"></script>
  <script>
    $(document).ready(function () {
      const courseId = $('#course-id').val();
      const apiUrl = `http://127.0.0.1:8000/api/courses/${courseId}`;
      fetch(apiUrl, {
        headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('token')
        }
      })
        .then(response => response.json())
        .then(data => {
          $('#title').val(data.title);
          $('#description').val(data.description);
          $('#instructor').val(data.instructor);
          $('#duration').val(data.duration);
        })
        .catch(error => console.error('Error fetching course data:', error));

      $('#course-form').on('submit', function (e) {
        e.preventDefault();

        const formData = {
          title: $('#title').val(),
          description: $('#description').val(),
          instructor: $('#instructor').val(),
          duration: $('#duration').val()
        };

        $.ajax({
          url: apiUrl,
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + localStorage.getItem('token')
          },
          data: JSON.stringify(formData),
          success: function (data) {
            alert('Course updated successfully');
            window.location.href = '/courses';
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
      });
    });
  </script>
</body>

</html>