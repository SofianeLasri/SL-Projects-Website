import {Editor} from '@toast-ui/editor';
import route from 'ziggy-js';

const saveDraftRoute: string = route('dashboard.ajax.projects.save-draft');
const publishProjectRoute: string = "";
const addProjectForm: HTMLFormElement = document.getElementById('addProjectForm') as HTMLFormElement;
const previewProjectBtn: HTMLButtonElement = document.getElementById('previewProjectBtn') as HTMLButtonElement;
const saveDraftBtn: HTMLButtonElement = document.getElementById('saveDraftBtn') as HTMLButtonElement;
const publishProjectBtn: HTMLButtonElement = document.getElementById('publishProjectBtn') as HTMLButtonElement;
const editorElement: HTMLDivElement = document.getElementById('editor') as HTMLDivElement;
const editor: Editor = new Editor({
    el: editorElement,
    height: '500px',
    initialEditType: 'markdown',
    previewStyle: 'vertical'
});
const projectContentElement: HTMLTextAreaElement = document.getElementById('projectContent') as HTMLTextAreaElement;

addProjectForm.addEventListener('submit', (event) => {
    event.preventDefault();
});

previewProjectBtn.addEventListener('click', () => {
    console.log('Preview project');
});

saveDraftBtn.addEventListener('click', () => {
    console.log('Save draft');
    sendProjectFormToServer(true);
});

publishProjectBtn.addEventListener('click', () => {
    console.log('Publish project');
    if(addProjectForm.reportValidity()){
        console.log("Form is valid");
    } else {
        console.log("Form is invalid");
    }
});

document.addEventListener('DOMContentLoaded', () => {
    editor.getMarkdown();
    editor.setMarkdown(projectContentElement.value);
});

function sendProjectFormToServer(isDraft: boolean = false): void {
    const route = isDraft ? saveDraftRoute : publishProjectRoute;
    const formData = new FormData(addProjectForm);
    formData.append('content', editor.getMarkdown());

    const data = Object.fromEntries(formData);

    console.log(data);
    fetch(route, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement).content
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
