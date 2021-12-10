<x-app-layout>
    <x-slot name="header">
        <livewire:language-selector/>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <livewire:product.header :product="$product"/>

            @foreach ($product->getAttributeGroups() as $code => $labels)

                <livewire:product.attribute-group :product="$product" :group="$code" :labels="$labels"/>

            @endforeach

        </div>
    </div>
</x-app-layout>
