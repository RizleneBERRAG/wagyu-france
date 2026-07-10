<footer class="site-footer">
    <div class="footer-brand">
        <span class="footer-logo-wrap">
            <img src="{{ asset('assets/images/logo/wagyufrance-logo.png') }}" alt="{{ config('app.name', 'Wagyu France') }}">
        </span>
        <div>
            <strong>{{ config('app.name', 'Wagyu France') }}</strong>
            <p>Viande Wagyu française d’exception, réservée aux connaisseurs.</p>
        </div>
    </div>

    <div class="footer-grid">
        <div>
            <h3>Maison</h3>

            <a href="{{ route('histoire') }}">Notre histoire</a>
            <a href="{{ route('wagyu') }}">Le Wagyu</a>
            <a href="{{ route('blog') }}">Conseils & recettes</a>
            <a href="{{ route('contact') }}">Contact</a>
        </div>

        <div>
            <h3>Achat</h3>

            <a href="{{ route('boutique') }}">Boutique</a>
            <a href="{{ route('reserve.pro') }}">Réserve professionnelle</a>
            <a href="{{ route('contact') }}">Demander un accès pro</a>
        </div>

        <div>
            <h3>Professionnels</h3>

            <a href="{{ route('professionnels') }}">Univers pro</a>
            <a href="{{ route('decoupe-volumes') }}">Découpe & volumes</a>
            <a href="{{ route('tracabilite') }}">Traçabilité</a>
            <a href="{{ route('reserve.pro') }}">Pré-réserver</a>
        </div>

        <div>
            <h3>Contact</h3>

            @if (config('wagyu.withdrawal_address'))
                <p>{{ config('wagyu.withdrawal_address') }}</p>
            @endif

            @if (config('wagyu.contact_email'))
                <a href="mailto:{{ config('wagyu.contact_email') }}">{{ config('wagyu.contact_email') }}</a>
            @endif

            @if (config('wagyu.contact_phone'))
                <a href="tel:{{ preg_replace('/\s+/', '', config('wagyu.contact_phone')) }}">{{ config('wagyu.contact_phone') }}</a>
            @endif
        </div>
    </div>

    <div class="footer-bottom">
        <p>
            © {{ date('Y') }} {{ config('app.name', 'Wagyu France') }}. Tous droits réservés.
        </p>

        <div class="footer-legal-links">
            <a href="{{ route('mentions.legales') }}">Mentions légales</a>
            <a href="{{ route('confidentialite') }}">Confidentialité</a>
            <a href="{{ route('cgv') }}">CGV</a>
        </div>
    </div>
</footer>