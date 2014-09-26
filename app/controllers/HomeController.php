<?php

class HomeController extends BaseController {

    public function getIndex()
    {
        return View::make('project.list')->with(array());
    }
}
