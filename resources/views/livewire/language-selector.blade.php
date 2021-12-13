<div class="w-full flex gap-x-4">
    @foreach ($this->getLanguages() as $language)
        <span
            id="language-{{ $language }}"
            class="cursor-pointer transition-all duration-100 @if (!$this->isSelected($language)) opacity-50 @else language-{{ $language }}-active @endif"
            wire:click="setLocale('{{ $language }}')"
        >
            {{ flag(strtolower(explode('_', $language)[1]), 'w-12') }}
        </span>
    @endforeach
</div>
