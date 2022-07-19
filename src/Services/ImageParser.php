<?php

namespace App\Services;

use JetBrains\PhpStorm\ArrayShape;

class ImageParser
{
    #[ArrayShape(['data' => "string[]", 'totalCount' => "int", 'totalSizeMb' => "int"])]
    public function execute(string $url): array
    {



        return [
          'data' => [
              'https://media.istockphoto.com/id/525212514/uk/%D0%B2%D0%B5%D0%BA%D1%82%D0%BE%D1%80%D0%BD%D1%96-%D0%B7%D0%BE%D0%B1%D1%80%D0%B0%D0%B6%D0%B5%D0%BD%D0%BD%D1%8F/%D0%B3%D0%BB%D0%BE%D0%B1%D0%B0%D0%BB%D1%8C%D0%BD%D0%B8%D0%B9-%D0%B7%D0%B2%D1%8F%D0%B7%D0%BE%D0%BA-%D1%84%D0%BE%D0%BD.webp?s=612x612&w=is&k=20&c=Y6FyCd0Jkkt-tTV4pU3I8XLkIClHQF2GoYnxKK7OrEk='
          ],
          'totalCount' => 13,
          'totalSizeMb'  => 11
        ];
    }

//    private
}