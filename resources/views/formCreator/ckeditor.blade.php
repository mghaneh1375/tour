<script src="{{ asset('js/ckeditor5/ckeditor5.js') }}"></script>
<script src="{{ asset('js/ckeditor5/ckeditorUpload.js') }}"></script>

<div id="newSafarnameh" class="modalBlackBack" style="z-index: 9999;">

    <div class="toolbar-container"></div>
    <div style="height: 100vh; overflow: auto" id="safarnamehText" class="textEditor">
    </div>

</div>

<script>
    DecoupledEditor.create(document.querySelector('#safarnamehText'), {
            language: 'fa',
            removePlugins: ['FontSize', 'MediaEmbed'],
        })
        .then(editor => {
            const toolbarContainer = document.querySelector('.toolbar-container');
            toolbarContainer.prepend(editor.ui.view.toolbar.element);
            window.editor = editor;
            textEditor = editor;
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader, './', '');
            };

        })
        .catch(err => {
            console.error(err.stack);
        });
</script>
