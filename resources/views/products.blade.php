<x-app-layout>
    <x-slot name="header">
        <livewire:language-selector/>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 overflow-y-scroll">
            <livewire:product-table/>
        </div>
    </div>
</x-app-layout>
