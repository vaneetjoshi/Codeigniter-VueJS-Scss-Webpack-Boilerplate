<?php

namespace MyWebSocketsApp\Connection;

interface ChatConnectionInterface
{
  public function getConnection();

  public function sendMsg($msg);
}

?>
