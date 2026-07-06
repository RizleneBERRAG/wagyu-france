<footer class="site-footer">
    <div class="footer-brand">
        <span class="footer-logo-wrap">
            <img src="{{ asset('assets/images/logo/wagyufrance-logo.png') }}" alt="Wagyu France">
        </span>
        <div>
            <strong>Wagyu France</strong>
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

            <p>Ferme du Bois des Huttes</p>
            <p>02140 Landouzy-la-Ville</p>
            <p>France</p>
        </div>
    </div>

    <div class="footer-bottom">
        <p>
            © {{ date('Y') }} Wagyu France. Tous droits réservés.
        </p>

        <div class="footer-legal-links">
            <a href="{{ route('mentions.legales') }}">Mentions légales</a>
            <a href="{{ route('confidentialite') }}">Confidentialité</a>
            <a href="{{ route('cgv') }}">CGV</a>
        </div>
    </div>
</footer>
