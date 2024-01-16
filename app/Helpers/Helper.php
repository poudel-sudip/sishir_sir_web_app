<?php

namespace App\Helpers;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\PostViewCounter;

use App\Models\Blog;
use App\Models\Books\Book;
use App\Models\Exams\Question;
use App\Models\Library\LibraryMaterial;
use App\Models\Menu\MenuSubGroup;
use App\Models\Menu\MenuItemCategory;
use App\Models\Menu\MenuItem;
use App\Models\Menu\MenuSubItem;


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
        return now();
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

    public static function websiteCounter()
    {
        $lib_pdf = LibraryMaterial::where('type','=','file')->count();
        $m_sg_pdf = MenuSubGroup::where('type','=','file')->count();
        $m_cat_pdf = MenuItemCategory::where('type','=','file')->count();
        $m_itm_pdf = MenuItem::where('type','=','file')->count();
        $m_sitm_pdf = MenuSubItem::where('type','=','file')->count();
        
        $data['pdf'] = $lib_pdf + $m_sg_pdf + $m_cat_pdf + $m_itm_pdf + $m_sitm_pdf;        
        $data['blog'] = Blog::count();
        $data['book'] = Book::count();
        $data['mcq'] = Question::count();
        $data['download'] = PostViewCounter::getTotalDownloadCount();
        $data['website'] = PostViewCounter::getTotalViewCount();

        return (object)($data);

    }

    public static function mostViewPosts()
    {
        $posts = PostViewCounter::where('title','!=',null)->orderByDesc('view_count')->take(4)->get(['title','url','view_count as count']);
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