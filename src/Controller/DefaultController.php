<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
   
    public function number($max = 9)
    {
        $number = random_int(0, $max);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }


    public function dynamic($max = 9)
    {
        $number = random_int(0, $max);

        return new Response(
            '<html><body>Lucky number: '.$number. $max .'</body></html>'
        );
    }

    public function showDynamic()
    {
        return new Response(
            '<html><body>Dynamic2</body></html>'
        );
    }
}
