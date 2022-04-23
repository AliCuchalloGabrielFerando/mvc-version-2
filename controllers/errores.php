<?php
  require 'views/error/errorView.php';
 class Errors{
     protected $errorView;
        function __construct()
        {
           $this->errorView = new ErrorView();
            $this->errorView->render();
        }
 }
?>