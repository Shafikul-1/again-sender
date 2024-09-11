{{-- resources/views/components/form.blade.php --}}
@props([
    'submit' => '',              // Submit button text or content
    'action',              // Form action URL
    'method' => 'POST',    // Form method
    'fields' => [],        // Form fields
    'formHeading' => '',   // Form heading (optional)
    'additionalContent' => '',   // Form heading (optional)
])

<form action="{{ $action }}" method="{{ strtoupper($method) === 'GET' ? 'GET' : 'POST' }}" {{ $attributes }}>
    @csrf
    @if (!in_array(strtoupper($method), ['GET', 'POST']))
        @method($method)
    @endif

    @if ($formHeading)
        {!! $formHeading !!}
    @endif

    @foreach ($fields as $field)
        <div {{ new \Illuminate\View\ComponentAttributeBag($field['wrapper'] ?? []) }}>
            @isset($field['label'])
                @if ($field['type'] !== 'hidden')
                    <label for="{{ $field['id'] ?? '' }}" {{ new \Illuminate\View\ComponentAttributeBag($field['label']['attributes'] ?? []) }}>
                        {{ $field['label']['name'] }}
                    </label>
                @endif
            @endisset

            <input
                type="{{ $field['type'] ?? 'text' }}"
                name="{{ $field['name'] ?? '' }}"
                id="{{ $field['id'] ?? '' }}"
                placeholder="{{ $field['placeholder'] ?? '' }}"
                value="{{ old($field['name'], $field['value'] ?? '') }}"
                {{-- Safely merge attributes array --}}
                {{ new \Illuminate\View\ComponentAttributeBag($field['attributes'] ?? []) }} />

                @isset($field['additionalContent'])
                    {!! $field['additionalContent']  !!}
                @endisset

            {{-- Error message --}}
            @error($field['name'])
                <p class="text-red-600 {{ $field['errorClass'] ?? '' }}" >{{ $message }}</p>
            @enderror

        </div>
    @endforeach

    {{-- Optional slot for additional content --}}
    {{ $slot }}

    {{-- Submit button --}}
    @if ($submit)
        <button type="submit" {{ new \Illuminate\View\ComponentAttributeBag($submit['attributes'] ?? []) }}>
            {{ $submit['text'] ?? 'Submit' }}
        </button>
    @endif
</form>
