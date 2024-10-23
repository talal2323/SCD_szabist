<?php

namespace App\Http\Controllers;

use App\Models\Course; // Make sure to import the Course model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Course::all(); // Retrieve all courses
        return view('course.index', compact('data')); // Adjust the view name to 'course.index'
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('course.create'); // Adjust the view name to 'course.create'
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|max:255', // Title field validation
            'credit_hrs' => 'required|integer', // Credit hours field validation
        ]);

        try {
            if ($validate) {
                Course::create($request->all()); // Create a new course
                Session::flash('message', 'Course created successfully!');
                Session::flash('alert-class', 'alert-success');
            } else {
                Session::flash('message', 'Error. Validation failed.');
                Session::flash('alert-class', 'alert-danger');
            }
        } catch (\Exception $e) {
            Log::error('Store operation failed: ' . $e->getMessage());
            Session::flash('message', 'Something went wrong. Please try again later.');
            Session::flash('alert-class', 'alert-danger');
        }
        return redirect(route('course.index')); // Adjust the redirect route
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Course::findOrFail($id); // Find the course by ID
        return view('course.create', compact('data')); // Adjust the view name to 'course.create'
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'title' => 'required|max:255', // Title field validation
            'credit_hrs' => 'required|integer', // Credit hours field validation
        ]);

        $data = Course::findOrFail($request->id);
        if ($data) {
            try {
                $data->update($request->all()); // Update the course
                Session::flash('message', 'Course updated successfully!');
                Session::flash('alert-class', 'alert-success');
            } catch (\Exception $e) {
                Log::error('Update Failed: ' . $e->getMessage());
                Session::flash('message', 'Something went wrong. Please try again later.');
                Session::flash('alert-class', 'alert-danger');
            }
        } else {
            Session::flash('message', 'Invalid course ID');
            Session::flash('alert-class', 'alert-danger');
        }
        return redirect(route('course.index')); // Adjust the redirect route
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Course::findOrFail($id);
        try {
            $data->delete(); // Delete the course
            Session::flash('message', 'Course deleted successfully!');
            Session::flash('alert-class', 'alert-success');
        } catch (\Exception $e) {
            Log::error('Delete operation failed: ' . $e->getMessage());
            Session::flash('message', 'Something went wrong. Please try again later.');
            Session::flash('alert-class', 'alert-danger');
        }
        return redirect(route('course.index')); // Adjust the redirect route
    }
}
