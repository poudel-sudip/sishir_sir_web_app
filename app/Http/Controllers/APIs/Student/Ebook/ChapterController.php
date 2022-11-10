<?php

namespace App\Http\Controllers\APIs\Student\Ebook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Ebook\Ebook;
use App\Models\Ebook\EbookBooking;
use App\Models\Ebook\EbookChapter;
use App\Models\Ebook\ChapterFiles;

class ChapterController extends Controller
{
    protected $user; 

    protected function guard()
    {
        return Auth::guard('api');
    }

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->user=$this->guard()->user();
    }

    public function getChapterList($bookingID)
    {
        $booking = EbookBooking::find($bookingID);
        if(!$booking)
        {
            return response()->json(['error'=>'Booking With Given ID Not Found'], 404);
        }

        $book = $booking->book;
        if(!$book)
        {
            return response()->json(['error'=>'Book Not Found. Please Contact Administrator.'], 404);
        }
        $chapters = $book->chapters->map(function($ch) use($booking) {

            return [
                'id' => $ch->id,
                'chapter_name' => $ch->name,
                'chapter_title' => $ch->title,
                'chapter_slug' => $ch->slug,
                'pdf_file' => $ch->pdf_file ?? '',
                'chapter_file_count' => $ch->chapterfiles->count(),
                'chapter_file_link' => url('api/v1/my/ebooks/'.$booking->id.'/chapters/'.$ch->id),
            ];
        });

        return response()->json([
           'book' => [
               'id' => $book->id,
               'name' => $book->title,
               'slug' => $book->slug,
               'author' => $book->author,
               'thumbnail' => $book->thumbnail,
               'description' => $book->description,
           ],
           'chapters' => $chapters, 
        ], 200);
    }

    public function getChapter($bookingID, $chapterID)
    {
        $booking = EbookBooking::find($bookingID);
        if(!$booking)
        {
            return response()->json(['error'=>'Booking With Given ID Not Found'], 404);
        }

        $book = $booking->book;
        if(!$book)
        {
            return response()->json(['error'=>'Book Not Found. Please Contact Administrator.'], 404);
        }

        $chapter = EbookChapter::find($chapterID);
        if(!$chapter)
        {
            return response()->json(['error'=>'Chapter Not Found'], 404);
        }

        $files= $chapter->chapterfiles;

        return response()->json([
            'book' => [
                'id' => $book->id,
                'name' => $book->title,
                'slug' => $book->slug,
                'author' => $book->author,
            ],
            'chapter' => [
                'id' => $chapter->id,
                'name' => $chapter->name,
                'title' => $chapter->title,
                'slug' => $chapter->slug,
                'pdf_file' => $chapter->pdf_file ?? '',
            ],
            'chapter_files' => $files,
         ], 200);
    }

    public function getFile($bookingID, $chapterID, $fileID)
    {
        $booking = EbookBooking::find($bookingID);
        if(!$booking)
        {
            return response()->json(['error'=>'Booking With Given ID Not Found'], 404);
        }

        $book = $booking->book;
        if(!$book)
        {
            return response()->json(['error'=>'Book Not Found. Please Contact Administrator.'], 404);
        }

        $chapter = EbookChapter::find($chapterID);
        if(!$chapter)
        {
            return response()->json(['error'=>'Chapter Not Found'], 404);
        }

        $file = ChapterFiles::find($fileID);
        if(!$file)
        {
            return response()->json(['error'=>'Chapter File Not Found'], 404);
        }

        return response()->json([
            'book' => [
                'id' => $book->id,
                'name' => $book->title,
                'slug' => $book->slug,
                'author' => $book->author,
            ],
            'chapter' => [
                'id' => $chapter->id,
                'name' => $chapter->name,
                'title' => $chapter->title,
                'slug' => $chapter->slug,
                'pdf_file' => $chapter->pdf_file ?? '',
            ],
            'chapter_file' => $file,
        ], 200);
    }
}
