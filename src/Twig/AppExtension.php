<?php
declare(strict_types=1);

namespace App\Twig;


use App\Utils\Markdown;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    private $markdown;

    public function __construct(Markdown $markdown)
    {
        $this->markdown = $markdown;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('md2html', [$this->markdown, 'toHtml'], ['is_safe' => ['html']])
        ];
    }
}