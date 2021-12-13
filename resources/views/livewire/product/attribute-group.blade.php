@if (count($akeneoAttributes) > 0)
<div class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200 my-4 lg:my-6" }}>
    <div class="px-4 py-5 sm:px-6">
        {{ $this->getHeader() }}
    </div>
    <dl class="">
        <div class="flex flex-col">
            @foreach ($akeneoAttributes as $attribute)
                @php($value = $this->getAttributeValue($attribute['code']))
            <div class="flex flex-row items-center odd:bg-gray-200 px-[25px] py-2">
                <dt class="w-1/4 text-sm font-medium text-gray-500 whitespace-nowrap">
                    {{ $this->getAttributeLabel($attribute['labels']) }}
                </dt>
                <dd class="w-3/4 mt-1 text-sm text-gray-900 sm:mt-0">
                    @if (is_string($value))
                        {{ $value }}
                    @elseif(is_array($value))
                        <ul>
                            @foreach ($value as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @endif
                </dd>

            </div>

            @endforeach
        </div>
    </dl>
</div>
@endif
