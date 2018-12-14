<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Agreplay;
use DB;

class AgreplayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $res = $request->post();
        if(is_array($res['user_id'])){
            $data = '';
            for($i = 0; $i < count($res['user_id']); $i++){
                $ress = ['user_id'=>$res['user_id'][$i], 'admin_replay'=>$res['admin_replay']];
                $data = Agreplay::create($ress);
            }
            if($data){
                return redirect('admin/gbook')->with('success','添加成功');
            } else {
                return redirect()->with('error','添加失败');
            }
        } else {
            $ress = ['user_id'=>$res['user_id'], 'admin_replay'=>$res['admin_replay']];
             // dd(Agreplay::create($ress));
            if(Agreplay::create($ress)){
            return redirect('admin/gbook')->with('success','添加成功');
            } else {
                return redirect()->with('error','添加失败');
            }
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
        // dd($request->post());
        echo '11111111111';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // //
        // // echo $id;
        // // $a = DB::table('admin_gbook_replay')->where('replay_id',$id)->delete();
        // $a = Agreplay::where('replay_id','2')->select()->get();
        // dd($a);
        try{
                $a = Agreplay::where('replay_id',$id)->delete();
                if($a){
                    return redirect('/admin/gbook')->with('success','删除成功');
                }
            } catch(\Exception $e){
                return back()->with('error','删除失败');
            }
   }
}
