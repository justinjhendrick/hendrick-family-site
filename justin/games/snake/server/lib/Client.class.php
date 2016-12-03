<?php

class Client {
	public function __construct(){}
	static $serverUrl = "http://www.hendrick.family/justin/games/snake/server/";
	static function send_score($score, $name) {
		$cnx = haxe_remoting_HttpAsyncConnection::urlConnect(_hx_string_or_null(Client::$serverUrl) . "index.php");
		$cnx->setErrorHandler(array(new _hx_lambda(array(&$cnx, &$name, &$score), "Client_0"), 'execute'));
		$cnx->resolve("Server")->resolve("handle_score")->call((new _hx_array(array($score, $name))), array(new _hx_lambda(array(&$cnx, &$name, &$score), "Client_1"), 'execute'));
	}
	static function get_scores() {
		$scores = Client::get_scores_raw();
		return Server::parse_hi_scores($scores);
	}
	static function get_scores_raw() {
		try {
			return haxe_Http::requestUrl(_hx_string_or_null(Client::$serverUrl) . _hx_string_or_null(Server::$hi_score_file));
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				return null;
			}
		}
	}
	function __toString() { return 'Client'; }
}
function Client_0(&$cnx, &$name, &$score, $err) {
	{
		haxe_Log::trace("Error: " . _hx_string_or_null($err), _hx_anonymous(array("fileName" => "Client.hx", "lineNumber" => 12, "className" => "Client", "methodName" => "send_score")));
	}
}
function Client_1(&$cnx, &$name, &$score, $data) {
	{
		haxe_Log::trace("Result: " . _hx_string_or_null($data), _hx_anonymous(array("fileName" => "Client.hx", "lineNumber" => 14, "className" => "Client", "methodName" => "send_score")));
	}
}
