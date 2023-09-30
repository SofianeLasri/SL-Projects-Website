import './bootstrap';
import { Modal } from 'bootstrap'
import slugify from "slugify";
import FormValidator from "@/library/form-validator";
import MediaUploadZone from "@/components/dashboard/media-upload-zone";

import.meta.glob([
    '../images/**',
    '../fonts/**'
]);

window.slugify = slugify;
window.FormValidator = FormValidator;
window.MediaUploadZone = MediaUploadZone;
