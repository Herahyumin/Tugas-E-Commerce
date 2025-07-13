@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 bg-white text-gray-900 focus:border-purple-600 focus:ring-purple-600 rounded-md shadow-sm placeholder-gray-500']) !!}>