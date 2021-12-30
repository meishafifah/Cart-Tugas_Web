<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('welcome_message');
        // return $this->get_menu();
        // return base_url();
    }
}
