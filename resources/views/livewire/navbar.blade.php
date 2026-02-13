<nav class="nav">
    <div class="menu-icon">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
    </div>

    <ul class="navlist">
        {{-- SECCIÓN VENTAS --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('sales*') ? 'active' : '' }}" href="{{ route('sales.index') }}">
                Ventas
            </a>
            @if(count($tiposVenta) > 0)
                <ul class="submenu">
                    @foreach($tiposVenta as $tipo)
                        <li>
                            <a href="{{ route('sales.index', ['tipo' => $tipo]) }}">
                                {{ ucfirst($tipo) }}
                            </a>
                        </li>
                    @endforeach      
                </ul>
            @endif
        </li>

        {{-- SECCIÓN ALQUILERES --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('rentals*') ? 'active' : '' }}" href="{{ route('rentals.index') }}">
                Alquileres
            </a>
            @if(count($tiposAlquiler) > 0)
                <ul class="submenu">
                    @foreach($tiposAlquiler as $tipo)
                        <li>
                            <a href="{{ route('rentals.index', ['tipo' => $tipo]) }}">
                                {{ ucfirst($tipo) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
            
        {{-- REDES SOCIALES (Estáticas) --}}
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

    <script>
        // Usamos un listener para reinicializar si Livewire actualiza el DOM, 
        // aunque el navbar suele ser estático.
        document.addEventListener('livewire:navigated', () => { 
            initNavbar(); 
        });

        // Ejecutar al cargar por primera vez
        document.addEventListener('DOMContentLoaded', () => {
            initNavbar();
        });

        function initNavbar() {
            const menuIcon = document.querySelector(".menu-icon");
            const navLinks = document.querySelector(".navlist");
            const links = document.querySelectorAll(".navlist li");

            // Evitar duplicar eventos si se recarga
            const newMenuIcon = menuIcon.cloneNode(true);
            menuIcon.parentNode.replaceChild(newMenuIcon, menuIcon);
            
            newMenuIcon.addEventListener('click', () => {
                navLinks.classList.toggle("open");
                links.forEach((link, index) => {
                    if (link.style.animation) {
                        link.style.animation = '';
                    } else {
                        link.style.animation = `fadeIn 0.3s ease forwards ${index / 7 + 0.3}s`;
                    }
                });
                newMenuIcon.classList.toggle("toggle");
            });

            // Cerrar menú al hacer clic fuera
            document.addEventListener('click', (event) => {
                const isClickInsideNav = navLinks.contains(event.target) || newMenuIcon.contains(event.target);
                if (!isClickInsideNav && navLinks.classList.contains('open')) {
                    navLinks.classList.remove("open");
                    newMenuIcon.classList.remove("toggle");
                    links.forEach(link => {
                        link.style.animation = '';
                    });
                }
            });
        }
    </script>
</nav>