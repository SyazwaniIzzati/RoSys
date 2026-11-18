
@vite('resources/css/admin-customisation.css')

<x-admin-layout title="Customisation">

    <div class="customisation-page">

        <span class="eyebrow">RoSys . Administrator</span>

        <h1 class="page-title">Customisation</h1>

        <p class="page-lead">
            Manage the options available for customers to customise
            their bouquets.
        </p>

        @if (session('success'))
            <div class="customisation-alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="customisation-grid">

            {{-- Wrapping --}}
            <a href="{{ route('admin.customisation.type', 'wrapping') }}"
               class="customisation-card">

                <div class="customisation-visual wrapping-visual">
                    <span class="customisation-symbol">W</span>
                </div>

                <div class="customisation-card-content">
                    <h2>Wrapping</h2>

                    <p>
                        Manage wrapping paper, colours, prices and
                        available stock for bouquet packaging.
                    </p>

                    <span class="customisation-link">
                        Manage Items
                        <span aria-hidden="true">&rarr;</span>
                    </span>
                </div>

            </a>

            {{-- Ribbon --}}
            <a href="{{ route('admin.customisation.type', 'ribbon') }}"
               class="customisation-card">

                <div class="customisation-visual ribbon-visual">
                    <span class="customisation-symbol">R</span>
                </div>

                <div class="customisation-card-content">
                    <h2>Ribbon</h2>

                    <p>
                        Manage ribbon colours, styles, prices and
                        available stock.
                    </p>

                    <span class="customisation-link">
                        Manage Items
                        <span aria-hidden="true">&rarr;</span>
                    </span>
                </div>

            </a>

            {{-- Theme Colour --}}
            <a href="{{ route('admin.customisation.type', 'theme_colour') }}"
               class="customisation-card">

                <div class="customisation-visual theme-colour-visual">
                    <span class="customisation-symbol">C</span>
                </div>

                <div class="customisation-card-content">
                    <h2>Theme Colour</h2>

                    <p>
                        Manage the colour themes customers can select
                        for their customised bouquets.
                    </p>

                    <span class="customisation-link">
                        Manage Items
                        <span aria-hidden="true">&rarr;</span>
                    </span>
                </div>

            </a>

            {{-- Bouquet Style --}}
            <a href="{{ route('admin.customisation.type', 'bouquet_style') }}"
               class="customisation-card">

                <div class="customisation-visual bouquet-style-visual">
                    <span class="customisation-symbol">B</span>
                </div>

                <div class="customisation-card-content">
                    <h2>Bouquet Style</h2>

                    <p>
                        Manage the bouquet arrangements and styles
                        customers can choose.
                    </p>

                    <span class="customisation-link">
                        Manage Items
                        <span aria-hidden="true">&rarr;</span>
                    </span>
                </div>

            </a>

        </div>

    </div>

</x-admin-layout>
