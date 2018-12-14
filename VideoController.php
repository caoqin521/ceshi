<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Model\Admin\Vod;

class VideoController extends Controller
{
    /**
     * 视频管理的页面
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $res = DB::table('vod')
        ->join('type','type.type_id','=','vod.type_id')
        ->select('type.type_name','vod.vod_name','vod.vod_id','vod.vod_pic','vod.vod_class','vod.vod_status','vod.vod_actor','vod.vod_director','vod.vod_lang','vod.vod_serial')
        ->orderby('vod.vod_id','desc')->paginate($request->input('num',20));
        // dd($res);
        $rs = DB::table('type')->where('type_pid','=','0')->select('type_name','type_id','type_pid')->get();
        // dd($res[0]);
        $rss = DB::table('type')->where('type_pid','!=','0')->select('type_name','type_id','type_pid')->get();
        // dd($rs);
        return view('admin/video/vod',
            ['title'=>'视频管理',
            'res'=>$res,
            'request'=>$request,
            'rs'=>$rs,
            'rss'=>$rss

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Respons
     */
    public function create()
    {
        //
        $rs = DB::table('type')->where('type_pid','=','0')->select('type_name','type_id','type_pid')->get();
        // dd($res[0]);
        $rss = DB::table('type')->where('type_pid','!=','0')->select('type_name','type_id','type_pid')->get();
        return view('admin/video/create',['title'=>'添加视频','rss'=>$rss,'rs'=>$rs]);
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
        if(Vod::create($res)){
            return redirect('admin/video')->with('success','添加成功');
        } else {
            return redirect()->with('error','添加失败');
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
        // $res = $_GET['val'];
        // if($res[0]=='开启'){
        //     $res[0]=0;
        // } else {
        //     $res[0]=1;
        // }
        // $res = ['vod_status'=> $res[0], 'vod_id' => $res[1]];
        //  $data = Vod::where('vod_id',$res['vod_id'])->update($res);
            
        // // dd($data);
        //  if($data){
        //     array_push($res, $data);
        //     return $res;
        //  } else {
        //     array_push($res, $data);
        //     return $res;
            
         // }

        // try{

           
        //     if($data){
        //         echo '111111111';
        //         
        //     }
        // }catch (\Exception $e){
        //     echo '2222222';
        //     return back()->with('error','修改失败');
        // }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

        $res = DB::table('vod')
        ->join('type','type.type_id','=','vod.type_id')
        ->where('vod.vod_id','=',$id)
        ->select('type.*','vod.vod_id','vod.vod_name','vod.vod_class','vod.vod_pic','vod.vod_actor','vod.vod_director','vod.vod_lang','vod.vod_serial','vod.type_id')
        ->get();
        $rs = DB::table('type')->where('type_pid','=','0')->select('*')->get();
        // dd($res[0]);
        $rss = DB::table('type')->where('type_pid','!=','0')->select('*')->get();
        return view('admin/video/edites',['title'=>'修改视频','res'=>$res, 'rs'=>$rs, 'rss'=>$rss]);
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
        $res = $request->input();
        unset($res['_token']);
        unset($res['_method']);
        // dd($res);
        try{
            $data = Vod::where('vod_id',$id)->update($res);

            if($data){
           
                return redirect('/admin/video')->with('success','修改成功');
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
        
            try{
                $data = Vod::where('vod_id',$id)->delete();
                if($data){
                    return redirect('/admin/video')->with('success','删除成功');
                }
            } catch(\Exception $e){
                return back()->with('error','删除失败');
            }
        
           
        
    }

   
   
}
