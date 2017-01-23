<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 12.05.2016
 * Time: 17:38
 */
class Elex
{

//генератор паролей
    public function PassGen($max=10)
    {
        // Символы, которые будут использоваться в пароле.
        $chars="qazxswedcvfrtgbnhyujmkip23456789QAZXSWEDCVFRTGBNHYUJMKLP";
        // Количество символов в пароле.

        // Определяем количество символов в $chars
        $size=StrLen($chars)-1;

        // Определяем пустую переменную, в которую и будем записывать символы.
        $password=null;

        // Создаём пароль.
        while($max--)
            $password.=$chars[rand(0,$size)];

        // Выводим созданный пароль.
        return $password;
    }


    function rus2translit($string) {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 'c',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'C',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '_',  'Ы' => 'Y',   'Ъ' => '_',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',' ' => '_',
        );
        return strtr($string, $converter);
    }

    function encodestring($str) {
        // переводим в транслит
        $str = $this->rus2translit($str);
        // в нижний регистр
        $str = strtolower($str);
        // заменям все ненужное нам на "-"
        $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
        // удаляем начальные и конечные '-'
        $str = trim($str, "-");


        return $str;
    }



    /*выдает tmb картинки по имени*/
    public function GetImgTmb($image)
    {
        if($image!='')
        {
            $avatar = pathinfo($image);
            $avatar_name = basename($image,'.'.$avatar['extension']);
            $avatar_ext = $avatar['extension'];
            return $avatar_name."_thumb.".$avatar_ext;;
        }
        else
            return '';
    }

    /*удаляет из номера телефона лишние символы*/
    function regexPhone($phone)
    {
        return preg_replace('/[^0-9]/', '', $phone);
    }

    function ms_escape_string($data) {
        if ( !isset($data) or empty($data) ) return '';
        if ( is_numeric($data) ) return $data;

        $non_displayables = array(
            '/%0[0-8bcef]/',            // url encoded 00-08, 11, 12, 14, 15
            '/%1[0-9a-f]/',             // url encoded 16-31
            '/[\x00-\x08]/',            // 00-08
            '/\x0b/',                   // 11
            '/\x0c/',                   // 12
            '/[\x0e-\x1f]/'             // 14-31
        );
        foreach ( $non_displayables as $regex )
            $data = preg_replace( $regex, '', $data );
        $data = str_replace("'", "''", $data );
        return $data;
    }

    /*переформатирует mssql строки*/
    function result_array($query) {
        $res = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)){

            foreach ($row as $key=>$value) {
                $row[$key] = mb_convert_encoding($row[$key],"UTF-8","Windows-1251");
            }
            $res[] = $row;
        }
        return $res;
    }

     /*переформатирует mssql строку*/
    function row_array($query) {
        $row = $query->fetch(PDO::FETCH_ASSOC);

        if(!($row===false)) {
            foreach ($row as $key=>$value) {
                $row[$key] = mb_convert_encoding($row[$key],"UTF-8","Windows-1251");
            }
        }
        return $row;
    }

}