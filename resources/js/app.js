import './bootstrap';
import '../../node_modules/quill/dist/quill';
import slugify from "slugify";
import FormValidator from "@/library/form-validator";
import.meta.glob([
    '../images/**',
    '../fonts/**'
]);

window.slugify = slugify;
window.FormValidator = FormValidator;
