<?php

class Server {
	public function __construct() {}
	public function handle_score($score, $name) { if(!php_Boot::$skip_constructor) {
		haxe_Log::trace("server got " . _hx_string_rec($score, "") . ", " . _hx_string_or_null($name), _hx_anonymous(array("fileName" => "Server.hx", "lineNumber" => 22, "className" => "Server", "methodName" => "handle_score")));
		$exists = file_exists(Server::$hi_score_file);
		$hi_score = null;
		$hi_scorer_name = null;
		if($exists) {
			$content = sys_io_File::getContent(Server::$hi_score_file);
			$top = _hx_array_get(Server::parse_hi_scores($content), 0);
			$hi_score = $top->score;
			$hi_scorer_name = $top->name;
		} else {
			$hi_score = -1;
		}
		if(!$exists || $score > $hi_score) {
			$hi_scorer_name = $name;
			$hi_score = $score;
			sys_io_File::write(Server::$hi_score_file, null)->writeString(Std::string($hi_score) . _hx_string_or_null(Server::$delim) . _hx_string_or_null($hi_scorer_name));
		}
	}}
	static $hi_score_file = "hi_scores.txt";
	static $delim = ", ";
	static function parse_hi_scores($txt) {
		$result = (new _hx_array(array()));
		{
			$_g = 0;
			$_g1 = _hx_explode("\x0A", $txt);
			while($_g < $_g1->length) {
				$s = $_g1[$_g];
				++$_g;
				$score_name = _hx_explode(Server::$delim, $s);
				$score = Std::parseInt($score_name[0]);
				$scorer_name = $score_name[1];
				$result->push(_hx_anonymous(array("score" => $score, "name" => $scorer_name)));
				unset($scorer_name,$score_name,$score,$s);
			}
		}
		return $result;
	}
	static function main() {
		$ctx = new haxe_remoting_Context();
		$ctx->addObject("Server", new Server(), null);
		if(haxe_remoting_HttpConnection::handleRequest($ctx)) {
			haxe_Log::trace("handleRequest returned true", _hx_anonymous(array("fileName" => "Server.hx", "lineNumber" => 49, "className" => "Server", "methodName" => "main")));
			return;
		}
		haxe_Log::trace("This is a remoting server !", _hx_anonymous(array("fileName" => "Server.hx", "lineNumber" => 54, "className" => "Server", "methodName" => "main")));
	}
	function __toString() { return 'Server'; }
}
