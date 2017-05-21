<?php
/**
 * Created by PhpStorm.
 * User: PARTH
 * Date: 6/19/14
 * Time: 8:17 AM
 */

class RecordingD {
    public $creator_id;
    public $recording_id;

    public $recordingDirPath;


    public function  __construct($creator_id, $recording_id){
        $this->creator_id = $creator_id;
        $this->recording_id = $recording_id;
        
        $this->recordingDirPath = dirname(dirname(dirname(__FILE__)))."\\recordingdata\\";
    }


    function SaveDrawData($dataJson){
        return $this->OverwriteFile("drawdata.json", $dataJson);
    }

    function GetDrawData(){
        return $this->GetFileContent("drawdata.json");
    }

    function SaveChatData($dataJson){
        return $this->OverwriteFile("chatdata.json", $dataJson);
    }

    function GetChatData(){
        return $this->GetFileContent("chatdata.json");
    }

    function SaveFilesData($dataJson){
        return $this->OverwriteFile("filesdata.json", $dataJson);
    }

    function GetFilesData(){
        return $this->GetFileContent("filesdata.json");
    }

    function OverwriteFile($filename, $dataJson){
        $this->CheckRecordingDir();
        return file_put_contents($this->GetRecordingDirPath()."\\".$filename, $dataJson);
    }

    function GetFileContent($filename){
        if(!$this->HasRecordingDir()){
            return null;
        }

        return file_get_contents($this->GetRecordingDirPath()."\\".$filename);
    }

    function GetCreatorDirPath(){
        return $this->recordingDirPath.$this->creator_id;
    }
    function CheckCreatorDir(){
        if(!$this->HasCreatorDir()){
            $this->MakeCreatorDir();
        }
    }
    function HasCreatorDir(){
        return $this->HasDir($this->GetCreatorDirPath());
    }
    function MakeCreatorDir(){
        return $this->MakeDir($this->recordingDirPath, $this->creator_id);
    }

    public function GetRecordingDirPath(){
        return $this->recordingDirPath.$this->creator_id."\\".$this->recording_id;
    }
    function CheckRecordingDir(){
        $this->CheckCreatorDir();
        if(!$this->HasRecordingDir()){
            $this->MakeRecordingDir();
        }
    }
    function HasRecordingDir(){
        return $this->HasDir($this->GetRecordingDirPath());
    }
    function MakeRecordingDir(){
        return $this->MakeDir($this->GetCreatorDirPath(), $this->recording_id);
    }
    
    
    
    public function SaveImage($image_tmp_path, $imagename){
        $this->CheckImageDir();
        $path = $this->GetImageDirPath();
        return move_uploaded_file($image_tmp_path, $path."//".$imagename);
    }
    function GetImageDirPath(){
        return $this->GetRecordingDirPath()."\\images";
    }
    function CheckImageDir(){
        if(!$this->HasImageDir()){
            $this->MakeImageDir();
        }
    }
    function HasImageDir(){
        return $this->HasDir($this->GetImageDirPath());
    }
    function MakeImageDir(){
        return $this->MakeDir($this->GetRecordingDirPath(), "images");
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

    function HasDir($dirpath){
        return file_exists($dirpath);
    }
    function MakeDir($dirpath, $dirname){
        return mkdir($dirpath."\\".$dirname);
    }

    function GetMetaData(){
        $metadata = new stdClass();
        $metadata->startTime = "1405361591100";
        $metadata->endTime = "1405361713800";
        return $metadata;
    }
} 