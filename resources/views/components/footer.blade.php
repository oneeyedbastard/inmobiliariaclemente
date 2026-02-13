<!-- resources/views/components/footer.blade.php -->
<footer class="modern-footer">
    <div class="footer-container">
        <div class="footer-grid">
            <!-- Logo y descripción -->
            <div class="footer-brand">
                <div class="footer-logo-wrapper">
                    <span class="footer-logo">INMOBILIARIA</span>
                    <span class="footer-logo-highlight">CLEMENTE</span>
                </div>
                <p class="footer-slogan">40 años acompañándote en el camino a tu hogar</p>
                <div class="footer-social">
                    <a href="https://wa.me/5492215408272" target="_blank" class="social-link" aria-label="WhatsApp">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/inmobiliariaclemente/" target="_blank" class="social-link" aria-label="Instagram">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Menú rápido -->
            <div class="footer-links">
                <h4 class="footer-title">Enlaces rápidos</h4>
                <ul class="footer-menu">
                    <li><a href="{{ route('home') }}">Inicio</a></li>
                    <li><a href="{{ route('sales.index') }}">Ventas</a></li>
                    <li><a href="{{ route('rentals.index') }}">Alquileres</a></li>
                </ul>
            </div>

            <!-- Contacto -->
            <div class="footer-contact">
                <h4 class="footer-title">CONTACTO</h4>
                <address class="contact-list">
                    <div class="contact-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        <span>422 entre 3 y 4, Villa Elisa</span>
                    </div>
                    <div class="contact-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8 10a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.574 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                        <span>(0221) 487-1010</span>
                    </div>
                    <div class="contact-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8 10a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.574 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                        <span>(0221) 540-8272</span>
                    </div>
                    <div class="contact-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        <a href="mailto:inmobiliariaclemente@hotmail.com">inmobiliariaclemente@hotmail.com</a>
                    </div>
                    <div class="contact-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <span>Lunes a Viernes 9-14hs</span>
                    </div>
                </address>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-credits">
                <span class="copyright">© {{ date('Y') }} Todos los derechos reservados.</span>
                <span class="developer-credit">
                    Desarrollado por 
                    <a href="https://oneeyedbastard.github.io/" target="_blank" rel="noopener" class="dev-link">
                        One Eyed Bastard
                    </a>
                </span>
            </div>
        </div>
    </div>
</footer>