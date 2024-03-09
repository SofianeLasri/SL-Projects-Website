import './bootstrap';
import {Modal} from 'bootstrap';
import slugify from "slugify";

import.meta.glob([
    '../images/**',
    '../fonts/**'
]);

window.slugify = slugify;
window.BsModal = Modal;
