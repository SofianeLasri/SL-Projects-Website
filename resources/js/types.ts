export type LaravelValidationError = {
    message: string;
    errors: {
        [key: string]: string[];
    };
}

export type MUZUploadedFileResponse = {
    "success": boolean,
    "url": string,
}