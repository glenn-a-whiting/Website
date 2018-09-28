<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;

class PageController extends Controller
{
	static private $ALIASES = [
		"game" => "Survival_Game"
	];

	static private function alias($a){
		if(in_array($a,array_keys(self::$ALIASES)))return self::$ALIASES[$a];
		else return $a;
	}

    public function index(){
		return view("home",[
			"pages" => Page::PAGES
		])->with("page","ROOT");
	}

	public function page($page){
		$alias = self::alias($page);
		return view("page.".$alias.".index",Page::PAGES[$alias])->with("page",$alias);
	}

	public function subdirectory($page,$directory){
		return view("page.".$page.".".$directory,Page::PAGES[$page])->with("page",$page);
	}
}
