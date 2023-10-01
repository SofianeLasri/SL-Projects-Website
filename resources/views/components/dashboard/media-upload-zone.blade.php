<div id="mediaUploadZone" class="media-upload-zone">
    <div class="no-file-uploaded-yet">
        <i class="fa-solid fa-cloud-arrow-up"></i>
        <div class="text-center">
            <div class="fs-5">Glissez le fichier à envoyer</div>
            <div class="text-muted">ou cliquez sur le bouton ci-dessous</div>
        </div>
        <x-button id="mediaUploadZoneSendFileBtn" type="button" class="btn-primary">
            Envoyer un média
        </x-button>
    </div>
    <div class="file-upload-list">
        <div id="fileErrorModel" class="file" style="display: none;">
            <x-square-icon size="3.15rem" font-size="1.25rem" class="icon text-danger bg-danger-subtle border-danger">
                <i class="fa-solid fa-circle-exclamation"></i>
            </x-square-icon>
            <div class="infos">
                <div class="meta flex-column gap-0">
                    <div>Une erreur est survenue. :'c</div>
                    <div class="small text-muted file-error-message"></div>
                </div>
            </div>
            <div class="actions">
                <x-button type="button" class="btn-link text-dark file-close-btn">
                    <x-square-icon size="1rem">
                        <i class="fa-solid fa-xmark"></i>
                    </x-square-icon>
                </x-button>
            </div>
        </div>
    </div>
</div>
