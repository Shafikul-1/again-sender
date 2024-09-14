@props([
    'cols' => '',
    'rows' => '',
    'name' => '',
])
<style>
    .tox-statusbar__branding {
        display: none;
    }
</style>
<textarea name="{{ $name }}" id="texteditor" cols="{{ $cols }}" rows="{{ $rows }}"
    {{ $attributes }}></textarea>
<script src="https://cdn.tiny.cloud/1/5ltg59f45063hbolbqqrx1glc9kr9e4yg7gcb5op8r26epcg/tinymce/7/tinymce.min.js"
    referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea#texteditor',
        // inline: true,
        content_css: 'dark',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker ',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',  tinycomments_mode: 'embedded',
        media_live_embeds: true,
        tinycomments_author: 'Author name',
        mergetags_list: [{
                value: 'First.Name',
                title: 'Shafikul islam'
            },
            {
                value: 'Email',
                title: 'safikul@gmail.com'
            },
        ],
        setup: function(editor) {
            // Load content from sessionStorage if available
            const savedContent = sessionStorage.getItem('tinymce_content');
            if (savedContent) {
                editor.on('init', function() {
                    editor.setContent(savedContent);
                });
            }

            // Save content to sessionStorage on change
            editor.on('change', function() {
                sessionStorage.setItem('tinymce_content', editor.getContent());
            });

        },
        // ai_request: (request, respondWith) => respondWith.string(() => Promise.reject(
        //     "See docs to implement AI Assistant")),
    });
</script>
