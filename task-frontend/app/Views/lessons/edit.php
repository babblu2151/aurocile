<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Lesson</title>
  <link rel="stylesheet" href="<?= base_url('assets/styles.css') ?>">
</head>

<body>
  <?php include (APPPATH . 'Views/header.php'); ?>

  <main>
    <h1>Edit Lesson for Course ID: <span id="course-title" style="color:red"></span></h1>
    <form id="edit-lesson-form">
      <input type="hidden" id="lesson_id" name="lesson_id" value="<?= htmlspecialchars($lessonId) ?>">
      <label for="title">Title:</label>
      <input type="text" id="title" name="title" required><br>
      <label for="content">Content:</label>
      <textarea id="content" name="content" required></textarea><br>
      <input type="hidden" id="course_id" name="course_id" value="<?= htmlspecialchars($courseId) ?>">
      <button type="submit">Submit</button>
    </form>
  </main>

  <?php include (APPPATH . 'Views/footer.php'); ?>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
      const lessonId = $('#lesson_id').val();
      const courseId = $('#course_id').val();
      const apiUrl = `http://127.0.0.1:8000/api/lessons/${lessonId}`;

      $.ajax({
        url: apiUrl,
        method: 'GET',
        headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('token')
        },
        success: function (data) {
          $('#title').val(data.title);
          $('#content').val(data.content);
        },
        error: function (xhr) {
          console.error(xhr.responseText);
        }
      });

      $('#edit-lesson-form').on('submit', function (event) {
        event.preventDefault();

        const apiUrl = `http://127.0.0.1:8000/api/lessons/${lessonId}`;
        const formData = {
          title: $('#title').val(),
          content: $('#content').val(),
          course_id: $('#course_id').val(),
        };

        $.ajax({
          url: apiUrl,
          method: 'PUT',
          headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('token'),
            'Content-Type': 'application/json'
          },
          data: JSON.stringify(formData),
          success: function (data) {
            alert('Lesson updated successfully');
            window.location.href = `<?= base_url('courses/' . $courseId . '/lessons') ?>`;
          },
          error: function (xhr) {
            console.error(xhr.responseText);
          }
        });
      });
      const nameapi = `http://127.0.0.1:8000/api/coursename/${$('#course_id').val()}`;
      $.ajax({
        url: nameapi,
        method: 'GET',
        headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('token')
        },
        success: function (data) {
          console.log(data);
          $('#course-title').text(data.title);
        },
        error: function (xhr) {
          console.error(xhr.responseText);
        }
      });
    });
  </script>
</body>

</html>