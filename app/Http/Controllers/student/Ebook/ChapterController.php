<?php

namespace App\Http\Controllers\Student\Ebook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ebook\EbookBooking;
use App\Models\Ebook\EbookChapter;
use App\Models\Ebook\ChapterFiles;

class ChapterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(EbookBooking $booking)
    {
        $book = $booking->book;
        $chapters = $book->chapters;
        return view('student.ebook.chapter.index',compact('booking','book','chapters'));
    }

    public function show(EbookBooking $booking, EbookChapter $chapter, ChapterFiles $chapterfiles)
    {
        $book = $booking->book;
        $chapters = $book->chapters;
        $files= $chapter->chapterfiles;
        return view('student.ebook.chapter.show',compact('booking','book','chapters','chapter','files'));
    }
}
