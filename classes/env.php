<?php

require_once "{$folders['phplive']}env.php";

require_once "{$folders['classes']}settings.php";
require_once "{$folders['classes']}db.php";
require_once "{$folders['classes']}decorator.php";
require_once "{$folders['classes']}parser.php";

require_once "{$folders['classes']}router.php";
require_once "{$folders['classes']}builder.php";

require_once "{$folders['smarty']}post_parser.php";

class BootstrapEnvironment extends Environment {
	public $router;
	public $builder;
	
	public $forum_parser;

	function __construct() {
		parent::__construct();

		// "dependency injection"
		$this->settings = new BootstrapSettings();
		$this->db = new BootstrapDataBase($this);
		$this->decorator = new BootstrapDecorator($this);
		$this->parser = new BootstrapParser($this);

		// further init
		$this->router = new Router($this);
		$this->builder = new Builder($this);
		
		$this->forum_parser = new post_parser();
	}
}
