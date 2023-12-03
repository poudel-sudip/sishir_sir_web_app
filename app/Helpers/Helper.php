<?php

namespace App\Helpers;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use App\Models\PostViewCounter;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Helper
{

    public static function viewCount($title = '', $url = '')
    {        
        $data['page']            = '';
        // $data['page_view_count'] = '0';
        $data['web_view_count']  = '0';
        
        if($title && $url)
        {
            $postViewCounter = PostViewCounter::firstOrCreate([
                // 'title' => $title,
                'url' => $url,
            ]);

            $postViewCounter->increment('view_count');
            // $currentViewCount = $postViewCounter->view_count;
            $totalViewCount = PostViewCounter::getTotalViewCount();
            
            $data['page']            = $title;
            // $data['page_view_count'] = $currentViewCount;
            $data['web_view_count']  = $totalViewCount;

        }
        
        return (object)$data;       
        
        
        
        // $agent                   =  request()->header('User-Agent');
        // $data['page']            = '';
        // $data['page_view_count'] = '0';
        // $data['web_view_count']  = '0';

        // if($page)
        // {
        //     $page = ucfirst($page);
        //     PostViewCounter::create([
        //         'title'      => $page,
        //         'user_agent' => $agent,
        //     ]);

        //     $data['page']            = $page;
        //     // $data['page_view_count'] = PostViewCounter::where('title','=',$page)->count();
        //     // $data['web_view_count']  = PostViewCounter::count();
        //     $data['page_view_count'] = DB::table('post_view_counters')->where('title','=',$page)->count();
        //     $data['web_view_count']  = DB::table('post_view_counters')->count();
        // }
                
        
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

    public static function pageCounterCounts($title = '', $url = '')
    {        
        $data['page']            = '';
        $data['page_view_count'] = '0';
        $data['page_share_count'] = '0';
        $data['page_download_count'] = '0';
        
        if($title && $url)
        {
            $postViewCounter = PostViewCounter::firstOrCreate([
                'url' => $url,
            ]);
            
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
}