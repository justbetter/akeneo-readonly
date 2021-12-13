<div>
    <div class="bg-white overflow-hidden shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6 grid grid-cols-3">
            <div>
                <x-product.images :product="$product"/>
            </div>
            <div class="col-span-2">
                <h1 class="text-3xl">{{ $this->getTitle() }}</h1>
                <p class="prose lg:prose-xl">
                    {{ $this->getDescription() }}
                </p>
            </div>
        </div>
    </div>
</div>
