<?php

namespace App\Helpers;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\PostViewCounter;
use App\Models\DailyVisitCounter;
use DOMDocument;

use App\Models\Blog;
use App\Models\Books\Book;
use App\Models\Exams\DailyMCQQuestion as DailyQuestion;
use App\Models\Exams\Question;
use App\Models\Library\LibraryMaterial;
use App\Models\Menu\MenuSubGroup;
use App\Models\Menu\MenuItemCategory;
use App\Models\Menu\MenuItem;
use App\Models\Menu\MenuSubItem;
use App\Models\Ebook\EbookChapter as PdfBankContent;
use App\Models\Ebook\Ebook as PdfBank;
use App\Models\ExamHall\ExamHallCategories as PremiumExam;
use App\Models\OpenExams\OpenExam as FreeExam;
use App\Models\VaccancyPost;
use App\Models\Categories;

class Helper
{

    public static function addViewCount($title = '', $url = '')
    {        
        $data['page']            = '';        
        if($title && $url)
        {
            $postViewCounter = PostViewCounter::firstOrCreate([
                // 'title' => $title,
                'url' => $url,
            ]);

            $postViewCounter->increment('view_count');
            
            $dailyVisitCounter = DailyVisitCounter::firstOrCreate([
                'visit_date' => date('Y-m-d'),
            ]);

            $dailyVisitCounter->increment('view_count');


            $data['page'] = $title;

        }
        
        return (object)$data;            
        
    }

    public static function downloadCount($title = '', $url = '')
    {        
        $data['page']            = '';
        $data['page_download_count'] = '0';
        
        if($title && $url)
        {
            $postViewCounter = PostViewCounter::firstOrCreate([
                'url' => $url,
            ]);

            $currentDownloadCount = $postViewCounter->download_count;
            
            $data['page']            = $title;
            $data['page_download_count'] = $currentDownloadCount;

        }
        
        return (object)$data;       
        
    }

    public static function shareCount($title = '', $url = '')
    {        
        $data['page']            = '';
        $data['page_share_count'] = '0';
        
        if($title && $url)
        {
            $postViewCounter = PostViewCounter::firstOrCreate([
                'url' => $url,
            ]);

            $currentShareCount = $postViewCounter->share_count;
            
            $data['page']            = $title;
            $data['page_share_count'] = $currentShareCount;

        }
        
        return (object)$data;       
        
    }

    public static function pageCounterCounts($title = '', $url = '',$type='')
    {        
        $data['page']            = '';
        $data['page_view_count'] = '1';
        $data['page_share_count'] = '0';
        $data['page_download_count'] = '0';
        
        if($title && $url)
        {
            $postViewCounter = PostViewCounter::firstOrCreate([
                'url' => $url,
            ]);

            $dailyVisitCounter = DailyVisitCounter::firstOrCreate([
                'visit_date' => date('Y-m-d'),
            ]);

            if($type == 'article' && !$postViewCounter->title)
            {
              $postViewCounter->update(['title'=>$title]);  
            }
            
            $data['page']            = $title;
            $data['page_view_count'] = $postViewCounter->view_count;
            $data['page_share_count'] = $postViewCounter->share_count;
            $data['page_download_count'] = $postViewCounter->download_count;
        }
        
        return (object)$data;       
        
    }

    public static function lastUpdated()
    {
        return Carbon::now();
    }

    public static function totalWebVisits()
    {
        return PostViewCounter::getTotalViewCount() ?? 0;
    }

    public static function excerpt($content, $max_length = 500, $cut_off = '...', $keep_word = true)
    {
        $content = strip_tags(str_replace('<', '  <', $content));

        if(strlen($content) <= $max_length) 
        {
            return $content;
        }

        if(strlen($content) > $max_length) 
        {
            if($keep_word) {
                $content = substr($content, 0, $max_length + 1);

                if($last_space = strrpos($content, ' ')) {
                    $content = substr($content, 0, $last_space);
                    $content = rtrim($content);
                    $content .=  $cut_off;
                }
            } else {
                $content = substr($content, 0, $max_length);
                $content = rtrim($content);
                $content .=  $cut_off;
            }
        }

        return $content;
    }

