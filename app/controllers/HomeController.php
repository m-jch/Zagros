<?php

class HomeController extends BaseController {

    public function getIndex()
    {
        $projects = Project::where('admins', 'like', '%'.Auth::id().'%')
                                ->orWhere('writers', 'like', '%'.Auth::id().'%')
                                ->orWhere('readers', 'like', '%'.Auth::id().'%')
                                ->get();

        return View::make('project.list')->with(array(
            'projects' => $projects
        ));
    }
}
