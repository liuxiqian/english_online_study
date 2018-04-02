<?php
/**
 * Created by PhpStorm.
 * User: panjie
 * Date: 17/6/6
 * Time: 下午2:53
 * 被其实模型继承类
 */

namespace Home\Model;


use Org\Util\String;

class Model
{
    public $data = [];

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function getData($key = '')
    {
        $key = $this->unHump($key);
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        } else {
            return NULL;
        }

    }

    public function setData($keyOrData, $value = NULL)
    {
        if (is_array($keyOrData)) {
            if (array_key_exists('_class', $this->data)) {
                $class = $this->data['_class'];
                $this->data = $keyOrData;
                $this->data['_class'] = $class;
            } else {
                $this->data = $keyOrData;
            }
        } else if (is_string($keyOrData)) {
            $this->data[$this->unHump($keyOrData)] = $value;
        }

        return $this;
    }

    /**
     * 驼峰命名转下划线命名
     * @param String $camelCaps 驼峰命名
     * @param String $separator 分隔符号
     * @return String
     * 思路:
     * 小写和大写紧挨一起的地方,加上分隔符,然后全部转小写
     * @link  http://www.jianshu.com/p/773fd334052f
     */
    private function unHump($camelCaps, $separator = '_')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
    }

    public function __get($key)
    {
        $key = $this->unHump($key);
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        } else {
            return NULL;
        }
    }

    public function __set($name, $value)
    {
        $this->data[$this->unHump($name)] = $value;
    }

    public function __call($name, $arguments)
    {
        if (count($arguments) === 0) {
            $attrName = $this->getKeyByFromMethod($name, 'get');
            if (!empty($attrName) && array_key_exists($attrName, $this->data)) {
                return $this->data[$attrName];
            }
        } else if (count($arguments) === 1) {
            $attrName = $this->getKeyByFromMethod($name, 'set');
            if (!empty($attrName)) {
                $this->data[$attrName] = $arguments[0];
                return $this;
            }
        }

        return NULL;
    }

    private function getKeyByFromMethod($name, $method)
    {
        $count = strlen($method);
        if (strlen($name) > $count) {
            $methodPerString = substr($name, 0, $count);
            if ($methodPerString === $method) {
                return lcfirst($this->unHump(substr($name, $count)));
            }
        }

        return '';
    }

    /**
     * 下划线转驼峰
     * 思路:
     * step1.原字符串转小写,原字符串中的分隔符用空格替换,在字符串开头加上分隔符
     * step2.将字符串中每个单词的首字母转换为大写,再去空格,去字符串首部附加的分隔符.
     * @param $unHumpWord String 下划线命名
     * @param $separator String 分隔符号
     * @return string
     */
    private function hump($unHumpWord, $separator = '_')
    {
        $unHumpWord = $separator . str_replace($separator, " ", strtolower($unHumpWord));

        return ltrim(str_replace(" ", "", ucwords($unHumpWord)), $separator);
    }

    /**
     * @param $time
     * @return bool
     * Create by panjie@yunzhiclub.com
     * 是否是昨天或是昨天以前的日期
     */
    static public function isBeforeToday($time) {
        if (time() - $time > 24*60*60) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}