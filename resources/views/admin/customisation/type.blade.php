@vite('resources/css/admin-customisation.css')

<x-admin-layout title="Manage Customisation">

    <div class="customisation-page">

        {{-- Back Navigation --}}
        <a href="{{ route('admin.customisation.index') }}"
           class="customisation-back">
            &larr; Back to Customisation
        </a>

        <span class="eyebrow">RoSys . Administrator</span>

        {{-- Page Heading --}}
        <div class="customisation-heading-row">
            <div>
                <h1 class="page-title">
                    @switch($optionType)
                        @case('wrapping')
                            Wrapping
                            @break

                        @case('ribbon')
                            Ribbon
                            @break

                        @case('theme_colour')
                            Theme Colour
                            @break

                        @case('bouquet_style')
                            Bouquet Style
                            @break
                    @endswitch
                </h1>

                <p class="page-lead">
                    Manage your items, prices, availability and details.
                </p>
            </div>

            <button
                type="button"
                class="customisation-add-button"
                data-bs-toggle="modal"
                data-bs-target="#createCustomisationModal"
            >
                + Add Item
            </button>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="customisation-alert">
                {{ session('success') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="customisation-error">
                <strong>Please check the following:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Customisation Items Table --}}
        <div class="customisation-table-wrapper">
            <table class="customisation-table">

                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Item Details</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Availability</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($options as $option)

                        <tr>
                            {{-- Image --}}
                            <td>
                                @if ($option->image)
                                    <img
                                        src="{{ asset('storage/' . $option->image) }}"
                                        alt="{{ $option->option_name }}"
                                        class="customisation-item-image"
                                    >
                                @else
                                    <div class="customisation-no-image">
                                        No image
                                    </div>
                                @endif
                            </td>

                            {{-- Item Details --}}
                            <td>
                                <strong>
                                    {{ $option->option_name }}
                                </strong>

                                @if ($option->description)
                                    <p class="customisation-item-description">
                                        {{ $option->description }}
                                    </p>
                                @endif
                            </td>

                            {{-- Price --}}
                            <td>
                                RM {{ number_format((float) $option->price, 2) }}
                            </td>

                            {{-- Stock --}}
                            <td>
                                @if (in_array($optionType, ['wrapping', 'ribbon'], true))
                                    {{ $option->stock_quantity }}
                                @else
                                    <span class="customisation-muted">
                                        Not applicable
                                    </span>
                                @endif
                            </td>

                            {{-- Availability --}}
                            <td>
                                @if ($option->availability)
                                    <span class="customisation-status available">
                                        Available
                                    </span>
                                @else
                                    <span class="customisation-status unavailable">
                                        Unavailable
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td>
                                <div class="customisation-actions">

                                    <button
                                        type="button"
                                        class="customisation-edit-button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editCustomisationModal{{ $option->option_id }}"
                                    >
                                        Edit
                                    </button>

                                    <button
                                        type="button"
                                        class="customisation-delete-button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteCustomisationModal{{ $option->option_id }}"
                                    >
                                        Delete
                                    </button>

                                </div>
                            </td>
                        </tr>

                        {{-- Edit Modal Component --}}
                        @include(
                            'components.admin.customisation.edit',
                            [
                                'option' => $option,
                                'optionType' => $optionType
                            ]
                        )

                        {{-- Delete Modal Component --}}
                        @include(
                            'components.admin.customisation.delete',
                            [
                                'option' => $option,
                                'optionType' => $optionType
                            ]
                        )

                    @empty

                        <tr>
                            <td colspan="6" class="customisation-empty">
                                <strong>No items found.</strong>

                                <p>
                                    Add your first item to get started.
                                </p>
                            </td>
                        </tr>

                    @endforelse
                </tbody>

            </table>
        </div>

        {{-- Create Modal Component --}}
        @include(
            'components.admin.customisation.create',
            ['optionType' => $optionType]
        )

    </div>

</x-admin-layout>