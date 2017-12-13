<?php

//namespace App\Legacy\Bootstrap;

class BootstrapDecorator extends Decorator {
	function PadLeft($text, $pad) {
		if ($pad > 0) {
			$class = " class=\"pad{$pad}\"";
		}
		
		return "<div{$class}>{$text}</div>";
	}
	
	public function LocationBlock($link_array, $name) {
		if (is_array($link_array)) {
			foreach ($link_array as $link) {
				$links[] = array('link' => $link);
			}
			
			return array_reverse($links);
		}
	}

	function SublistBlock($articles) {
		$links = array();
		if ($articles != null) {
			foreach ($articles as $article) {
				list($id, $name_ru, $name_en, $cat, $cat_name_ru, $cat_name_en) = $article;

				$name_esc = $this->env->parser->FromSpaces($name_en);
				$cat_esc = $this->env->parser->FromSpaces($cat_name_en);

				$links[] = array('link' => $this->ArticleUrl($name_ru, $name_en, $name_esc, $cat_name_en, $cat_esc, false, "label label-default"));
			}
		}
		
		return $links;
	}
	
	function ContentsBlock($list) {
		return array_map(function($link) {
			return [ 'link' => $link ];
		}, $list);
	}

	public function ArticlePageBlock($article) {
		return $article->block_text . $article->block_tags;
	}

	function NoIndexUrl($url, $text, $title = '', $style = '') {
		return $this->Url($url, $text, $title, $style);
	}
	
	private function arrayToClassString($classes) {
		$result = '';
		if (count($classes) > 0) {
			$c = implode(' ', $classes);
			$result = " class=\"{$c}\"";
		}
		
		return $result;
	}

	function Image($tag, $source, $alt = '', $width = 0, $height = 0, $thumb = '', $noindex = false) {
		$imageText = '';

		$divClasses = [ 'img' ];
		$imgClasses = [ 'img-responsive' ];
		
		switch ($tag) {
			case 'rightimg':
				$divClasses[] = 'img-right';
				break;
				
			case 'leftimg':
				$divClasses[] = 'img-left';
				break;

			case 'img':
				//$divClasses[] = 'img-center';
				//$imgClasses[] = 'center';
				break;
		}

		if (strlen($source) > 0) {
			if (strlen($alt) > 0) {
				$alt = htmlspecialchars($alt, ENT_QUOTES);
				$imageAttrText .= " title=\"{$alt}\"";
				$subText = "<div class=\"img-caption\">{$alt}</div>";
			}
			
			$finalSrc = (strlen($thumb) > 0) ? $thumb : $source;
			
			if ($width > 0) {
				$imageAttrText .= " width=\"{$width}\"";
				if (strlen($thumb) == 0) {
					$thumb = $source;
				}
			}
			/*else {
				$imgClasses[] = 'img-responsive';
				if (isset($divClasses['center'])) {
					$imgClasses[] = 'center';
					unset($divClasses['center']);
				}
			}*/

			if ($height > 0) {
				$imageAttrText .= " height=\"{$height}\"";
			}
			
			$imgClassText = $this->arrayToClassString($imgClasses);
			$divClassText = $this->arrayToClassString($divClasses);

			$imageText .= "<img src=\"{$finalSrc}\"{$imgClassText}{$imageAttrText} />";

			if (strlen($thumb) > 0) {
				$imageText = "<a href=\"{$source}\" class=\"colorbox\">{$imageText}</a>";
			}

			$imageText = "<div{$divClassText}>{$imageText}{$subText}</div>";
		}

		return $imageText;
	}

	function YoutubeBlock($code, $width = 0, $height = 0) {
		if ($width > 0) {
			$widthText = " width=\"{$width}\"";
		}
		
		if ($height > 0) {
			$heightText = " height=\"{$height}\"";
		}
		
		if ($width == 0 && $height == 0) {
			$divClass = ' class="embed-responsive embed-responsive-16by9"';
			$iFrameClass = ' class="embed-responsive-item"';
		}
		else {
			$divClass = ' class="center"';
		}
		
		return "<div{$divClass}><iframe{$iFrameClass} src=\"https://www.youtube.com/embed/{$code}\"{$widthText}{$heightText} frameborder=\"0\" allowfullscreen></iframe></div>";
	}

	function QuoteBlock($quotename, $text, $author, $url = "", $date = "") {
		$result = "";

		switch ($quotename) {
			case "quote":
				$header = '';

				if (strlen($date) > 0) {
					$date = "[$date]";
				}

				if (strlen($author) > 0 || strlen($date) > 0) {
					if (strlen($author) > 0) {
						if (strlen($url) > 0) {
							$author = $this->NoIndexUrl($url, $author);
						}

						$author = "<span class=\"quote-author\">{$author}</span>";
						
						if (strlen($date) > 0) {
							$date = ' ' . $date;
						}
					}

					$header = "<div class=\"quote-header\">{$author}{$date}:</div>";
				}

				$result = "<div class=\"quote\">{$header}<div class=\"quote-body\">{$text}</div></div>";
				break;

			case "bluepost":
				if (strlen($author) == 0) {
					$author = "Blizzard";
				}

				if (strlen($url) > 0) {
					$author = $this->NoIndexUrl($url, $author, "", "blue");
				}
				
				if (strlen($date) > 0) {
					$date = " [$date]";
				}

				$result = "<div class=\"bluepost\"><div class=\"bluepost-header\"><span class=\"bluepost-author\">{$author}</span>{$date}:</div><div class=\"bluepost-body\">{$text}</div></div>";
				break;

			default:
				$result = $text;
				break;
		}

		return $result;
	}


	function DivBlock($id, $title, $body, $visible = false) {
		$shortid = "short".$id;
		$fullid = "full".$id;

		if ($visible) {
			$shortstyle = "none";
			$fullstyle = "block";
		}
		else {
			$shortstyle = "block";
			$fullstyle = "none";
		}

		$short = "<div id=\"{$shortid}\" style=\"display:{$shortstyle};\">
				<span class=\"spoiler-header\" onclick=\"{$fullid}.style.display='block'; {$shortid}.style.display='none';\">{$title} <span class=\"glyphicon glyphicon-plus\" aria-hidden=\"true\"></span></span>
				</div>";

		$full = "<div id=\"{$fullid}\" style=\"display:{$fullstyle};\">
				<span class=\"spoiler-header\" onclick=\"{$fullid}.style.display='none';{$shortid}.style.display='block';\">{$title} <span class=\"glyphicon glyphicon-minus\" aria-hidden=\"true\"></span></span>
				<div class=\"spoiler-body\">{$body}</div>
			</div>";

		return $short.$full;
	}

	function SpoilerBlock($content, $label = "") {
		if (strlen($label) == 0) {
			$label = "Спойлер";
		}

		$id = mt_rand();

		$div = $this->DivBlock($id, $label, $content);

		return "<div class=\"spoiler\">{$div}</div>";
	}
	
	function Next() {
		return '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>';
	}
	
	function Prev() {
		return '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>';
	}
}
