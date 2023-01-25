<?php

namespace App\Helpers;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use App\Models\PostViewCounter;
use App\Models\User;

class Helper
{

    public static function viewCount($page = '')
    {
        $agent                   =  request()->header('User-Agent');
        $data['page']            = '';
        $data['page_view_count'] = '0';
        $data['web_view_count']  = '0';

        if($page)
        {
            $page = ucfirst($page);
            PostViewCounter::create([
                'title'      => $page,
                'user_agent' => $agent,
            ]);

            $data['page']            = $page;
            $data['page_view_count'] = PostViewCounter::where('title','=',$page)->count();
            $data['web_view_count']  = PostViewCounter::count();
        }
                
        return (object)$data;
    }

    public static function lastUpdated()
    {
        return now();
    }
}