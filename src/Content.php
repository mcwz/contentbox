<?php
namespace  Sheld\Contentbox;

use Illuminate\Support\Facades\DB;

class Content{
    private $title;
    private $belongto;
    private $contentHtml;
    private $extras;
    private $id;
    private $errCode=0;

    public function __construct()
    {
        $args= func_get_args();
        $argsNum=count($args);
        if($argsNum==1)
        {
            call_user_func_array([$this,'__constructLoad'],$args);
        }
        else
        {
            call_user_func_array([$this,'__constructNew'],$args);
        }
    }

    public function __constructNew($title,$belongto,$contentHtml,$extra,$id=0)
    {

        $this->title=$title;
        $this->belongto=$belongto;
        $this->contentHtml=$contentHtml;
        $this->extras=json_encode($extra);
        $this->id=$id;
    }

    public function __constructLoad($id)
    {
        $content=DB::table('contentbox')->where('id', $id)->first();
        if($content)
        {
            $this->title=$content->title;
            $this->id=$content->id;
            $this->belongto=$content->belongto;
            $this->contentHtml=$content->contentHtml;
            $this->extras=$content->extras;
        }
        else
        {
            $this->errCode=1;
        }
    }

    public function __set($key,$value)
    {
        $doNotUpdate=['id'];
        if(in_array($key,$doNotUpdate))
        {
            return ;
        }
        $this->$key=$value;
    }

    public function __get($key)
    {
        $doNotRead=['errCode'];
        if(in_array($key,$doNotRead))
        {
            throw new \Exception($key." can't read.");
        }
        return $this->$key;
    }

    public function persistence()
    {
        if($this->id==0){
            DB::table('contentbox')->insert(
                ['title' => $this->title, 'belongto' => $this->belongto,'contentHtml'=>$this->contentHtml,'extras'=>$this->extras]
            );
        }
        else
        {
            DB::table('contentbox')->where('id', $this->id)->update(
                ['title' => $this->title, 'belongto' => $this->belongto,'contentHtml'=>$this->contentHtml,'extras'=>$this->extras]
            );
        }
    }
}
