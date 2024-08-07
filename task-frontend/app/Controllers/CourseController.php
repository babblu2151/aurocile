<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class CourseController extends Controller
{
  public function index()
  {
    return view('courses/index');
  }

  public function create()
  {
    return view('courses/create');
  }

  public function edit($id)
  {
    return view('courses/edit', ['id' => $id]);
  }

  public function lessons($courseId)
  {
    return view('lessons/index', ['courseId' => $courseId]);
  }

  public function createLesson($courseId)
  {
    return view('lessons/create', ['courseId' => $courseId]);
  }

  public function editLesson($courseId, $lessonId)
  {
    return view('lessons/edit', ['courseId' => $courseId, 'lessonId' => $lessonId]);
  }

}
