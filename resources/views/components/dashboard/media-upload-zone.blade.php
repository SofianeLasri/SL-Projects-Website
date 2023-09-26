<div id="mediaUploadZone" class="media-upload-zone">
    <div class="no-file-uploaded-yet d-none">
        <i class="fa-solid fa-cloud-arrow-up"></i>
        <div class="text-center">
            <div class="fs-5">Glissez le fichier à envoyer</div>
            <div class="text-muted">ou cliquez sur le bouton ci-dessous</div>
        </div>
        <x-button type="button" class="btn-primary">
            Envoyer un média
        </x-button>
    </div>
    <div class="files-uploaded">
        <div class="file">
            <x-square-icon size="3rem" font-size="1.5rem" class="icon">
                <i class="fa-solid fa-file"></i>
            </x-square-icon>
            <div class="infos">
                <div class="meta">
                    <div class="name">image.jpg</div>
                    <div class="size">1.5 Mo</div>
                </div>
                <div class="progress-bar">
                    <div class="progress" style="width: 50%"></div>
                </div>
            </div>
            <div class="actions">
                <x-button type="button" class="btn-link text-dark">
                    <x-square-icon size="1rem">
                        <i class="fa-solid fa-xmark"></i>
                    </x-square-icon>
                </x-button>
            </div>
        </div>
    </div>
</div>
