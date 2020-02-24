<?php
namespace Sheld\Contentbox;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ContentService{
    public function __construct()
    {
        if (!Cache::has('key')) {
            $extraDefines=Extra::all();

            $extraArr=[];
            foreach($extraDefines as $extraDefine)
            {
                $extraArr[$extraDefine->key]=$extraDefine;
            }
            Cache::store('file')->put('extraDefine', $extraArr, 60000);
        }
    }
    public function build($title,$belongto,$contentHtml,$formExtras)
    {
        $extras=[];
        $extraDefines=Cache::store('file')->get('extraDefine');
        foreach($formExtras as $formKey=>$formValue)
        {
            $extra_define=$extraDefines[$formKey];
            $extra=new Extra();
            $extra->id=$extra_define->id;
            $extra->name=$extra_define->name;
            $extra->key=$extra_define->key;
            $extra->extras=$extra_define->extras;
            $extra->value=$formValue;
            $extras[]=$extra;
        }

        $content=new Contentbox();
        $content->title=$title;
        $content->belongto=$belongto;
        $content->contentHtml=$contentHtml;
        $content->extras=json_encode($extras);
        $content->save();

    }

    public function exbuild($contentID){
        $content=Contentbox::findOrFail($contentID);
        //$content->extras=json_decode($content->extras);
        return $content;
    }

    public function listByBelongto($belongto,$nums=10,$page=1){
        $contents=Contentbox::where('belongto', $belongto)->offset(($page-1)*$nums)->limit($nums)->get();
        return $contents;
    }
}
