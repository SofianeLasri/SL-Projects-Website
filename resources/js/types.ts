export type LaravelValidationError = {
    message: string;
    errors: {
        [key: string]: string[];
    };
}

export type MUZUploadedFileResponse = {
    success: boolean,
    url: string,
}

export type ProjectEditorResponse = {
    success: boolean,
    url: string,
    project_id?: number,
    draft_id?: number,
}
