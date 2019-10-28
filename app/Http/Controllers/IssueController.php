<?php

namespace App\Http\Controllers;

use App\models\Issue;
use App\models\TelegramBot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == 'manager')
        {
            $issues = Issue::with('author')
                ->orderByDesc('id')->get();
        }
        else
        {
            $issues = Issue::with('author')
                ->where('author_id', Auth::user()->id)
                ->orderByDesc('id')->get();
        }

        return view('issue.list', compact('issues'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $issue = new Issue();
        return view('issue.edit', compact('issue'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::guest())
        {
            abort(403, 'Unauthorized action.');
        }

        //Создание заявки не чаще раза в сутки
        $date = new Carbon();
        $date->modify('-1 day');

        $existsIssue = Issue::with('author')
            ->where('author_id', Auth::user()->id)
            ->where('created_at', '>', $date->format('Y-m-d H:i:s'))
            ->orderByDesc('id')->get();

        if($existsIssue)
        {
            return back()
                ->withErrors(['msg' => 'Please, wait 1 day for create new issue'])
                ->withInput();
        }

        $data = $request->input();
        $data['author_id'] = Auth::user()->id;

        $issue = (new Issue())->create($data);

        if($issue)
        {
            //Отправляем сообщение в телеграм
            new TelegramBot('You have new Issue');

            return redirect()
                ->route('issue.edit', $issue->id)
                ->with(['success' => 'Issue created']);
        }
        else
        {
            return back()
                ->withErrors(['msg' => 'Error create'])
                ->withInput();
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $issue = Issue::where('id', $id)->with('author')->first();
        return view('issue.view', compact('issue'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $issue = Issue::where('id', $id)->with('author')->first();
        if(empty($issue))
        {
            return redirect()->route('issue.index');
        }

        return view('issue.edit', compact('issue'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::guest())
        {
            abort(403, 'Unauthorized action.');
        }
        $issue = Issue::find($id);
        if(empty($issue))
        {
            return back()->withInput();
        }
        $data = $request->input();

        if(Auth::user()->role != 'manager' && isset($data['answer']))
        {
            unset($data['answer']);
        }

        $result = $issue->fill($data)->save();
        if($result)
        {
            return redirect()
                ->route('issue.edit', $id)
                ->with(['success' => 'Issue saved!']);
        }
        else
        {
            return back()
                ->withErrors(['msg' => 'Saved error!'])
                ->withInput();
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::guest())
        {
            abort(403, 'Unauthorized action.');
        }
        $result = Issue::destroy($id);
        if($result)
        {
            return redirect()
                ->route('issue.index')
                ->with(['success' => 'Issue deleted']);
        }
        else
        {
            return back()
                ->withErrors(['msg' => 'Delete error!']);
        }
    }

    public function takeInWork($id)
    {
        if(Auth::user()->role != 'manager')
        {
            return redirect()
                ->route('issue.show', $id);
        }

        $issue = Issue::find($id);
        if(empty($issue))
        {
            return redirect()
                ->route('issue.show', $id);
        }

        $issue->manager_id = Auth::user()->id;
        $issue->save();

        return redirect()
            ->route('issue.show', $id)
            ->with(['success' => 'Issue take in work']);
    }

}
