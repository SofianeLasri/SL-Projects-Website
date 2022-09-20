<footer>
    <div class="container">
        <div class="col d-flex flex-column">
            <div class="logo">
                <span>SL</span>
            </div>
            <span>2022 - Sofiane Lasri</span>
        </div>
        @for($i = 0; $i < 3; $i++)
            <div class="col">
                <h3>Liens utiles</h3>
                <ul>
                    @for($j = 0; $j < 3; $j++)
                        <ol><a href="#">Lien {{ $j }}</a></ol>
                    @endfor
                </ul>
            </div>
        @endfor
    </div>
</footer>
