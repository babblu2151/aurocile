<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Lesson</title>
  <link rel="stylesheet" href="<?= base_url('assets/styles.css') ?>">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <?php include (APPPATH . 'Views/header.php'); ?>

  <main>
    <h1>Create Lesson for Course: <span id="course-title" style="color:red"></span></h1>
    <form id="create-lesson-form">
      <label for="title">Title:</label>
      <input type="text" id="title" name="title" required><br>
      <label for="content">Content:</label>
      <textarea id="content" name="content" required></textarea><br>
      <input type="hidden" id="course_id" name="course_id" value="<?= $courseId ?>">
      <button type="submit">Submit</button>
    </form>
  </main>

  <?php include (APPPATH . 'Views/footer.php'); ?>

  <script src="<?= base_url('assets/scripts.js') ?>"></script>
  <script>
    $(document).ready(function () {
      $('#create-lesson-form').on('submit', function (event) {
        event.preventDefault();

        const apiUrl = `http://127.0.0.1:8000/api/lessons`;
        const formData = {
          title: $('#title').val(),
          content: $('#content').val(),
          course_id: $('#course_id').val(),
        };
        console.log(formData);
        $.ajax({
          url: apiUrl,
          method: 'POST',
          headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('token'),
            'Content-Type': 'application/json'
          },
          data: JSON.stringify(formData),
          success: function (data) {
            alert('Lesson created successfully');
            window.location.href = `/courses/${formData.course_id}/lessons`;
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