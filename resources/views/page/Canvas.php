<?php
	class Canvas{
		private static $instances = [];

		private $image;
		private $url;

		public $width;
		public $height;
		public $type;

		private $palette;		// array(Color): allocated colors;
		private $colors;		// array(int,4): rgba representation of palette, with corresponding indexes;

		private $strokeColor; 	// int: palette index
		private $fillColor; 	// int: palette index

		private $strokeWeight = 1;
		private $strokeStyle;

		private $fonts;

		public $font = 4;
		private $fontDirection = "horizontal";	// string: ("vertical" | "horizontal")
		private $fontAlign = "BOTTOM RIGHT"; // Where text is rendered relative to the coordinates.

		public function __construct($url,$width=null,$height=null,$type=null){
			$this->url = $url;

			if($this->url === null){
				if($width === null || $height === null || $type === null){
					throw new Exception("If first arg is null, remaining args must be non-null");
				}
				$this->width = $width;
				$this->height = $height;
				$this->type = $type;
				$this->image = imagecreate($this->width,$this->height);
			}
			else{
				$exp = explode(".",$this->url);
				$this->type = $exp[count($exp)-1];

				switch($this->type){
					case "png":
						$this->image = imagecreatefrompng($this->url);
						break;
					case "jpeg":
					case "jpg":
						$this->image = imagecreatefromjpeg($this->url);
						break;
					case "bmp":
						$this->image = imagecreatefrombmp($this->url);
						break;
					case "gif":
						$this->image = imagecreatefromgif($this->url);
						break;
					case "wbmp":
						$this->image = imagecreatefromwbmp($this->url);
						break;
					case "webp":
						$this->image = imagecreatefromwebp($this->url);
						break;
					default:
						throw new Exception("Canvas instance was not constructed with a valid filetype. Type given: '".$this->type."'; Valid types: png, jpeg, gif, wbmp, webp");
						break;
				}

				$this->width = imagesx($this->image);
				$this->height = imagesy($this->image);
			}

			$this->palette = []; //Array of color objects.
			$this->colors = []; //2D array representing colors, with indexes matching palette.

			$this->setStrokeColor([0,0,0]);
			$this->setFillColor([0,0,0]);

			$this->fonts = [];

			$self->instances[] = $this;
		}

		// Main rendering function.
		// Renders canvas with appropriate format, and deallocates canvas memory.
		public function draw(){
			switch($this->type){
				case "png":
					header("Content-type: image/png");
					imagepng($this->image);
					break;
				case "jpeg":
				case "jpg":
					header("Content-type: image/jpeg");
					imagejpeg($this->image);
					break;
				case "bmp":
					header("Content-type: image/bmp");
					imagebmp($this->image);
					break;
				case "gif":
					header("Content-type: image/gif");
					imagegif($this->image);
					break;
				case "wbmp":
					header("Content-type: image/wbmp");
					imagewbmp($this->image);
					break;
				case "webp":
					header("Content-type: image/webp");
					imagewebp($this->image);
					break;
			}

			// clean up memory
			foreach($self->instances as $instance){
				$instance->destroy();
			}
		}

		// Used by draw() to clean up memory after rendering canvas.
		private function destroy(){
			foreach($this->palette as $p){
				imagecolordeallocate($this->image,$p);
			}
			imagedestroy($this->image);
		}

		// Get index of this->palette with corresponding RGB.
		// Creates new palette and returns its index if no corresponding RGB exists.
		private function getPaletteIndex($color/*Array*/){
			for($i = 0; $i < count($this->colors); $i++){
				if($this->colors[$i] == $color){
					return $i;
				}
			}

			$this->palette[] = imagecolorallocate($this->image,$color[0],$color[1],$color[2]);
			$this->colors[] = $color;

			return count($this->palette)-1;
		}

		/* Canvas settings */

		// Set color of shape edges
		public function setStrokeColor($color/*Array*/){
			$this->strokeColor = $this->getPaletteIndex($color);
		}

		// alias of setStrokeColor
		public function stroke($color){
			$this->setStrokeColor($color);
		}

		// set fill color for shapes
		public function setFillColor($color/*Array*/){
			$this->fillColor = $this->getPaletteIndex($color);
		}

		// alias of setFillColor
		public function fill($color){
			$this->setFillColor($color);
		}

		// set text direction
		public function setTextDirection($dir){
			if($dir == "vertical" || $dir == "horizontal"){
				$this->direction = $dir;
				return true;
			}
			else{
				return false;
			}
		}

		// alias of setTextDirection
		public function textDirection($dir){
			$this->setTextDirection($dir);
		}

		// set font of rendered text
		public function setTextFont($font){
			$this->font = $font;
		}

		// alias of setTextFont
		public function textFont($font){
			$this->setTextFont($font);
		}

		// stroke thickness for lines and edges
		public function setStrokeWeight($w){
			imagesetthickness($this->image,$w);
		}

		// alias of setStrokeWeight
		public function strokeWeight($w){
			$this->setStrokeWeight($w);
		}

		// change where text is rendered relative to the x,y given.
		public function setTextAlign($s){
			$valid = array("TOP LEFT","TOP CENTER","TOP RIGHT","CENTER LEFT","CENTER CENTER","CENTER RIGHT","BOTTOM LEFT","BOTTOM CENTER","BOTTOM RIGHT");
			if(in_array($s,$valid)){
				$this->fontAlign = $s;
			}
		}

		// alias of setTextAlign
		public function textAlign($s){
			$this->setTextAlign($s);
		}

		public function getFontHeight(){
			return imagefontheight($this->font);
		}

		public function getFontWidth(){
			return imagefontwidth($this->font);
		}

		/* Drawing Methods */

		// Make entire canvas single color
		public function background($color){
			$this->setFillColor($color);
			$this->drawRectangle(0,0,$this->width,$this->height,true,true);
		}

		// Flood-fill out from given position
		public function floodFill($x,$y){
			imagefill($this->image,$x,$y,$this->palette[$this->fillColor]);
		}

		// Draw another Canvas or section of another canvas over this Canvas
		public function overlay($src, $dest_x, $dest_y, $src_x=null, $src_y=null, $src_w=null, $src_h=null, $amount=100){
			$x = ($src_x === null) ? 0 : $src_x;
			$y = ($src_y === null) ? 0 : $src_y;
			$w = ($src_w === null) ? $src->width : $src_w;
			$h = ($src_h === null) ? $src->height : $src_h;
			imagecopymerge($this->image, $src->image, $dest_x, $dest_y, $x, $y, $w, $h, $amount);
		}

		// Draw line
		public function drawLine($x1,$y1,$x2,$y2){
			imageline($this->image,$x1,$y1,$x2,$y2,$this->palette[$this->strokeColor]);
		}

		// Draw dashed-line
		public function drawDashedLine($x1,$y1,$x2,$y2){
			imagedashedline($this->image,$x1,$y1,$x2,$y2,$this->palette[$this->strokeColor]);
		}

		// Draw open or closed polygon
		public function drawPolygon($points,$closed=false,$fill=false,$onlyFill=false){
			if((count($points) % 2 != 0) || (count($points) < 6)) return false;
			if(!$closed){
				imageopenpolygon($this->image,$points,count($points)/2,$this->$palette[$this->strokeColor]);
			}
			else{
				if($fill){
					imagefilledpolygon($this->image,$points,count($points)/2,$this->palette[$this->fillColor]);
				}
				imagepolygon($this->image,$points,count($points)/2,$this->palette[$onlyFill ? $this->fillColor : $this->strokeColor]);
			}
		}

		// Draw rectangle
		public function drawRectangle($x1,$y1,$x2,$y2,$fill=false,$onlyFill=false){
			if($fill) imagefilledrectangle($this->image,$x1,$y1,$x2,$y2,$this->palette[$this->fillColor]);
			imagerectangle($this->image,$x1,$y1,$x2,$y2,$this->palette[$onlyFill ? $this->fillColor : $this->strokeColor]);
		}

		// Draw ellipse
		public function drawEllipse($x,$y,$w,$h,$fill=false,$onlyFill=false){
			if($fill) imagefilledellipse($this->image,$x,$y,$w,$h,$this->palette[$this->fillColor]);
			imageellipse($this->image,$x,$y,$w,$h,$this->palette[$onlyFill ? $this->fillColor : $this->strokeColor]);
		}

		// alias to drawEllipse, except only one radius parameter is required
		public function drawCircle($x,$y,$r,$fill=false,$onlyFill=false){
			$this->ellipse($x,$y,$r,$r,$fill,$onlyFill);
		}

		// Draw a single pixel with stroke color
		public function drawPixel($x,$y){
			imagesetpixel($this->image,$x,$y,$this->palette[$this->strokeColor]);
		}

		// Draw a circle arc
		public function drawArc($x, $y, $r1, $r2, $from, $to, $fill=false,$onlyFill=false){
			if($fill) imagefilledarc($this->image, $x, $y, $r1, $r2, $from, $to, $this->palette[$this->fillColor]);
			imagearc($this->image, $x, $y, $r1, $r2, $from, $to, $this->palette[$onlyFill ? $this->fillColor : $this->strokeColor]);
		}

		// Render text at position, wrapping text onto newlines when text exceeds width in pixels.
		public function drawWrappedText($string,$x,$y,$width,$lineHeight=null) {
			$lineHeight = $lineHeight == null ? (imagefontheight($this->font)*1) : $lineHeight;
			$w = $width / imagefontwidth($this->font); // width in characters
			$lines = explode("\r\n",wordwrap($string, $w, "\r\n"));
			$height = count($lines) * ($lineHeight);
			for($line = 0; $line < count($lines); $line++){
				$new_y;
				switch(explode(" ",$this->fontAlign)[0]) {
					case "TOP":
						$new_y = $y + ($height - ($line * $lineHeight));
						break;
					case "CENTER":
						$new_y = $y + ($height/2 - ($line * $lineHeight));
						break;
					case "BOTTOM":
						$new_y = $y + ($line * $lineHeight);
						break;
				}
				$this->drawText($lines[$line],$x,$new_y);
			}
			return count($lines);
		}

		// Render text at position
		public function drawText($string,$x,$y){
			$nx;
			$ny;
			$sl = strlen($string);
			switch($this->fontAlign){
				case "TOP LEFT":
					$nx = $x - imagefontwidth($this->font)*$sl;
					$ny = $y - imagefontheight($this->font);
					break;
				case "TOP CENTER":
					$nx = $x - imagefontwidth($this->font)*$sl/2;
					$ny = $y - imagefontheight($this->font);
					break;
				case "TOP RIGHT":
					$nx = $x;
					$ny = $y - imagefontheight($this->font);
					break;
				case "CENTER LEFT":
					$nx = $x - imagefontwidth($this->font)*$sl;
					$ny = $y - imagefontheight($this->font)/2;
					break;
				case "CENTER CENTER":
					$nx = $x - imagefontwidth($this->font)*$sl/2;
					$ny = $y - imagefontheight($this->font)/2;
					break;
				case "CENTER RIGHT":
					$nx = $x;
					$ny = $y - imagefontheight($this->font)/2;
					break;
				case "BOTTOM LEFT":
					$nx = $x - imagefontwidth($this->font)*$sl;
					$ny = $y;
					break;
				case "BOTTOM CENTER":
					$nx = $x - imagefontwidth($this->font)*$sl/2;
					$ny = $y;
					break;
				case "BOTTOM RIGHT":
					$nx = $x;
					$ny = $y;
					break;
			}
			if($this->fontDirection == "vertical"){
				imagestringup($this->image, $this->font, $nx, $ny, $string, $this->palette[$this->strokeColor]);
			}
			elseif($this->fontDirection == "horizontal"){
				imagestring($this->image, $this->font, $nx, $ny, $string, $this->palette[$this->strokeColor]);
			}
		}


		// Aliases of Drawing Methods //


		// alias of drawLine
		public function line($x1,$y1,$x2,$y2){
			$this->drawLine($x1,$y1,$x2,$y2);
		}

		// alias of drawDashedLine
		public function dashedLine($x1,$y1,$x2,$y2){
			$this->drawDashedLine($x1,$y1,$x2,$y2);
		}

		// alias of drawPolygon
		public function polygon($points,$closed=false,$fill=false,$onlyFill=false){
			$this->drawPolygon($points,$closed,$fill,$onlyFill);
		}

		// alias of drawRectangle
		public function rectangle($x1,$y1,$x2,$y2,$fill=false,$onlyFill=false){
			$this->drawRectangle($x1,$y1,$x2,$y2,$fill,$onlyFill);
		}

		// alias of drawEllipse
		public function ellipse($x,$y,$w,$h,$fill=false,$onlyFill=false){
			$this->drawEllipse($x,$y,$w,$h,$fill,$onlyFill);
		}

		// alias of drawCircle
		public function circle($x,$y,$r,$fill=false,$onlyFill=false){
			$this->drawCircle($x,$y,$r,$fill,$onlyFill);
		}

		// alias of drawPixel
		public function pixel($x,$y){
			$this->drawPixel($x,$y);
		}

		// alias of drawArc
		public function arc($x, $y, $r1, $r2, $from, $to, $fill=false,$onlyFill=false){
			$this->drawArc($x, $y, $r1, $r2, $from, $to, $fill, $onlyFill);
		}

		// alias of drawWrappedText
		public function wrappedText($string,$x,$y,$width,$lineHeight=null){
			$this->drawWrappedText($string,$x,$y,$width,$lineHeight);
		}

		// alias of drawText
		public function text($string,$x,$y){
			$this->drawText($string,$x,$y);
		}

		/* Image Editing */

		// Resize image
		public function resize($w,$h){
			imagescale($this->image,$w,$h);
			$this->width = $w;
			$this->height = $h;
		}

		// Alias of resize; increases size by given mulitplication factor
		public function scale($factor){
			$this->resize($this->width * $factor, $this->height * $factor);
		}

		// Rotate image
		public function rotate($angle,$radians = false){
			$this->image = imagerotate($this->image, $radians ? rad2deg($angle) : $angle, $this->palette[$this->fillColor]);
		}

		// Crop image
		public function crop($x,$y,$w,$h){
			imagecrop($this->image,[
				"x" => $x,
				"y" => $y,
				"width" => $w,
				"height" => $h
			]);
		}

		/* Image filters */

		private function filter($type, $a=null, $b=null, $c=null, $d=null){
			switch($type){
				case "negate":
					imagefilter($this->image, IMG_FILTER_NEGATE);
					break;
				case "grayscale":
					imagefilter($this->image, IMG_FILTER_GRAYSCALE);
					break;
				case "brightness":
					imagefilter($this->image, IMG_FILTER_BRIGHTNESS, $a);
					break;
				case "contrast":
					imagefilter($this->image, IMG_FILTER_CONTRAST, $a);
					break;
				case "colorize":
					imagefilter($this->image, IMG_FILTER_COLORIZE, $a, $b, $c, $d);
					break;
				case "edgedetect":
					imagefilter($this->image, IMG_FILTER_EDGEDETECT);
					break;
				case "emboss":
					imagefilter($this->image, IMG_FILTER_EMBOSS);
					break;
				case "gaussian_blur":
					imagefilter($this->image, IMG_FILTER_GAUSSIAN_BLUR);
					break;
				case "selective_blur":
					imagefilter($this->image, IMG_FILTER_SELECTIVE_BLUR);
					break;
				case "mean_removal":
					imagefilter($this->image, IMG_FILTER_MEAN_REMOVAL);
					break;
				case "smooth":
					imagefilter($this->image, IMG_FILTER_SMOOTH, $a);
					break;
				case "pixelate":
					imagefilter($this->image, IMG_FILTER_PIXELATE, $a, $b);
					break;
			}
		}

		public function negate(){
			$this->filter("negate");
		}

		public function grayscale(){
			$this->filter("grayscale");
		}

		public function brightness($level){
			$this->filter("brightness",$level);
		}

		public function contrast($amount){
			$this->filter("contrast",$amount);
		}

		public function colorize($red, $green, $blue, $alpha){
			$this->filter("colorize",$red, $green, $blue, $alpha);
		}

		public function edgedetect(){
			$this->filter("edgedetect");
		}

		public function emboss(){
			$this->filter("emboss");
		}

		public function gaussianblur(){
			$this->filter("gaussian_blur");
		}

		public function selectiveblur(){
			$this->filter("selective_blur");
		}

		public function meanremoval(){
			$this->filter("mean_removal");
		}

		public function smooth($amount){
			$this->filter("smooth",$amount);
		}

		public function pixelate($size,$advanced=false){
			$this->filter("pixelate");
		}

	}
?>
