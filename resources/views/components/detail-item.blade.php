@props([
    'label',
    'value' => null,
    'icon' => null,
    'class' => '',
    'labelClass' => '',
    'valueClass' => ''
])

<div class="flex items-start py-2 {{ $class }}">
    @if($icon)
        <div class="flex-shrink-0 mr-3 mt-1 text-gray-500 dark:text-gray-400">
            {!! $icon !!}
        </div>
    @endif
    <div class="flex-1">
        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 {{ $labelClass }}">
            {{ $label }}
        </dt>
        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 font-medium {{ $valueClass }}">
            {{ $value ?? '-' }}
        </dd>
    </div>
</div>
