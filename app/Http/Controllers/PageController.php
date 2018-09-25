<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;

class PageController extends Controller
{
    public function index(){
		return view("home",[
			"pages" => Page::PAGES
		])->with("p","ROOT");
	}

	public function page($page){
		return view("page.".$page.".index",Page::PAGES[$page])->with("page",$page);
	}

	public function subdirectory($page,$directory){
		return view("page.".$page.".".$directory,Page::PAGES[$page])->with("page",$page);
	}
}
