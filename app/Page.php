<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public const PAGES = [
		"html" => [
			"description" => "Websites and HTML related creations",
			"Jacks_Pancakes" => [
				"description" => "End-semester Website made in university. Employs PHP content rendering, loading from a file-based database, custom vanilla css.",
				"thumbnail" => "https://i.imgur.com/BbdMDn5.png",
				"data" => ""
			],
			"Caps_Cutlery" => [
				"description" => "Jack Sparrow's kitchen shop",
				"thumbnail" => "https://i.imgur.com/xJIiA1r.png",
				"data" => ""
			],
			"Website_Layout_Designer" => [
				"description" => "(WIP) An interactive website layout designer. First project stage uses only bootstrap classes, Second stage will be more customizable",
				"thumbnail" => "https://i.imgur.com/or8abx8.png",
				"data" => ""
			]
			/*"Restaurant" => [
				"description" => "A restaurant ordering system, designed to also keep track of ingredient stocks.",
				"thumbnail" => "",
				"data" => ""
			],*/
		],
		"php" => [
			"description" => "Primarily PHP-based websites and PHP creations",
			/*"default" => [
				"description" => "PHP Class Showcasing",
				"thumbnail" => "https://i.imgur.com/K8Hl5u5.png",
				"data" => "C:/Users/Glenn/Documents/PHP/Laravel/portfolio/resources/assets/php/index.php",
				"classSet" => ["Test"] //Classes to display
			],*/
			"canvas" => [
				"description" => "A simplified class for PHP Image creation and manipulation.",
				"thumbnail" => "https://i.imgur.com/n1A8ScA.png",
				"data" => [
					"methods" => [
						"Setup Methods" => [
							"draw" => [
								"description" => "This should always be the last line in your image script. This method renders the given Canvas instance with the appropriate image format, then deletes all Canvas instances, and deallocates memory. Printing anything after the image has been rendered may cause the image to be corrupt or malformed.",
								"parameters" => []
							],
							"stroke" => [
								"description" => "Sets the stroke color for lines and edges.",
								"parameters" => [
									"color" => [
										"type" => "array (int, int, int)",
										"default" => null
									]
								]
							],
							"fill" => [
								"description" => "Sets the fill color for geometric shapes.",
								"parameters" => [
									"color" => [
										"type" => "array (int, int, int)",
										"default" => null
									]
								]
							],
							"textDirection" => [
								"description" => "Set the direction for rendered text",
								"parameters" => [
									"direction" => [
										"type" => "String ( \"vertical\" | \"horizontal\" )",
										"default" => null
									]
								]
							],
							"textFont" => [
								"description" => "Set the font to be used when rendering text",
								"parameters" => [
									"font" => [
										"type" => "integer | filename",
										"default" => null
									]
								]
							],
							"strokeWeight" => [
								"description" => "set thickness of lines and edges",
								"parameters" => [
									"weight" => [
										"type" => "integer",
										"default" => null
									]
								]
							],
							"textAlign" => [
								"description" => "set where (x,y) refers to, relative to text. Set as TOP LEFT by default",
								"parameters" => [
									"align" => [
										"type" => "String ( \"TOP LEFT\" | \"TOP CENTER\" | \"TOP RIGHT\" | \"CENTER LEFT\" | \"CENTER CENTER\" | \"CENTER RIGHT\" | \"BOTTOM LEFT\" | \"BOTTOM CENTER\" | \"BOTTOM RIGHT\" )",
										"default" => null
									]
								]
							]
						],
						"Canvas-wide Methods" => [
							"background" => [
								"description" => "Paints entire canvas with current fill color",
								"parameters" => [
									"color" => [
										"type" => "array (int, int, int)",
										"default" => "null"
									]
								]
							],
							"floodFill" => [
								"description" => "Flood fills out from position with current fill color",
								"parameters" => [
									"x" => [
										"type" => "integer",
										"default" => null
									],
									"y" => [
										"type" => "integer",
										"default" => null
									],
									"color" => [
										"type" => "array (integer, integer, integer)",
										"default" => null
									]
								]
							],
							"overlay" => [
								"description" => "Overlays another Canvas, src is the canvas being overlain, dest is the current canvas",
								"parameters" => [
									"src" => [
										"type" => "Canvas",
										"default" => null
									],
									"dest_x" => [
										"type" => "integer",
										"default" => null
									],
									"dest_y" => [
										"type" => "integer",
										"default" => null
									],
									"src_x" => [
										"type" => "integer",
										"default" => "null"
									],
									"src_y" => [
										"type" => "integer",
										"default" => "null"
									],
									"src_width" => [
										"type" => "integer",
										"default" => "null"
									],
									"src_height" => [
										"type" => "integer",
										"default" => "null"
									],
									"height" => [
										"type" => "integer",
										"default" => "100"
									]
								]
							],
							"resize" => [
								"description" => "Scales canvas to new dimensions.",
								"parameters" => [
									"new_x" => [
										"type" => "integer",
										"default" => null
									],
									"new_y" => [
										"type" => "integer",
										"default" => null
									]
								]
							],
							"rotate" => [
								"description" => "Rotates canvas by given amount in degrees, or radians if specified",
								"parameters" => [
									"angle" => [
										"type" => "integer",
										"default" => null
									],
									"radians" => [
										"type" => "boolean",
										"default" => "false"
									]
								]
							],
							"scale" => [
								"description" => "Scales whole canvas by a factor",
								"parameters" => [
									"factor" => [
										"type" => "integer",
										"default" => null
									]
								]
							]
						],
						"Geometry Methods" => [
							"line" => [
								"description" => "Draw a straight line between two points",
								"parameters" => [
									"x1" => [
										"type" => "integer",
										"default" => null
									],
									"y1" => [
										"type" => "integer",
										"default" => null
									],
									"x2" => [
										"type" => "integer",
										"default" => null
									],
									"y2" => [
										"type" => "integer",
										"default" => null
									]
								]
							],
							"dashedLine" => [
								"description" => "Draw a dashed line between two points",
								"parameters" => [
									"x1" => [
										"type" => "integer",
										"default" => null
									],
									"y1" => [
										"type" => "integer",
										"default" => null
									],
									"x2" => [
										"type" => "integer",
										"default" => null
									],
									"y2" => [
										"type" => "integer",
										"default" => null
									]
								]
							],
							"polygon" => [
								"description" => "Draw a polygon, which may be closed or not. Points array must have an even number of points.",
								"parameters" => [
									"points" => [
										"type" => "array (int, int, ...)",
										"default" => null
									],
									"closed" => [
										"type" => "boolean",
										"default" => "false"
									],
									"fill" => [
										"type" => "boolean",
										"default" => "false"
									],
									"onlyFill" => [
										"type" => "boolean",
										"default" => "false"
									]
								]
							],
							"rectangle" => [
								"description" => "Draw a rectangle",
								"parameters" => [
									"x1" => [
										"type" => "integer",
										"default" => null
									],
									"y1" => [
										"type" => "integer",
										"default" => null
									],
									"x2" => [
										"type" => "integer",
										"default" => null
									],
									"y2" => [
										"type" => "integer",
										"default" => null
									],
									"fill" => [
										"type" => "boolean",
										"default" => "false"
									],
									"onlyFill" => [
										"type" => "boolean",
										"default" => "false"
									]
								]
							],
							"ellipse" => [
								"description" => "Draw an ellipse",
								"parameters" => [
									"x1" => [
										"type" => "integer",
										"default" => null
									],
									"y1" => [
										"type" => "integer",
										"default" => null
									],
									"r1" => [
										"type" => "integer",
										"default" => null
									],
									"r2" => [
										"type" => "integer",
										"default" => null
									],
									"fill" => [
										"type" => "boolean",
										"default" => "false"
									],
									"onlyFill" => [
										"type" => "boolean",
										"default" => "false"
									]
								]
							],
							"circle" => [
								"description" => "Draw a circle",
								"parameters" => [
									"x" => [
										"type" => "integer",
										"default" => null
									],
									"y" => [
										"type" => "integer",
										"default" => null
									],
									"r" => [
										"type" => "integer",
										"default" => null
									],
									"fill" => [
										"type" => "",
										"default" => "false"
									],
									"onlyFill" => [
										"type" => "",
										"default" => "false"
									]
								]
							],
							"arc" => [
								"description" => "Draw an arc of an ellipse, from angle 1 to angle 2. Angles start at the right-hand side of the ellipse, and progress clockwise.",
								"parameters" => [
									"x" => [
										"type" => "integer",
										"default" => null
									],
									"y" => [
										"type" => "integer",
										"default" => null
									],
									"radius_1" => [
										"type" => "integer",
										"default" => null
									],
									"radius_2" => [
										"type" => "integer",
										"default" => null
									],
									"angle_1" => [
										"type" => "integer",
										"default" => null
									],
									"angle_2" => [
										"type" => "integer",
										"default" => null
									],
									"fill" => [
										"type" => "boolean",
										"default" => "false"
									],
									"onlyFill" => [
										"type" => "boolean",
										"default" => "false"
									]
								]
							],
							"text" => [
								"description" => "render text with current font, without any wrapping",
								"parameters" => [
									"string" => [
										"type" => "String",
										"default" => null
									],
									"x" => [
										"type" => "integer",
										"default" => null
									],
									"y" => [
										"type" => "integer",
										"default" => null
									]
								]
							],
							"wrappedText" => [
								"description" => "Render text with current font, wrapping to a new line when line length exceeds given width in pixels.",
								"parameters" => [
									"string" => [
										"type" => "String",
										"default" => null
									],
									"x" => [
										"type" => "integer",
										"default" => null
									],
									"y" => [
										"type" => "integer",
										"default" => null
									],
									"width" => [
										"type" => "integer",
										"default" => null
									],
									"lineHeight" => [
										"type" => "integer",
										"default" => "null"
									]
								]
							]
						],
						"Filter Methods" => [
								"negate" => [
								"description" => "Invert Colors",
								"parameters" => []
							],
							"grayscale" => [
								"description" => "Convert colors to greyscale",
								"parameters" => []
							],
							"brightness" => [
								"description" => "Increase or decrease brightness",
								"parameters" => [
									"amount" => [
										"type" => "integer",
										"default" => null
									]
								]
							],
							"contrast" => [
								"description" => "Increase or decrease contrast",
								"parameters" => [
									"amount" => [
										"type" => "integer",
										"default" => null
									]
								]
							],
							"colorize" => [
								"description" => "Colorize image",
								"parameters" => [
									"red" => [
										"type" => "integer",
										"default" => null
									],
									"green" => [
										"type" => "integer",
										"default" => null
									],
									"blue" => [
										"type" => "integer",
										"default" => null
									],
									"alpha" => [
										"type" => "integer",
										"default" => null
									]
								]
							],
							"edgedetect" => [
								"description" => "Detect images",
								"parameters" => []
							],
							"emboss" => [
								"description" => "Emboss image",
								"parameters" => []
							],
							"gaussianblur" => [
								"description" => "Apply gaussian blur",
								"parameters" => []
							],
							"selectiveblur" => [
								"description" => "Apply blur",
								"parameters" => []
							],
							"meanremoval" => [
								"description" => "Apply mean removal",
								"parameters" => []
							],
							"smooth" => [
								"description" => "Smooth image",
								"parameters" => [
									"amount" => [
										"type" => "integer",
										"default" => null
									]
								]
							],
							"pixelate" => [
								"description" => "Pixelate image",
								"parameters" => [
									"size" => [
										"type" => "integer",
										"default" => null
									],
									"advanced" => [
										"type" => "boolean",
										"default" => "false"
									]
								]
							]
						]
					]
				]
			],
			"canvas_simple" => [
				"description" => "A plaintext version of the methods shown above.",
				"thumbnail" => "https://i.imgur.com/BSJr5w9.png",
				"data" => ""
			],
			"crosshairs" => [
				"description" => "A simple demonstration of the canvas class, and how it can be used to create interactive images.",
				"thumbnail" => "https://i.imgur.com/nZRU26d.png",
				"data" => ""
			]
		],
		/*"javascript" => [
			"description" => "Created JavaScript clases and methods",
			"default" => [
				"description" => "",
				"thumbnail" => "https://i.imgur.com/K8Hl5u5.png",
				"data" => ""
			]
		],*/
		"p5" => [
			"description" => "Interactive HTML canvas using the P5.js simplified graphics library.",
			"orbitinglines" => [
				"description" => "Mutually gravitating points, moving in N dimensions. Points are cast orthogonally down to 2 dimensions.",
				"thumbnail" => "https://i.imgur.com/1xMBjQC.png",
				"data" => "http://localhost/data/p5/orbitinglines.js"
			],
			"gears" => [
				"description" => "Gear class, customizable radii and teeth",
				"thumbnail" => "https://i.imgur.com/Wp48Asp.png",
				"data" => "http://localhost/data/p5/gears.js"
			],
			"fallingblocks" => [
				"description" => "",
				"thumbnail" => "https://i.imgur.com/FPW8xit.png",
				"data" => "http://localhost/data/p5/fallingblocks.js"
			],
			"squarecircle" => [
				"description" => "",
				"thumbnail" => "http://localhost/data/p5/squarecircle.png",
				"data" => "http://localhost/data/p5/squarecircle.js"
			],
			"trails" => [
				"description" => "Rainbow trails",
				"thumbnail" => "https://i.imgur.com/1RNczv6.png",
				"data" => "http://localhost/data/p5/trails.js"
			]
		]
	];
}
