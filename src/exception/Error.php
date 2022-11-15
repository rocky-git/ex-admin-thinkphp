<?php


namespace ExAdmin\thinkphp\exception;


class Error
{
    /**
     * Error Handler
     * @access public
     * @param integer $errno   错误编号
     * @param string  $errstr  详细错误信息
     * @param string  $errfile 出错的文件
     * @param integer $errline 出错行号
     * @throws ErrorException
     */
    public function appError(int $errno, string $errstr, string $errfile = '', int $errline = 0): void
    {
        if(!$this->isDeprecation($errno)){
            app()->get(\think\initializer\Error::class)->appError($errno,$errstr,$errfile,$errline);
        }
    }
    protected function isDeprecation($level)
    {
        return in_array($level, [E_DEPRECATED, E_USER_DEPRECATED]);
    }
}