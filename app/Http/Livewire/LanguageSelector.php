<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use JustBetter\AkeneoClient\Client\Akeneo;
use Livewire\Component;

class LanguageSelector extends Component
{
    public function render(): View
    {
        return view('livewire.language-selector');
    }

    public function getLanguages(): array
    {
        return Cache::rememberForever('locales',
            function () {
                /** @var Akeneo $akeneo */
                $akeneo = app(Akeneo::class);
                return $akeneo->getChannelApi()->get(config('app.channel'))['locales'];
            }
        );
    }

    public function setLocale(string $locale): void
    {
        auth()->user()->update(['preferred_locale' => $locale]);

        $this->emit('update-locale');
    }

    public function isSelected(string $locale): bool
    {
        return auth()->user()->preferred_locale === $locale;
    }
}
