<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class GuideController extends BaseController
{
    public function getIndex()
    {
        $guides = Guide::all();
        return view('index', compact('guides'));
    }

    public function getCreate()
    {
        return view('guides.create');
    }
    public function postCreate(Request $request)
    {
        $guide = Guide::create($request->all());

        foreach($request->get('steps') as $step){
            // TODO steps for guide
        }

        foreach($request->get('sourcecitations') as $sourcecitation){
            // TODO sourcecitations for guide
        }

        // TODO Rest of the creation
    }

    public function getShow($id)
    {
        $guide = Guide::find($id);
        return view('guides.show', compact('guide'));
    }

    public function getDestroy($id)
    {
        $guide = Guide::find($id);
        return view('guides.destroy', compact('guide'));
    }
    public function postDestroy($id)
    {
        $guide = Guide::find($id);

        $user = User::getUserLoggedIn();

        if($user->isAdmin() || $user->id == $guide->creator_id){
            flash('Ohje poistettu onnistuneesti');
            $guide->destroy();
        } else {
            flash()->error('Ei oikeuksia ohjeen poistoon');
        }

        return redirect()->to('/');
    }
}
