<?php

namespace Home\Model;
/**
 * 缓存
 */
class Cache
{
    //todo:取配置文件的配置信息
    static protected $keys = [];
    static protected $isInstance = FALSE;

    /**
     * 设置某个缓存中关键字为KEY的数组中的子项
     * @param $class 类名
     * @param $method 方法名
     * @param $key 关键字
     * @param $sonKey 子关键字
     * @param    mixed $value
     * @param    integer $expire 过期时间
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-12-30T16:23:59+0800
     * @return boolean
     */
    static public function setSon($class, $method, $key, $sonKey, $value, $expire = 1800)
    {
        $cacheKey = self::makeCacheKey($class, $method, $key);
        if (array_key_exists($cacheKey, self::$keys)) {
            self::instance();
            $items = self::get($class, $method, $key) ? self::get($class, $method, $key) : [];
            $items[$sonKey] = $value;
            self::set($class, $method, $key, $items, $expire);

            return TRUE;
        } else {
            return FALSE;
        }
    }   // 是否已经初始化

    private static function makeCacheKey($class, $method, $key)
    {
        return self::getConfig()['prefix'] . '_' . $class . '_' . $method . '_' . $key;
    }

    /**
     * 缓存初始化（只执行一次）
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-12-30T16:32:45+0800
     * @return boolean
     */
    static private function instance()
    {
        if (FALSE === self::$isInstance) {
            S(self::getConfig());
            self::$isInstance = TRUE;
        }

        return TRUE;
    }

    static protected function getConfig()
    {
        return
            [
                'type'    => 'redis',
                'host'    => C('REDIS_HOST') ?: '127.0.0.1',
                'port'    => C('REDIS_PORT') ?: 6379,
                'timeout' => C('DATA_CACHE_TIMEOUT') ?: FALSE,
                'auth'    => C('REDIS_AUTH_PASSWORD') ? C('REDIS_AUTH_PASSWORD') : NULL,//auth认证的密码
                'prefix'  => C('DATA_CACHE_PREFIX') ? C('DATA_CACHE_PREFIX') : ''
            ];
    }

    /**
     * 获取key关键字的值
     * @param $class 类名
     * @param $method 方法名
     * @param 关键字|string $key 关键字
     * @return bool
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-12-30T16:27:17+0800
     */
    static public function get($class, $method, $key = '')
    {
        self::instance();
        $cacheKey = self::makeCacheKey($class, $method, $key);

        return self::deSerialize(S($cacheKey));
    }

    /**
     * @param $data
     * @return mixed
     * Create by panjie@yunzhiclub.com
     * 对数据进行反序列化
     * php进行序化时，只将公共的数据取出，并做为数组存储。
     * 此时，我们利用在返回数组中的data项中的_class属性来确定些数据来自于哪个类
     * 在根据该类名称，进行实例化，并进行赋值。
     * 同时，考虑到了存在深度大于1的数组，在进行反序列化的过程中，进行递归操作。
     * 并判断返回的数据是否符合序列化为对象的条件.
     */
    static public function deSerialize($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => &$value) {
                $value = self::deSerialize($value);
            }
            if (array_key_exists('data', $data)) {
                if (array_key_exists('_class', $data['data'])) {
                    $class = $data['data']['_class'];
                    $data = new $class($data['data']);
                }
            }
        }

        return $data;
    }

    /**
     * 设置key关键字的值为value
     * @param $key 关键字
     * @param $class 类名
     * @param $method 方法名
     * @param $value 值
     * @param    integer $expire 过期时间
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-12-30T16:26:46+0800
     */
    static public function set($class, $method, $key, $value, $expire = 1800)
    {
        self::instance();
        $cacheKey = self::makeCacheKey($class, $method, $key);
        S($cacheKey, $value, $expire);
    }

    /**
     * 获取缓存中，某个关键字为KEY的数组的子项
     * @param $class 类名
     * @param $method 方法名
     * @param $key 关键字
     * @param    string $sonKey 子项关键字
     * @return   mixed
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-12-30T16:25:15+0800
     */
    static public function getSon($class, $method, $key, $sonKey)
    {
        $cacheKey = self::makeCacheKey($class, $method, $key);
        if (array_key_exists($cacheKey, self::$keys)) {
            self::instance();
            $items = self::get($class, $method, $key);
            if (array_key_exists($sonKey, $items)) {
                return $items[$sonKey];
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * 清除缓存中，某个关键字为KEY的数组中的某个子项，并重新缓存（重新记录时间）
     * @param    string $key
     * @param    string $sonKey 子项关键字
     * @return   mixed
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-12-30T16:25:50+0800
     */
    static public function cleanSon($key, $sonKey)
    {
        if (array_key_exists($key, self::$keys)) {
            self::instance();
            $items = S($key);
            if (array_key_exists($sonKey, $items)) {
                unset($items[$sonKey]);
                S($key, $items);

                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * 清除某个关键字的缓存
     * @param    string $key
     * @return boolean
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-12-30T16:32:32+0800
     */
    static public function clean($key = NULL)
    {
        // 如果未传入$key，则清除所有缓存
        if (NULL === $key) {
            foreach (self::$keys as $key => $value) {
                self::clean($key);
            }

            // 指定清楚$key的缓存
        } else {
            if (array_key_exists($key, self::$keys)) {
                self::instance();

                return S($key, NULL);
            } else {
                return FALSE;
            }
        }

        return TRUE;
    }
}