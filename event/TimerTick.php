<?php

namespace Event;

class TimerTick
{
    const FILE_PATH = '../data';            // 存放上传文件的为止
    const CLEAR_FILE_TIME = 3000;            // 多久检查一次是否有需要删除的文件，单位毫秒ms
    const CLEAR_DISTANT_FILE_TIME = 60;      // 删除创建多久的文件，单位秒s

    public function clearFile($time_id)
    {
        $folders = $this->listFolder(self::FILE_PATH);
        if (! empty($folders)) {
            foreach ($folders as $v) {
                $files = $this->listFolder($v);
                if (! empty($files)) {
                    foreach ($files as $f) {
                        $createTime = filectime($f);
                        if ($createTime !== false && time() - $createTime > self::CLEAR_DISTANT_FILE_TIME) {
                            @unlink($f);
                        }
                    }
                } else {
                    @rmdir($v);
                }
            }
        }
    }



    public function listFolder($path)
    {
        $list = [];
        $path = rtrim($path, '/');
        if(is_dir($path)) {
            if ($dh = opendir($path)) {
                while (($file = readdir($dh)) !== false) {
                    if($file !== "." && $file !== "..") {
                        array_push($list, $path . '/' . $file);
                    }
                }
                closedir($dh);
            }
        }

        return array_filter($list);
    }
}





?>