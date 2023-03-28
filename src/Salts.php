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
        self::changeEnvironmentVariable('/development/', $wp_env);
        self::changeEnvironmentVariable('/http:\/\/example\.com/', $wp_home);
        self::changeEnvironmentVariable('/\${WP_HOME}\/wp/', $wp_siteurl);

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

    function copyfolder ($from, $to, $ext="*") {
        // (A1) SOURCE FOLDER CHECK
        if (!is_dir($from)) { exit("$from does not exist"); }

        // (A2) CREATE DESTINATION FOLDER
        if (!is_dir($to)) {
            if (!mkdir($to)) { exit("Failed to create $to"); };
            echo "$to created\r\n";
        }

        // (A3) GET ALL FILES + FOLDERS IN SOURCE
        $all = glob("$from$ext", GLOB_MARK);
        print_r($all);

        // (A4) COPY FILES + RECURSIVE INTERNAL FOLDERS
        if (count($all)>0) { foreach ($all as $a) {
            $ff = basename($a); // CURRENT FILE/FOLDER
            if (is_dir($a)) {
                $this->copyfolder("$from$ff/", "$to/$ff/");
            } else {
                if (!copy($a, "$to$ff")) { exit("Error copying $a to $to$ff"); }
                echo "$a copied to $to$ff\r\n";
            }
        }}
    }
}