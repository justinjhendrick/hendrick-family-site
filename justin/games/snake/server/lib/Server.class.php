<?php

class Server {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->hi_score_file = "hi_scores.txt";
		haxe_Log::trace("server created", _hx_anonymous(array("fileName" => "Server.hx", "lineNumber" => 6, "className" => "Server", "methodName" => "new")));
	}}
	public $hi_score_file;
	public function handle_score($score, $name) {
		haxe_Log::trace("server got " . _hx_string_rec($score, "") . ", " . _hx_string_or_null($name), _hx_anonymous(array("fileName" => "Server.hx", "lineNumber" => 9, "className" => "Server", "methodName" => "handle_score")));
		$exists = file_exists($this->hi_score_file);
		$hi_score = null;
		$hi_scorer_name = null;
		if($exists) {
			$content = sys_io_File::getContent($this->hi_score_file);
			$score_name = _hx_explode(",", $content);
			$hi_score = Std::parseInt($score_name[0]);
			$hi_scorer_name = $score_name[1];
		} else {
			$hi_score = -1;
		}
		if(!$exists || $score > $hi_score) {
			$hi_scorer_name = $name;
			$hi_score = $score;
			sys_io_File::write($this->hi_score_file, null)->writeString(Std::string($hi_score) . "," . _hx_string_or_null($hi_scorer_name));
		}
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->__dynamics[$m]) && is_callable($this->__dynamics[$m]))
			return call_user_func_array($this->__dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call <'.$m.'>');
	}
	static function main() {
		$ctx = new haxe_remoting_Context();
		$ctx->addObject("Server", new Server(), null);
		if(haxe_remoting_HttpConnection::handleRequest($ctx)) {
			haxe_Log::trace("handleRequest returned true", _hx_anonymous(array("fileName" => "Server.hx", "lineNumber" => 36, "className" => "Server", "methodName" => "main")));
			return;
		}
		haxe_Log::trace("This is a remoting server !", _hx_anonymous(array("fileName" => "Server.hx", "lineNumber" => 41, "className" => "Server", "methodName" => "main")));
	}
	function __toString() { return 'Server'; }
}
