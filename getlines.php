<?php

class GetLines {

//项目路径
    public $dirName = '';
//统计文件类型
    public $fileType = array();
//行数
    public $lines = 0;

    public function __construct($dirName, $fileType) {
        $this->dirName = $dirName;
        $this->fileType = $fileType;
        $this->traverseDir();
    }

//计算行数
    public function countLines($file) {
        $fileName = $this->fileExtend($file);
        if (in_array($fileName, $this->fileType)) {
            return count(file($file));
        }
    }

//获取文件扩展名
    public function fileExtend($file) {
        $extend = pathinfo($file);
        $extend = strtolower($extend["extension"]);
        return $extend;
    }

//递归遍历文件夹

    public function traverseDir($dir = FALSE) {
        $line = 0;
        if (FALSE == $dir) {
            $dir = $this->dirName;
        }
        $dir .= '/';
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if ($file != '.' && $file != '..') {
                    if (is_dir($dir . $file . '/')) {
                        $line += $this->traverseDir($dir . $file);
                    } else {
                        $line += $this->countLines($dir . $file);
                    }
                }
            }
            closedir($dh);
        }
        $this->lines = $line;
        return $this->lines;
    }

}

//初始化 取消时间限制
set_time_limit(0);

//路径名 后面不需加/
$lines = new GetLines('./xc', array('php', 'html'));
echo $lines->lines;
?>
