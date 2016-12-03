<?php

interface haxe_remoting_AsyncConnection {
	function resolve($name);
	function call($params, $result = null);
}
