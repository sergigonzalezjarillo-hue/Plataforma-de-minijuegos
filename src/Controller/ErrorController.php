<?php
declare(strict_types=1);

class ErrorController
{
    public function error404(): void
    {
        http_response_code(404);
        Pages::render('404');
    }

    public function error500(): void
    {
        http_response_code(500);
        Pages::render('500');
    }
}
