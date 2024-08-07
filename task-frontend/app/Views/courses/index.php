<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Courses - Course Management</title>
  <link rel="stylesheet" href="<?= base_url('assets/styles.css') ?>">
  <style>
    .pagination button {
      margin: 0 5px;
      padding: 5px 10px;
      border: 1px solid #ccc;
      background-color: gray;
      cursor: pointer;
    }

    .pagination button.active {
      background-color: #007bff;
      color: white;
      border: 1px solid #007bff;
    }

    .pagination button:disabled {
      cursor: not-allowed;
      opacity: 0.5;
    }
  </style>
</head>

<body>
  <?php include (APPPATH . 'Views/header.php'); ?>

  <main>
    <section>
      <h2>Courses</h2>

      <a href="<?= base_url('courses/create') ?>"><button class="btn-add">Add Course</button></a>
      <input type="text" id="search-input" placeholder="Search courses...">
      <table id="courses-table">
        <thead>
          <tr>
            <th>Title</th>
            <th>Duration</th>
            <th>Description</th>
            <th>Lessons</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="courses-list">
        </tbody>
      </table>

      <div id="pagination" class="pagination">
      </div>
    </section>
  </main>

  <?php include (APPPATH . 'Views/footer.php'); ?>

  <script src="<?= base_url('assets/scripts.js') ?>"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
      const token = localStorage.getItem('token');
      // show add button only if token is set
      if (token) {
        $('.btn-add').show();
      } else {
        $('.btn-add').hide();
        alert('Please login first to see courses');
        window.location.href = '/login';
      }
      let currentPage = 1;
      const apiUrl = 'http://127.0.0.1:8000/api/courses';

      function fetchCourses(page = 1) {
        $.ajax({
          url: `${apiUrl}?page=${page}`,
          method: 'GET',
          headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('token')
          },
          success: function (data) {
            console.log(data);
            const coursesList = $('#courses-list');
            const pagination = $('#pagination');
            coursesList.empty();
            pagination.empty();

            if (Array.isArray(data.data)) {
              data.data.forEach(course => {
                coursesList.append(`
                  <tr>
                    <td>${course.title}</td>
                    <td>${course.duration}</td>
                    <td>${course.description}</td>
                    <td><a href="courses/${course.id}/lessons/">View</a></td>
                    <td>
                      <a href="courses/edit/${course.id}">Edit</a> - 
                      <a href="#" class="delete" data-id="${course.id}">Delete</a>
                    </td>
                  </tr>
                `);
              });
              if (data.prev_page_url) {
                pagination.append(`<button class="pagination" data-url="${data.prev_page_url}">Previous</button>`);
              }
              for (let i = 1; i <= data.last_page; i++) {
                const activeClass = (i === data.current_page) ? 'active' : '';
                pagination.append(`<button class="pagination ${activeClass}" data-url="${apiUrl}?page=${i}">${i}</button>`);
              }
              if (data.next_page_url) {
                pagination.append(`<button class="pagination" data-url="${data.next_page_url}">Next</button>`);
              }
            } else {
              console.error('Unexpected response format:', data);
            }
          },
          error: function (xhr) {
            console.error(xhr.responseText);
          }
        });
      }

      function filterCourses() {
        const searchTerm = $('#search-input').val().toLowerCase();
        $('#courses-list tr').each(function () {
          const title = $(this).find('td').eq(0).text().toLowerCase();
          const description = $(this).find('td').eq(2).text().toLowerCase();
          if (title.includes(searchTerm) || description.includes(searchTerm)) {
            $(this).show();
          } else {
            $(this).hide();
          }
        });
      }

      fetchCourses(currentPage);
      $('#search-input').on('keyup', filterCourses);

      $(document).on('click', '.pagination', function () {
        const url = $(this).data('url');
        if (url) {
          $.ajax({
            url: url,
            method: 'GET',
            headers: {
              'Authorization': 'Bearer ' + localStorage.getItem('token')
            },
            success: function (data) {
              currentPage = data.current_page;
              fetchCourses(currentPage);
            },
            error: function (xhr) {
              console.error(xhr.responseText);
            }
          });
        }
      });

      $(document).on('click', '.delete', function () {
        const courseId = $(this).data('id');
        $.ajax({
          url: `http://127.0.0.1:8000/api/courses/${courseId}`,
          method: 'DELETE',
          headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('token')
          },
          success: function (data) {
            alert('Course deleted successfully');
            fetchCourses(currentPage);
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
