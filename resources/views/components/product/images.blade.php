@php($images = $getImages())
@if (count($images) > 0)
    <div>
        <div x-data="image"
             x-on:click="toggle"
             class="cursor-pointer">
            <img x-ref="thumbnail"
                 src="{{ route('product.image', ['code' => $images[0], 'width' => 280, 'height' => 280]) }}"
                 class="mx-auto"/>
            <div x-show="open">
                <div class="inset-0 absolute z-0 w-full h-full bg-gray-800 opacity-50"></div>
                <img x-ref="image"
                     x-on:click.away="toggle"
                     data-src="{{ route('product.image', ['code' => $images[0]]) }}"
                     class="z-20 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 h-3/4"/>
            </div>
        </div>

        <div class="flex space-x-2 mt-1">
            @foreach ($images as $index => $image)
                @if ($index == 0)
                    @continue
                @endif

                <div x-data="image"
                     x-on:click="toggle"
                     class="cursor-pointer">
                    <img x-ref="thumbnail"
                         src="{{ route('product.image', ['code' => $image, 'width' => 150, 'height' => 150]) }}"
                         class="mx-auto"/>
                    <div x-show="open">
                        <div class="inset-0 absolute z-0 w-full h-full bg-gray-800 opacity-50"></div>
                        <img x-ref="image"
                             x-on:click.away="toggle"
                             data-src="{{ route('product.image', ['code' => $image]) }}"
                             class="z-20 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 h-3/4"/>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
