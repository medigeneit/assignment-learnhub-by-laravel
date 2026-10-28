<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('id')->get();

        // null means "All"
        $selectedCategoryId = $request->query('category');

        $courses = Course::orderBy('id')->get();

        if ($selectedCategoryId) {
            $courses->where('category_id', $selectedCategoryId);
        }

        return view('courses.index', [
            'categories' => $categories,
            'courses' => $courses,
            'selectedCategoryId' => $selectedCategoryId,
        ]);
    }
}
