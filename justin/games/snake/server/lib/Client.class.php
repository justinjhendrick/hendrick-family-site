<?php

class Client {
	public function __construct(){}
	static $serverUrl = "http://www.hendrick.family/justin/games/snake/server/";
	static $score;
	static function response_callback() { $args = func_get_args(); return call_user_func_array(self::$response_callback, $args); }
	static $response_callback;
	static function send_score() {
		haxe_Log::trace("hi scores not yet supported on this platform", _hx_anonymous(array("fileName" => "Client.hx", "lineNumber" => 29, "className" => "Client", "methodName" => "send_score")));
	}
	static function get_scores($callback) {
		$http = new haxe_Http(_hx_string_or_null(Client::$serverUrl) . _hx_string_or_null(Server::$hi_score_file));
		$http->onData = $callback;
		$http->request(null);
	}
	function __toString() { return 'Client'; }
}