    public static function prepareHtmlContent(string $html): string
    {
        if (trim($html) === '') {
            return '';
        }

        libxml_use_internal_errors(true);

        $dom = new DOMDocument();
        $dom->loadHTML(
            mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'),
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

        // Remove width attributes and width-related inline styles
        foreach ($dom->getElementsByTagName('*') as $element) {

            // Remove width=""
            $element->removeAttribute('width');

            // Remove width/min-width/max-width from style=""
            if ($element->hasAttribute('style')) {

                $styles = explode(';', $element->getAttribute('style'));

                $styles = array_filter($styles, function ($style) {
                    return !preg_match(
                        '/^\s*(width|min-width|max-width)\s*:/i',
                        trim($style)
                    );
                });

                if ($styles) {
                    $element->setAttribute('style', implode('; ', array_map('trim', $styles)));
                } else {
                    $element->removeAttribute('style');
                }
            }
        }

        // Wrap every table in a responsive div
        $tables = [];

        foreach ($dom->getElementsByTagName('table') as $table) {
            $tables[] = $table; // Copy first because NodeList is live
        }

        foreach ($tables as $table) {

            $wrapper = $dom->createElement('div');
            $wrapper->setAttribute(
                'class',
                'table-responsive'
            );

            $wrapper->setAttribute(
                'style',
                'overflow-x:auto;display:block;max-width:100%;'
            );

            $parent = $table->parentNode;
            $parent->replaceChild($wrapper, $table);
            $wrapper->appendChild($table);
        }

        libxml_clear_errors();

        return $dom->saveHTML();
    }

    public static function websiteCounter()
    {
        $lib_pdf = LibraryMaterial::where('type','=','file')->count();
        $m_sg_pdf = MenuSubGroup::where('type','=','file')->count();
        $m_cat_pdf = MenuItemCategory::where('type','=','file')->count();
        $m_itm_pdf = MenuItem::where('type','=','file')->count();
        $m_sitm_pdf = MenuSubItem::where('type','=','file')->count();
        $pdf_bank_pdf = PdfBank::where('type','=','single')->count();
        $pdf_bank_contentpdf = PdfBankContent::count();
        $vaccancy_pdf = VaccancyPost::where('pdf_file','!=','')->count();
        
        $data['pdf'] = $lib_pdf + $m_sg_pdf + $m_cat_pdf + $m_itm_pdf + $m_sitm_pdf + $pdf_bank_pdf + $pdf_bank_contentpdf + $vaccancy_pdf;        
        $data['pdf_bank'] = PdfBank::count();
        $data['blog'] = Blog::count();
        $data['book'] = Categories::where('type','=','book_category')->count();
        $data['book_edition'] = Book::count();
        $data['exam'] = PremiumExam::count() + FreeExam::count();
        $data['mcq'] = Question::count() + DailyQuestion::count();
        $data['download'] = PostViewCounter::getTotalDownloadCount();
        $data['vaccancy'] = VaccancyPost::count();
        $data['website'] = PostViewCounter::getTotalViewCount();
        $data['last_updated'] = Carbon::now();

        return (object)($data);

    }

    public static function mostViewPosts()
    {
        $posts = PostViewCounter::where('title','!=',null)->orderByDesc('view_count')->take(7)->get(['title','url','view_count as count']);
        return $posts;
    }

    public static function mostSharePosts()
    {
        $posts = PostViewCounter::where('title','!=',null)->orderByDesc('share_count')->take(4)->get(['title','url','share_count as count']);
        return $posts;
    }

    public static function mostDownloadPosts()
    {
        $posts = PostViewCounter::where('title','!=',null)->orderByDesc('download_count')->take(4)->get(['title','url','download_count as count']);
        return $posts;
    }
    
}