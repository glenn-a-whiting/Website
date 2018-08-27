<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;

class PageController extends Controller
{
    public function index(){
		return view("home",[
			"pages" => Page::PAGES
		]);
	}

	public function page($lang){
		$pages = Page::PAGES[$lang];
		return view("page",[
			"heading" => $lang,
			"pages" => $pages
		]);
	}

	public function specific($lang,$page){
		return view("page.".$lang.".".$page.".index",Page::PAGES[$lang][$page])->with("page",$page);
	}

	public function subdirectory($lang,$page,$directory){
		return view("page.".$lang.".".$page.".".$directory,Page::PAGES[$lang][$page])->with("page",$page);
	}
}
