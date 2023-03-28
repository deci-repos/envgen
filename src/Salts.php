<?php

namespace Sanket\Envgenerator;

class Salts
{
    /**
     * Generate and return all the WordPress salts as an array.
     *
     * @return array
     */
    public function wordPressSalts(): array
    {
        $salts['AUTH_KEY'] = $this->generateRandomString();
        self::changeEnvironmentVariable('/generateme/', $salts['AUTH_KEY']);
        $salts['SECURE_AUTH_KEY'] = $this->generateRandomString();
        self::changeEnvironmentVariable('/generateme/', $salts['SECURE_AUTH_KEY']);

        $salts['LOGGED_IN_KEY'] = $this->generateRandomString();
        self::changeEnvironmentVariable('/generateme/', $salts['LOGGED_IN_KEY']);

        $salts['NONCE_KEY'] = $this->generateRandomString();
        self::changeEnvironmentVariable('/generateme/', $salts['NONCE_KEY']);

        $salts['AUTH_SALT'] = $this->generateRandomString();
        self::changeEnvironmentVariable('/generateme/', $salts['AUTH_SALT']);

        $salts['SECURE_AUTH_SALT'] = $this->generateRandomString();
        self::changeEnvironmentVariable('/generateme/', $salts['SECURE_AUTH_SALT']);

        $salts['LOGGED_IN_SALT'] = $this->generateRandomString();
        self::changeEnvironmentVariable('/generateme/', $salts['LOGGED_IN_SALT']);

        $salts['NONCE_SALT'] = $this->generateRandomString();
        self::changeEnvironmentVariable('/generateme/', $salts['NONCE_SALT']);


        return $salts;
    }
    public function dotEnv($dbname, $dbuser,$dbhost,$dbpassword,$wp_env,$wp_home,$wp_siteurl)
    {
        $keys = get_defined_vars();
        $salts = $this->wordPressSalts();

//        foreach ($keys as $key) {
//            if(is_bool($_ENV($key)))
//            {
//                $old = $_ENV($key)? 'true' : 'false';
//            }
//
//            if (file_exists($path)) {
//                file_put_contents($path, str_replace(
//                    "$key=".$old, "$key=".$$key, file_get_contents($path)
//                ));
//            }
//        }

       self::changeEnvironmentVariable('/database_name/', $dbname);
       self::changeEnvironmentVariable('/database_password/', $dbpassword);
       self::changeEnvironmentVariable('/database_user/', $dbuser);
       self::changeEnvironmentVariable('/localhost/', $dbhost);
       self::changeEnvironmentVariable('/# DB_HOST/', 'DB_HOST');

//        file_put_contents('.env', str_replace('database_name',$dbname, $path));
//        file_put_contents('.env', str_replace('database_name',$dbname, $path));
    }

    function generateRandomString($length = 64) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-+_{}<>/;', ceil($length/strlen($x)) )),1,$length);
    }

    public static function changeEnvironmentVariable($key,$value)
    {
        if(!file_exists(__DIR__.'/../../../../.env')) {
            echo '.env not found';
            die();
        }
        $path = file_get_contents(__DIR__.'/../../../../.env');
        $count = 1;
        file_put_contents('.env', preg_replace($key,$value, $path, $count));
    }
}