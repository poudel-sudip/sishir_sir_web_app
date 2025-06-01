<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories as WebPage;


class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function aboutPageShow()
    {
        $page = WebPage::where('type','webpage-about')->first();
        if(!$page) {
            $page = WebPage::create([
                'name' => 'About Us',
                'type' => 'webpage-about',
                'status' => 'Active',
                'description' => '',
            ]);            
        }

        return view('admin.settings.pages.about_page_show', compact('page'));
    }

    public function aboutPageEdit()
    {
        $page = WebPage::where('type','webpage-about')->first();
        if(!$page) {
            $page = WebPage::create([
                'name' => 'About Us',
                'type' => 'webpage-about',
                'status' => 'Active',
                'description' => '',
            ]);            
        }

        return view('admin.settings.pages.about_page_edit', compact('page'));
    }

    public function aboutPageUpdate(Request $request)
    {
        $page = WebPage::where('type','webpage-about')->first();
        if(!$page) {
            $page = WebPage::create([
                'name' => 'About Us',
                'type' => 'webpage-about',
                'status' => 'Active',
                'description' => '',
            ]);            
        }

        $request->validate([
            'page_content' => 'required|string',
        ]);

        $page->update([
            'description' => $request->page_content,
        ]);
        
        return redirect('/admin/web-pages/about');
    }

    public function policyPageShow()
    {
        $page = WebPage::where('type','webpage-policy')->first();
        if(!$page) {
            $page = WebPage::create([
                'name' => 'Privacy Policy',
                'type' => 'webpage-policy',
                'status' => 'Active',
                'description' => '',
            ]);            
        }

        return view('admin.settings.pages.policy_page_show', compact('page'));
    }

    public function policyPageEdit()
    {
        $page = WebPage::where('type','webpage-policy')->first();
        if(!$page) {
            $page = WebPage::create([
                'name' => 'Privacy Policy',
                'type' => 'webpage-policy',
                'status' => 'Active',
                'description' => '',
            ]);            
        }

        return view('admin.settings.pages.policy_page_edit', compact('page'));
    }

    public function policyPageUpdate(Request $request)
    {
        $page = WebPage::where('type','webpage-policy')->first();
        if(!$page) {
            $page = WebPage::create([
                'name' => 'Privacy Policy',
                'type' => 'webpage-policy',
                'status' => 'Active',
                'description' => '',
            ]);            
        }

        $request->validate([
            'page_content' => 'required|string',
        ]);

        $page->update([
            'description' => $request->page_content,
        ]);
        
        return redirect('/admin/web-pages/policy');
    }

    public function visionPageShow()
    {
        $page = WebPage::where('type','webpage-vision')->first();
        if(!$page) {
            $page = WebPage::create([
                'name' => 'Vision',
                'type' => 'webpage-vision',
                'status' => 'Active',
                'description' => '',
            ]);            
        }

        return view('admin.settings.pages.vision_page_show', compact('page'));
    }

    public function visionPageEdit()
    {
        $page = WebPage::where('type','webpage-vision')->first();
        if(!$page) {
            $page = WebPage::create([
                'name' => 'Vision',
                'type' => 'webpage-vision',
                'status' => 'Active',
                'description' => '',
            ]);            
        }

        return view('admin.settings.pages.vision_page_edit', compact('page'));

    }

    public function visionPageUpdate(Request $request)
    {
        $page = WebPage::where('type','webpage-vision')->first();
        if(!$page) {
            $page = WebPage::create([
                'name' => 'Vision',
                'type' => 'webpage-vision',
                'status' => 'Active',
                'description' => '',
            ]);            
        }

        $request->validate([
            'page_content' => 'required|string',
        ]);

        $page->update([
            'description' => $request->page_content,
        ]);

        return redirect('/admin/web-pages/vision');
    }

    public function contactPageShow()
    {
        $page = WebPage::where('type','webpage-contact')->first();
        if(!$page) {
            $page = WebPage::create([
                'name' => 'Contact',
                'type' => 'webpage-contact',
                'status' => 'Active',
                'description' => '',
            ]);            
        }

        return view('admin.settings.pages.contact_page_show', compact('page'));
    }

    public function contactPageEdit()
    {
        $page = WebPage::where('type','webpage-contact')->first();
        if(!$page) {
            $page = WebPage::create([
                'name' => 'Contact',
                'type' => 'webpage-contact',
                'status' => 'Active',
                'description' => '',
            ]);            
        }

        return view('admin.settings.pages.contact_page_edit', compact('page'));

    }

    public function contactPageUpdate(Request $request)
    {
        $page = WebPage::where('type','webpage-contact')->first();
        if(!$page) {
            $page = WebPage::create([
                'name' => 'Contact',
                'type' => 'webpage-contact',
                'status' => 'Active',
                'description' => '',
            ]);            
        }

        $request->validate([
            'page_content' => 'required|string',
        ]);

        $page->update([
            'description' => $request->page_content,
        ]);

        return redirect('/admin/web-pages/contact');
    }
}
