<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('plurilaze', [$this, 'plurilaze']),
        ];
    }

    public function doSomething($value)
    {
        // ...
    }
    public function plurilaze(int $count, string $singular, ?string $plural = null):string
    {
        // si un pluriel est indiqué je lui assign sinon j'assign le singulier avec un 's' en plus
        $plural = $plural ?? $singular . 's';//en php 7.4  $plural ??= $singular . 's';
        // si le count est égale ou inférieur à 1 j'assign à str le singulier sinon le pluriel
        $str = $count <= 1 ? $singular : $plural;

        return "$count $str";
    }
}
