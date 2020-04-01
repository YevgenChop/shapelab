<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\DomCrawler\Crawler;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $amountMovies = 1000;
        $start = 1;
        $step = 50;

        $moviesArray = [];

        do {
            $link = "https://www.imdb.com/search/title/?groups=top_$amountMovies&start=$start";
            $html = file_get_contents($link);

            $crawler = new Crawler($html);

            $titles = $crawler
                ->filter('h3.lister-item-header')
                ->each(function ($elem) {
                    return $elem->text();
                });

            array_push($moviesArray, $titles);

            $start += $step;
        } while ($start < ($amountMovies + 1));

        dd(...$moviesArray);
    }
}
