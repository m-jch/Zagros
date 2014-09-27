<?php

class HomeController extends BaseController {

    public function getIndex()
    {
        $projects = Project::all();
        return View::make('project.list')->with(array(
            'projects' => $projects
        ));
    }
}
