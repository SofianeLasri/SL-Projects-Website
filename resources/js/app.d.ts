import routeFn from 'ziggy-js';
import MediaUploadZone from "./components/dashboard/media-library/MediaUploadZone";
import StepsGroupsList from "./components/dashboard/StepsGroupsList";

declare global {
    var route: typeof routeFn;

    interface Window {
        TuiEditor: any;
        MediaLibrary: any;
        MediaUploadZone: any;
        StepsGroupsList: any;
    }
}
