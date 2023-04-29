<form id="{{ $id }}" method="get" class="project-filter" data-opened="true" data-see-all="true">
    <div class="toogleable-title-bar white">
        <span class="title">{{ $title }}</span>
        <span class="toggle-icon">
            <i class="fa-solid fa-chevron-up"></i>
        </span>
    </div>
    <div class="content">
        @foreach($filters as $i => $filter)
            <div class="filter-item">
                <input type="checkbox" id="filter-{{ $filter['name'] }}"
                       name="filter-{{ $filter['name'] }}"
                       @if(isset($filter['checked']) && $filter['checked'])
                           checked
                    @endif
                >
                <label for="filter-{{ $filter['name'] }}">{{ $filter['label'] }}</label>
            </div>
        @endforeach
    </div>
    <div class="controls">
        <button class="btn btn-dark" id="seeMore-{{ $id }}" type="button">
            <i class="fa-solid fa-plus"></i>
            <span>Voir plus</span>
        </button>
        <button class="btn btn-white" type="submit">
            <i class="fa-solid fa-filter"></i>
            <span>Filtrer</span>
        </button>
    </div>
</form>
@push('scripts')
    <script type="text/javascript">
        document.getElementById("{{ $id }}").getElementsByClassName("toogleable-title-bar")[0].addEventListener("click", function () {
            let content = this.parentElement.getElementsByClassName("content")[0];
            let icon = this.getElementsByClassName("toggle-icon")[0];

            if (this.parentElement.dataset.opened === "true") {
                this.parentElement.dataset.opened = "false";
                content.style.display = "none";
                icon.innerHTML = '<i class="fa-solid fa-chevron-down"></i>';
            } else {
                this.parentElement.dataset.opened = "true";
                content.style.display = "flex";
                icon.innerHTML = '<i class="fa-solid fa-chevron-up"></i>';
            }
        });

        document.getElementById("seeMore-{{ $id }}").addEventListener("click", function () {
            let parent = document.getElementById("{{ $id }}");
            let icon = parent.getElementsByClassName("toggle-icon")[0];
            let content = parent.getElementsByClassName("content")[0];

            if (parent.dataset.seeAll === "true") {
                parent.dataset.seeAll = "false";
                this.innerText = "Voir moins";
                content.style.maxHeight = "none";
            } else {
                parent.dataset.seeAll = "true";
                this.innerText = "Voir plus";
                content.style.maxHeight = "20rem";
            }

            // On réécrit le code de la fonction précédente pour éviter de faire une fonction
            // Et de devoir gérer les duplicata de cette fonction sur la page
            if (parent.dataset.opened === "false") {
                parent.dataset.opened = "true";
                content.style.display = "flex";
                icon.innerHTML = '<i class="fa-solid fa-chevron-up"></i>';
            }
        });
    </script>
@endpush
