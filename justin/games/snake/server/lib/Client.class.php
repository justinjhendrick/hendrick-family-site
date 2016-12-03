<?php

class Client {
	public function __construct(){}
	static $serverUrl = "http://www.hendrick.family/justin/games/snake/server/";
	static function send_score($score, $name, $callback) {
		$cnx = haxe_remoting_HttpAsyncConnection::urlConnect(_hx_string_or_null(Client::$serverUrl) . "index.php");
		$cnx->setErrorHandler(array(new _hx_lambda(array(&$callback, &$cnx, &$name, &$score), "Client_0"), 'execute'));
		$cnx->resolve("Server")->resolve("handle_score")->call((new _hx_array(array($score, $name))), $callback);
	}
	static function get_scores_raw($callback) {
		$http = new haxe_Http(_hx_string_or_null(Client::$serverUrl) . _hx_string_or_null(Server::$hi_score_file));
		$http->onData = $callback;
	}
	function __toString() { return 'Client'; }
}
function Client_0(&$callback, &$cnx, &$name, &$score, $err) {
	{
		haxe_Log::trace("Error: " . _hx_string_or_null($err), _hx_anonymous(array("fileName" => "Client.hx", "lineNumber" => 14, "className" => "Client", "methodName" => "send_score")));
	}
}
