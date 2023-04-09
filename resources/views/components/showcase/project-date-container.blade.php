<div id="{{ $id }}" class="project-date-container" data-opened="true">
    <div class="component title-bar">
        <span class="title">{{ $year }}</span>
        <span class="toggle-icon">
            <i class="fa-solid fa-chevron-up"></i>
        </span>
    </div>
    <div class="content grid lg:grid-cols-2 xl:grid-cols-4 gap-8">
        @foreach($projects as $project)
            <x-showcase.project-card projectSlug="{{ $project['slug'] }}"/>
        @endforeach
    </div>
</div>
@push('scripts')
    <script type="text/javascript">
        document.getElementById("{{ $id }}").getElementsByClassName("title-bar")[0].addEventListener("click", function () {
            let content = this.parentElement.getElementsByClassName("content")[0];
            let icon = this.getElementsByClassName("toggle-icon")[0];

            if (this.parentElement.dataset.opened === "true") {
                this.parentElement.dataset.opened = "false";
                content.style.display = "none";
                icon.innerHTML = '<i class="fa-solid fa-chevron-down"></i>';
            } else {
                this.parentElement.dataset.opened = "true";
                content.style.display = "grid";
                icon.innerHTML = '<i class="fa-solid fa-chevron-up"></i>';
            }
        });
    </script>
@endpush
