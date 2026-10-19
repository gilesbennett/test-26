<?php

namespace App\View\Composers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ThemeComposer
{
    private const array THEMES = ['corporate', 'dark'];

    public function __construct(private Request $request) {}

    public function compose(View $view): void
    {
        $theme = $this->request->cookie('theme');

        $view->with('theme', in_array($theme, self::THEMES, true) ? $theme : null);
    }
}
