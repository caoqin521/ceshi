<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Model\Admin\Gbook;

class GbookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rs = DB::table('gbook')
        ->join('user','user_id','=','gbook_user_id')
        ->select('user.user_name','user.user_id','gbook.*')
        ->paginate($request->input('num',10));
        $rss=DB::table('user')->select('user_id','user_name')->get();
        // dd($rss);
        $res = DB::table('admin_gbook_replay')
        ->join('user','user.user_id','=','admin_gbook_replay.user_id')
        ->join('admin','admin.id','=','admin_gbook_replay.admin_id')
        ->select('user.user_id','user.user_name','admin.id','admin.mname','admin_gbook_replay.*')
        ->paginate($request->input('num',10));
        // $res = DB::table('gbook')
        // ->join('user','user_id','=','gbook_user_id')
        // ->join('admin','admin.id','=','gbook.gbook_admin_id')
        // ->join('admin_gbook_replay','admin_gbook_replay.gbook_replay_id','=','gbook.gbook_id')
        // ->select('user.user_name','admin.mname','admin.id','admin.admin_gbook_replay','admin.admin_gbook_id','gbook.*','admin_gbook_replay.replay_id','admin_gbook_replay.gbook_replay_id','admin_gbook_replay.admin_replay')
        // ->paginate($request->input('num',5));
        // dd($res);
        return view('admin/gbook/gbooks',
            ['title'=>'留言管理',
            'res'=>$res,
            'request'=>$request,
            'rs'=>$rs,
            'rss'=>$rss
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $a = Gbook::where('gbook_id',$id)->delete();
        // dd($a);
        try{
                
                if($a){
                    return redirect('/admin/gbook')->with('success','删除成功');
                }
            } catch(\Exception $e){
                return back()->with('error','删除失败');
            }
    }
}
