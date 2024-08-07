<?php
namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;
        $page = $request->input('page', 1);
        $courses = Course::paginate($perPage);

        return response()->json($courses);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'instructor' => 'required',
            'duration' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 400);
        }

        $course = Course::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Course created successfully',
            'course' => $course
        ], 201);
    }


    public function show(Course $course)
    {
        return $course;
    }

    public function update(Request $request, Course $course)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'instructor' => 'required',
            'duration' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 400);
        }

        $course->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Course updated successfully',
            'course' => $course
        ], 200);
    }


    public function destroy(Course $course)
    {
        $course->delete();
        return response()->noContent();
    }

    public function lessons($courseId)
    {
        $course = Course::with('lessons')->findOrFail($courseId);
        $perPage = 10;
        $page = request()->query('page', 1);
        $lessons = $course->lessons()->paginate($perPage, ['*'], 'page', $page);
        return response()->json([
            'course' => [
                'id' => $course->id,
                'title' => $course->title
            ],
            'lessons' => $lessons
        ]);
    }

    public function getCourseName($courseId)
    {
        return Course::findOrFail($courseId);
    }
}
