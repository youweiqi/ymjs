<?php
namespace api\models\forms;
use common\models\ApiUsers;
use Yii;
use yii\base\Model;

use yii\web\IdentityInterface;
use yii\web\NotFoundHttpException;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    //public $rememberMe = true;

    private $_user;

    const GET_API_TOKEN = 'generate_api_token';

    public function init ()
    {
        parent::init();
        $this->on(self::GET_API_TOKEN, [$this, 'onGenerateApiToken']);
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
            //'rememberMe' => '记住我',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
           // ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $this->_user = $this->getUser();
            if (!$this->_user || !$this->_user->validatePassword($this->password)) {
                $this->addError($attribute, '用户名或者密码错误.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *如果rule 规则验证通过 我返回登录的user 的对象
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        $a =1;
        if ($this->validate()) {
            $this->trigger(self::GET_API_TOKEN);
            return $this->_user;
        } else {
            return null;
        }
    }
    /**
     * 根据用户名获取用户的认证信息
     *
     * @return $this->_user|null
     * 返回的是个私有的$this_user 对象
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = ApiUsers::findByUsername($this->username);
        }

        return $this->_user;
    }


    /**
     * 登录校验成功后，为用户生成新的token
     * 如果token失效，则重新生成token
     */
    public function onGenerateApiToken ()
    {
        if (!ApiUsers::apiTokenIsValid($this->_user->api_token)) {
            $this->_user->generateApiToken();
            $this->_user->save(false);
        }
    }

    public function afterValidate ()
    {
        if ($this->hasErrors()) {
            $errors = $this->errors;
            $errors = current($errors);
            throw new NotFoundHttpException($errors[0], 1);
        }
        return true;
    }
}
