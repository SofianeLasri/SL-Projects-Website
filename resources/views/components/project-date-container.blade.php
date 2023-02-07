<div class="project-date-container">
    <div class="title-bar">
        <span class="title">{{ $year }}</span>
        <span class="toggle-icon">
            <i class="fa-solid fa-chevron-up"></i>
        </span>
    </div>
    <div class="content grid grid-cols-4 gap-4">
        @foreach($projects as $project)
            <x-project-card projectSlug="{{ $project['slug'] }}"/>
        @endforeach
    </div>
</div>
