<?php

class BootstrapParser extends Parser {
	function ParseBB(&$article) {
		$text = $article->text;

		$text = str_replace(array("\r\n","\r","\n") , "<br/>" , $text);

		// other replaces
		$text = $this->Replaces($text);

		$text = $this->ParseDoubleBrackets($text);
		$text = $this->ParseBrackets($text);

		// titles
		$text = $this->ParseTitles($article, $text);

		$tbs = "<p>";//$this->env->decorator->TextBlockStart();
		$tbe = "</p>";//$this->env->decorator->TextBlockEnd();

		$text = preg_replace("#(<br/><br/><br/>)#", "<br/><br/>", $text);
		//$text = preg_replace("#(<br/><br/><p)#", "<p", $text);
		//$text = preg_replace("#(/p><br/><br/>)#", "/p>", $text);
		$text = $tbs.preg_replace("#(<br/><br/>)#", $tbe.$tbs, $text).$tbe;
		
		$text = preg_replace("#(<p><p)#", "<p", $text);
		$text = preg_replace("#(</p></p>)#", "</p>", $text);
		$text = preg_replace("#(<p><div)#", "<div", $text);
		$text = preg_replace("#(</div></p>)#", "</div>", $text);
		
		return $text;
	}
}
