<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Types;
use DB;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
         $res = Types::select(DB::raw('*,CONCAT(type_path,type_id) as paths'))
         -> where('type_name','like','%'.$request->type_name.'%')
         -> orderBy('paths')
         -> paginate($request->input('num',20));

        foreach($res as $v){
            $ps = substr_count($v->type_path,',')-1;
            $v->type_name = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',$ps).'|--'.$v->type_name;
        }
        return view('admin/types/type',[
                'title'=>'视频分类列表',
                'request'=>$request,
                'res'=>$res
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $res = Types::where('type_pid','0')->get();
        return view('admin/types/creates',
            ['title'=>'添加分类',
            'res'=>$res
           ]);
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
        $res = $request->except('_token','_method');
        // dd($res);
        if($res['type_pid']==0){
            $res=[
                'type_name'=>$res['type_name_d'],
                'type_en'=>$res['type_en_d'],
                'type_pid'=>'0',
                'type_path'=>'0,'
            ];
            if(Types::create($res)){
                return redirect('admin/type/create')->with('success','添加成功');
            } else {
                return redirect()->with('error','添加失败');
            }
        } else {
            $res['type_path'] = '0,'.$res['type_pid'].',';
            $res=[
                'type_name'=>$res['type_name'],
                'type_en'=>$res['type_en'],
                'type_pid'=>$res['type_pid'],
                'type_path'=>$res['type_path']
            ];
        // dd($res);
        if(Types::create($res)){
            return redirect('admin/type')->with('success','添加成功');
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
        $rs = Types::select(DB::raw('*,CONCAT(type_path,type_id) as paths'))->
        orderBy('paths')->
        get();

        // 家用电器
        // '|--'.电视

        // foreach($rs as $v){

        //     //path  
        //     $ps = substr_count($v->type_path,',')-1;

        //     //拼接  分类名
        //     // $v->catname = str_repeat('|--',$ps).$v->catname;

        //     $v->type_name = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$ps).'|--'.$v->type_name;

        // }

        $res = Types::find($id);

        return view('admin.types.edits',[
            'title'=>'分类修改页面',
            'res'=>$res,
            'rs'=>$rs
        ]);
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
        // dd($request->input());
        $res = $request -> only('type_name');

        // dd($id);
        try{
            $data = Types::where('type_id',$id)->update($res);

            if($data){
           
                return redirect('/admin/type')->with('success','修改成功');
            }

        } catch(\Exception $e) {

            return back()->with('error','修改失败');

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
        
        if($id != 1) {
            try{
                $data = Types::where('type_id',$id)->delete();
                if($data){
                    return redirect('/admin/type')->with('success','删除成功');   
                }
            } catch(\Exception $e){
                return back()->with('error','删除失败');
            }
        } else {
            return redirect('/admin/type')->with('error','删除失败');
        }
    }
}
