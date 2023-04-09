<footer>
    <div class="custom-container">
        <div class="col">
            <div class="logo">
                <span>SL</span>
            </div>
            <span>2023 - Sofiane Lasri</span>
        </div>
        <div class="col">
            <h3>Derniers projets</h3>
            <ul>
                <ol><a href="#">Interface UI Toolkit</a></ol>
                <ol><a href="#">Site internet server MC</a></ol>
                <ol><a href="#">Plugin Minecraft Spigot MC</a></ol>
                <ol><a href="#">Rosewood RP serveur DarkRP</a></ol>
            </ul>
        </div>
        <div class="col">
            <h3>Activité récente</h3>
            <ul>
                <ol><a href="#">S&Box, mon avis sur le successeur de Garry's Mod</a></ol>
                <ol><a href="#">S&Box, mon avis sur le successeur de Garry's Mod</a></ol>
                <ol><a href="#">S&Box, mon avis sur le successeur de Garry's Mod</a></ol>
            </ul>
        </div>
        <div class="col">
            <h3>À propos de moi</h3>
            <p>J'ai pas grand chose à dire. :p</p>
        </div>
    </div>
</footer>

@push('scripts')
    <script type="text/javascript">
        // Si le footer n'est pas tout en bas de la page car il y a peu de contenu
        // On le place tout en bas de la page
        function footerPosition() {
            let footer = document.querySelector('footer');
            let footerHeight = footer.offsetHeight;
            let windowHeight = window.innerHeight;
            let bodyHeight = document.body.offsetHeight;

            if (bodyHeight < windowHeight) {
                footer.style.position = 'absolute';
                footer.style.bottom = '0';
            } else {
                footer.style.position = 'relative';
                footer.style.bottom = '0';
            }
        }

        footerPosition();

        window.addEventListener('resize', footerPosition);
    </script>
@endpush
