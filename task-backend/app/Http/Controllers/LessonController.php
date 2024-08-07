<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
    public function index($courseId)
    {
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'course_id' => 'required|exists:courses,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 400);
        }

        $course = Course::find($request->input('course_id'));

        if (!$course) {
            return response()->json([
                'success' => false,
                'message' => 'Course not found'
            ], 404);
        }

        $lesson = new Lesson([
            'title' => $request->input('title'),
            'content' => $request->input('content')
        ]);

        $course->lessons()->save($lesson);

        return response()->json([
            'success' => true,
            'message' => 'Lesson created successfully',
            'lesson' => $lesson
        ], 201);
    }

    public function show(Course $course, Lesson $lesson)
    {
        return $lesson;
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'course_id' => 'required|exists:courses,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 400);
        }

        // Find the lesson
        $lesson = Lesson::find($id);

        if (!$lesson) {
            return response()->json([
                'success' => false,
                'message' => 'Lesson not found'
            ], 404);
        }

        // Find the course
        $course = Course::find($request->input('course_id'));

        if (!$course) {
            return response()->json([
                'success' => false,
                'message' => 'Course not found'
            ], 404);
        }

        // Update lesson details
        $lesson->title = $request->input('title');
        $lesson->content = $request->input('content');
        $lesson->course_id = $course->id;

        $lesson->save();

        return response()->json([
            'success' => true,
            'message' => 'Lesson updated successfully',
            'lesson' => $lesson
        ], 200);
    }


    public function destroy(Course $course, Lesson $lesson)
    {
        $lesson->delete();

        return response()->noContent();
    }
}
