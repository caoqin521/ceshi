<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class VideosController extends Controller
{
    //
    public function upload(Request $request, $id)
    {
        // dump($request->file('file'));
        
        
        // dd($id);
        $pic = $request->file('file');
        if(!$pic==null){
        $name=$pic->getClientOriginalName();//得到图片名；
        $ext=$pic->getClientOriginalExtension();//得到图片后缀；
        $fileName=md5(uniqid($name)).mt_rand(1000,9999).time();
        $fileName=$fileName.'.'.$ext;//生成新的的文件名
        if($pic->move('uploads/videoimg',$fileName)){
            $code = 1;
            $msg = "图片上传成功";
        }else{
            $code = 0;
            $msg = "图片上传失败";
        }
        $pics = ['code'=>$code,'msg'=>$msg,'path'=>'/uploads/videoimg/'.$fileName];
        if(DB::table('vod')->where('vod_id', $id)->update(['vod_pic'=>$pics['path']])){
            return redirect('admin/video/vod')->with('success','修改成功');
        } else {
            return redirect()->with('error','修改失败');
        }
    }
}
    public function fenlei(Request $request, $id)
    {   
        // dd($id);
        // dump($request->get());
        // echo ;111
        // echo '11111';
        // $id = $request->all('vals')['vals'];
        $res = DB::table('vod')
        ->join('type','type.type_id','=','vod.type_id')
        ->where('vod.type_id','=',$id)
        ->select('type.type_name','vod.vod_name','vod.vod_id','vod.vod_pic','vod.vod_class','vod.vod_status','vod.vod_actor','vod.vod_director','vod.vod_lang','vod.vod_serial')
        ->orderby('vod.vod_id','desc')->paginate($request->input('num',20));
        // dd($res);
        $rs = DB::table('type')->where('type_pid','=','0')->select('type_name','type_id','type_pid')->get();
        // dd($res[0]);
        $rss = DB::table('type')->where('type_pid','!=','0')->select('type_name','type_id','type_pid')->get();
        return view('admin/video/vod',
            ['title'=>'视频管理',
            'res'=>$res,
            'request'=>$request,
            'rs'=>$rs,
            'rss'=>$rss

        ]);
        
        // return ['res'=>$res, 'rs'=>$rs, 'rss'=>$rss];
        // $res = DB::table('vod')
        // ->join('type','type.type_id','=','vod.type_id')
        // ->where('vod','vod.type_id','=',$id)
        // ->select('type.type_name','vod.vod_name','vod.vod_id','vod.vod_pic','vod.vod_class','vod.vod_status','vod.vod_actor','vod.vod_director','vod.vod_lang','vod.vod_serial')
        // ->orderby('vod.vod_id','desc')->paginate($request->input('num',20));
    }

    public function sousuo(Request $request)
    {
        $res = DB::table('vod')
        ->join('type','type.type_id','=','vod.type_id')
        ->where('vod.vod_name','like','%'.$request->post()['vod_name'].'%')
        ->select('type.type_name','vod.vod_name','vod.vod_id','vod.vod_pic','vod.vod_class','vod.vod_status','vod.vod_actor','vod.vod_director','vod.vod_lang','vod.vod_serial')
        ->orderby('vod.vod_id','desc')->paginate($request->input('num',20));
        // dd($res);
        $rs = DB::table('type')->where('type_pid','=','0')->select('type_name','type_id','type_pid')->get();
        // dd($res[0]);
        $rss = DB::table('type')->where('type_pid','!=','0')->select('type_name','type_id','type_pid')->get();
        return view('admin/video/vod',
            ['title'=>'视频管理',
            'res'=>$res,
            'request'=>$request,
            'rs'=>$rs,
            'rss'=>$rss

        ]);
    }
}
