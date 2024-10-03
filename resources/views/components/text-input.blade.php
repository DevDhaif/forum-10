@props(['disabled' => false, 'placeholder' => ''])

<input
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge(['class' => 'text-lg font-bold border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm' . (app()->getLocale() == 'ar' ? ' text-right' : ' text-left'), 'placeholder' => $placeholder]) !!}
/>
