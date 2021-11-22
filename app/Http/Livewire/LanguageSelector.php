<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Cache;
use JustBetter\Akeneo\Models\Channel;
use Livewire\Component;

class LanguageSelector extends Component
{
    public function render()
    {
        return view('livewire.language-selector');
    }

    public function getLanguages(): array
    {
        return Cache::rememberForever('locales',
            fn() => Channel::find(config('app.channel'))['locales']
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
