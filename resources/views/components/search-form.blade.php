@props([
    'action',
    'placeholder',
    'name',
    'class',
    'id'
])
<form method="get" action="{{ $action }}">
    <input type="text"
    placeholder="{{ $placeholder ?? 'Search ...' }}"
    name="{{ $name ?? 'search' }}"
    value="{{ request()->input($name ?? 'search') }}"
    id="{{ $id ?? '' }}"
    class="{{ $class ?? '' }}"
    >
</form>
