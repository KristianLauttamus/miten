<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;

class GuideController extends BaseController
{
    public function getIndex()
    {
        $guides = Guide::all();
        return view('index', compact('guides'));
    }

    public function getCreate()
    {
        return view('guides.create')->with('inputErrors', ['title' => 'asd']);
    }
    public function postCreate(Request $request)
    {

        $rules = [
            'title' => 'required',
            'steps' => 'required|array',
            'sourcecitations' => 'array',
        ];

        // Steps rules
        //
        if ($request->has('steps')) {
            foreach ($request->get('steps') as $key => $val) {
                $rules['steps.' . $key . '.title'] = 'required';
                $rules['steps.' . $key . '.image'] = 'required_without:steps.' . $key . '.video';
                $rules['steps.' . $key . '.video'] = 'required_without:steps.' . $key . '.image';
                $rules['steps.' . $key . '.content'] = 'required';
            }
        }

        // Sources & Citation's rules
        //
        if ($request->has('sourcecitations')) {
            foreach ($request->get('sourcecitations') as $key => $val) {
                $rules['sourcecitations.' . $key . '.link'] = 'required';
                $rules['sourcecitations.' . $key . '.text'] = 'required';
            }
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            flash($request)->error("Virheitä!");
            return redirect()->to('guides/create')->withErrors($validator)->withInput();
        }

        $guide = Guide::create($request->all());

        if ($request->has('steps')) {
            foreach ($request->get('steps') as $index => $step) {
                Step::create([
                    'guide_id' => $guide->id,
                    'step' => $index,
                    'title' => $step['title'],
                    'content' => $step['content'],
                    'image' => $step['image'],
                    'video' => $step['video'],
                ]);
            }
        }

        if ($request->has('sourcecitations')) {
            foreach ($request->get('sourcecitations') as $sourcecitation) {
                SourceCitation::create([
                    'guide_id' => $guide->id,
                    'text' => $sourcecitation['text'],
                    'link' => $sourcecitation['link'],
                ]);
            }
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

        if ($user->isAdmin() || $user->id == $guide->creator_id) {
            flash('Ohje poistettu onnistuneesti');
            $guide->destroy();
        } else {
            flash()->error('Ei oikeuksia ohjeen poistoon');
        }

        return redirect()->to('/');
    }
}
