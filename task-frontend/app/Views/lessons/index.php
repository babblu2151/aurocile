<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lessons - Course Management</title>
  <link rel="stylesheet" href="<?= base_url('assets/styles.css') ?>">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <h1>Lessons for Course: <span id="course-title" style="color: red"></span></h1>

    <!-- Add button and search form -->
    <div>
      <a href="<?= base_url('courses/' . $courseId . '/lessons/create') ?>"><button class="btn-add">Add
          Lesson</button></a>
      <input type="text" id="search-input" placeholder="Search lessons...">
    </div>

    <table id="lessons-table">
      <thead>
        <tr>
          <th>Title</th>
          <th>Description</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="lessons-list">
      </tbody>
    </table>

    <div id="pagination" class="pagination">
    </div>
  </main>

  <?php include (APPPATH . 'Views/footer.php'); ?>

  <script src="<?= base_url('assets/scripts.js') ?>"></script>
  <script>
    $(document).ready(function () {
      let currentPage = 1;
      const courseId = <?= $courseId ?>;
      const apiUrl = `http://127.0.0.1:8000/api/courses/${courseId}/lessons`;

      function bindSearch() {
        $('#search-input').on('input', function () {
          const searchTerm = $(this).val().toLowerCase();
          $('#lessons-list tr').each(function () {
            const title = $(this).find('td').eq(0).text().toLowerCase();
            const description = $(this).find('td').eq(1).text().toLowerCase();
            $(this).toggle(title.includes(searchTerm) || description.includes(searchTerm));
          });
        });
      }

      fetchLessons(currentPage);

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
              currentPage = data.lessons.current_page;
              fetchLessons(currentPage);
            },
            error: function (xhr) {
              console.error(xhr.responseText);
            }
          });
        }
      });

      $(document).on('click', '.delete', function () {
        const lessonId = $(this).data('id');
        const apiUrl = `http://127.0.0.1:8000/api/lessons/${lessonId}`;
        $.ajax({
          url: apiUrl,
          method: 'DELETE',
          headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('token')
          },
          success: function (data) {
            alert('Lesson deleted successfully');
            fetchLessons(currentPage);
          },
          error: function (xhr) {
            console.error(xhr.responseText);
          }
        });
      });
      function fetchLessons(page = 1) {
        const apiUrl = `http://127.0.0.1:8000/api/courses/${courseId}/lessons?page=${page}`;

        $.ajax({
          url: apiUrl,
          method: 'GET',
          headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('token')
          },
          success: function (data) {
            $('#course-title').text(data.course.title);

            const lessonsList = $('#lessons-list');
            lessonsList.empty();

            if (data.lessons && Array.isArray(data.lessons.data)) {
              data.lessons.data.forEach(lesson => {
                lessonsList.append(`
                        <tr>
                            <td>${lesson.title}</td>
                            <td>${lesson.content}</td>
                            <td>
                                <a href="lessons/edit/${lesson.id}">Edit</a> - 
                                <a href="#" class="delete" data-id="${lesson.id}">Delete</a>
                            </td>
                        </tr>
                    `);
              });

              renderPagination(data.lessons);
            } else {
              console.error('Unexpected response format:', data);
            }
          },
          error: function (xhr) {
            console.error(xhr.responseText);
          }
        });
      }

      function renderPagination(lessonsData) {
        const pagination = $('#pagination');
        pagination.empty();

        if (lessonsData.prev_page_url) {
          pagination.append(`<button class="pagination" data-url="${lessonsData.prev_page_url}">Previous</button>`);
        } else {
          pagination.append('<button class="pagination disabled">Previous</button>');
        }

        for (let i = 1; i <= lessonsData.last_page; i++) {
          const activeClass = (i === lessonsData.current_page) ? 'active' : '';
          pagination.append(`<button class="pagination ${activeClass}" data-url="${apiUrl}?page=${i}">${i}</button>`);
        }

        if (lessonsData.next_page_url) {
          pagination.append(`<button class="pagination" data-url="${lessonsData.next_page_url}">Next</button>`);
        } else {
          pagination.append('<button class="pagination disabled">Next</button>');
        }
      }

      $(document).on('click', '.page-link', function (e) {
        e.preventDefault();
        const page = $(this).data('page');
        fetchLessons(page);
      });

    });
  </script>
</body>

</html>