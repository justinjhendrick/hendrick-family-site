<?php

class Server {
	public function __construct() {}
	public function handle_score($score, $name) { if(!php_Boot::$skip_constructor) {
		$exists = file_exists(Server::$hi_score_file);
		$hi_score = null;
		$hi_scorer_name = null;
		$old_scores = null;
		if($exists) {
			$old_scores = sys_io_File::getContent(Server::$hi_score_file);
			$top = _hx_array_get(Server::parse_hi_scores($old_scores), 0);
			$hi_score = $top->score;
			$hi_scorer_name = $top->name;
		} else {
			$hi_score = -1;
		}
		if(!$exists || $score > $hi_score) {
			$hi_scorer_name = $name;
			$hi_score = $score;
			$new_hi_scores = Std::string($hi_score) . _hx_string_or_null(Server::$delim) . _hx_string_or_null($hi_scorer_name);
			sys_io_File::write(Server::$hi_score_file, null)->writeString($new_hi_scores);
			return $new_hi_scores;
		} else {
			if($old_scores !== null) {
				return $old_scores;
			} else {
				return null;
			}
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
			return;
		}
	}
	function __toString() { return 'Server'; }
}
