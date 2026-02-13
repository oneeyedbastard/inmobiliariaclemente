@php
    $nombresPlural = [
        'casa'         => 'Casas',
        'departamento' => 'Departamentos',
        'local'        => 'Locales',
        'cochera'      => 'Cocheras',
        'terreno'      => 'Terrenos'
    ];
@endphp

<nav class="nav">
    {{-- Botón Hamburguesa (Móvil) --}}
    <div class="menu-icon">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
    </div>

    <ul class="navlist">
        {{-- ================= SECCIÓN VENTAS ================= --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}" href="{{ route('sales.index') }}">
                Ventas
            </a>
            <ul class="submenu">
                @foreach($nombresPlural as $slug => $nombre)
                    <li>
                        <a href="{{ route('sales.index', ['tipo' => $slug]) }}" 
                           class="{{ (request('tipo') == $slug || request()->route('tipo') == $slug) && request()->routeIs('sales.index') ? 'fw-bold' : '' }}">
                            {{ $nombre }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>

        {{-- ================= SECCIÓN ALQUILERES ================= --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('rentals.*') ? 'active' : '' }}" href="{{ route('rentals.index') }}">
                Alquileres
            </a>
            <ul class="submenu">
                @foreach($nombresPlural as $slug => $nombre)
                    <li>
                        <a href="{{ route('rentals.index', ['tipo' => $slug]) }}" 
                           class="{{ (request('tipo') == $slug || request()->route('tipo') == $slug) && request()->routeIs('rentals.index') ? 'fw-bold' : '' }}">
                            {{ $nombre }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
            
        {{-- ================= REDES SOCIALES ================= --}}
        <li class="nav-item d-none d-md-block">
            <a href="https://wa.me/5492215408272" target="_blank" class="nav-link" aria-label="WhatsApp">
                <i class="fab fa-whatsapp"></i> WhatsApp
            </a>
        </li>

        <li class="nav-item d-none d-md-block">
            <a href="https://www.instagram.com/inmobiliariaclemente/" target="_blank" class="nav-link" aria-label="Instagram">
                <i class="fab fa-instagram"></i> Instagram
            </a>
        </li>       
    </ul>
</nav>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const menuIcon = document.querySelector(".menu-icon");
        const navLinks = document.querySelector(".navlist");
        const links = document.querySelectorAll(".navlist > li");

        if (menuIcon && navLinks) {
            menuIcon.addEventListener('click', () => {
                navLinks.classList.toggle("open");
                menuIcon.classList.toggle("toggle");
                
                links.forEach((link, index) => {
                    if (link.style.animation) {
                        link.style.animation = '';
                    } else {
                        link.style.animation = `fadeIn 0.3s ease forwards ${index / 7 + 0.2}s`;
                    }
                });
            });

            document.addEventListener('click', (event) => {
                const isClickInsideNav = navLinks.contains(event.target) || menuIcon.contains(event.target);
                if (!isClickInsideNav && navLinks.classList.contains('open')) {
                    navLinks.classList.remove("open");
                    menuIcon.classList.remove("toggle");
                    links.forEach(link => {
                        link.style.animation = '';
                    });
                }
            });
        }
    });
</script>
@endpush