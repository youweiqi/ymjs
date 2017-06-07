<?php
namespace common\components;

/**
 * 密码加密算法
 * 对不同类型密码采用不同的加密算法进行加密处理
 */
class Password
{
    /**
     * 密码盐
     * @var int
     */
    private static $_satls = 'rnibr5nnk422ucv2';

    /**
     * 盐在密文中的偏移值
     * @var int
     */
    private static $_offset = 8;

    /**
     * 加密算法名称
     * @var string
     */
    private static $_passwordType= 'sha256';

    /**
     * 加密字符串
     * @param string $password 需要进行加密的字符串
     * @return string          密文
     */
    public static function createPassword($password)
    {
        $password     = hash( static::$_passwordType, $password.self::$_satls );
        $password     = md5( $password );
        $newPassword  = substr( $password, 0, self::$_offset );
        $newPassword .= strtolower( self::$_satls ) . substr( $password, self::$_offset );
        return substr( $newPassword, 0, 32 );
    }

    /**
     * 验证密码是否正确
     * @param string $securtyString 密钥
     * @param string $password      密码
     * @return boolean
     */
    public static function checkPassword( $securtyString, $password )
    {
        $password = self::createPassword( $password);
        return $securtyString == $password;
    }
}