<div class="project-card">
    <a href="{{ route('showcase.project', ['project' => $projectSlug]) }}" class="cover"
       @if($coverFile)
           style="background-image: url('{{ $coverFile->getFileUrl() }}')"
       @else
           style="background-image: url('{{ Vite::asset('resources/images/dev/placeholder.jpg') }}')"
        @endif
    >
        <div class="category">
            <span>{{ $projectCategoryName }}</span>
        </div>
    </a>
    <div class="meta">
        <a href="{{ route('showcase.project', ['project' => $projectSlug]) }}" class="title">{{ $projectName }}</a>
    </div>
</div>