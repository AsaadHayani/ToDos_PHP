<?php

class Paginator
{
  public $limit;
  public $offset;
  public $next;
  public $prev;
  public function __construct($page, $record_page, $total)
  {
    $this->limit = $record_page;
    $this->offset = $record_page * ($page - 1);
    $totalPage = ceil($total / $record_page);
    if ($page < $totalPage) {
      $this->next = $page + 1;
    }
    if ($page > 1) {
      $this->prev = $page - 1;
    }
  }
}
