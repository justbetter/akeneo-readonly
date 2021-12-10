@php($images = $getImages())
@if (count($images) > 0)

    <div>
        <a x-data="{ open: false}" @click="open = true" class="cursor-pointer">

            <img @click="open = true" src="{{ $images[0]['thumb'] }}" class="mx-auto"/>

            <div x-show="open">
                <div class="inset-0 absolute z-0 w-full h-full bg-gray-800 opacity-50"></div>
                <img @click.away="open = false" src="{{ $images[0]['full'] }}"
                     class="z-20 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 h-3/4"/>
            </div>
        </a>

        <div class="flex space-x-2 mt-1">
            @foreach ($images as $index => $image)
                @if ($index == 0)
                    @continue
                @endif

                <a x-data="{ open: false}" @click="open = true">

                    <img @click="open = true" src="{{ $image['thumb'] }}" class="mx-auto"/>

                    <div x-show="open">
                        <div class="inset-0 absolute z-0 w-full h-full bg-gray-800 opacity-50"></div>
                        <img @click.away="open = false" src="{{ $image['full'] }}"
                             class="z-20 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 h-3/4"/>
                    </div>
                </a>

            @endforeach
        </div>
    </div>
@endif
