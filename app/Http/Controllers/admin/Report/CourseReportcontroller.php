<?php

namespace App\Http\Controllers\admin\Report;

use App\Exports\CategoryCoursesExport;
use App\Exports\CourseBatchesExport;
use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Course;
use App\Models\Reports\ReportCourseBatches;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CourseReportcontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $courses=Course::all();
        return view('admin.reports.course.index',compact('courses'));
    }

    public function courseReport()
    {
        $categories=Categories::all();
        return view('admin.reports.course.courses',compact('categories'));
    }

    public function courseBatchReport(Course $course)
    {
        $reports=ReportCourseBatches::all()
            ->where('course_id','=',$course->id)
            ->sortBy('created_at');
        return view('admin.reports.course.courseBatches',compact('reports','course'));
    }

    public function exportCategoryCourses(): BinaryFileResponse
    {
        return Excel::download(new CategoryCoursesExport, 'AllCourses.xlsx');
    }

    public function exportCourseBatches(Course $course): BinaryFileResponse
    {
        return Excel::download(new CourseBatchesExport($course), 'CourseBatches.xlsx');
    }
}
