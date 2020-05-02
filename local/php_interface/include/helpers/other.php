<?php

namespace Classes\Helpers;

class Other
{
    /**
     * Возвращает форму слова в зависимости от числа
     *
     * @param $n
     * @param string $form1
     * @param string $form2
     * @param string $form5
     * @return string
     */
    public static function plural($n, $form1, $form2, $form5): string
    {
        $n = abs($n) % 100;
        $n1 = $n % 10;
        if ($n > 10 && $n < 20) {
            return $form5;
        }
        if ($n1 > 1 && $n1 < 5) {
            return $form2;
        }
        if ($n1 === 1) {
            return $form1;
        }

        return $form5;
    }

    /**
     * Вывод переменных на экран, оборачивает вывод в тег <pre></pre>
     *
     * @param $variable
     * @return void
     */
    public static function print($variable): void
    {
        $string = print_r($variable, true);
        echo "<pre>$string</pre>";
    }

}