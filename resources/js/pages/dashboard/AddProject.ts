import {Editor} from '@toast-ui/editor';

const previewProjectBtn: HTMLButtonElement = document.getElementById('previewProjectBtn') as HTMLButtonElement;
const saveDraftBtn: HTMLButtonElement = document.getElementById('saveDraftBtn') as HTMLButtonElement;
const publishProjectBtn: HTMLButtonElement = document.getElementById('publishProjectBtn') as HTMLButtonElement;
const editorElement: HTMLDivElement = document.getElementById('editor') as HTMLDivElement;

const editor = new Editor({
    el: editorElement,
    height: '500px',
    initialEditType: 'markdown',
    previewStyle: 'vertical'
});

editor.getMarkdown();
previewProjectBtn.addEventListener('click', () => {
    console.log('Preview project');
});

saveDraftBtn.addEventListener('click', () => {
    console.log('Save draft');
});

publishProjectBtn.addEventListener('click', () => {
    console.log('Publish project');
});
