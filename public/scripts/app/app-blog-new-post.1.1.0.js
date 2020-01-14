/*
 |--------------------------------------------------------------------------
 | Shards Dashboards: Blog Add New Post Template
 |--------------------------------------------------------------------------
 */

'use strict';

(function ($) {
  $(document).ready(function () {

    var toolbarOptions = [
      [{ 'header': [1, 2, 3, 4, 5, false] }],
      ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
      [{ 'font': [] }],
      ['blockquote', 'code-block'],
      [{ 'align': [] }],               // align
      [{ 'list': 'ordered'}, { 'list': 'bullet' }],
      [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
      [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
      ['link', 'image'],
      ['clean']                                       // remove formatting button
    ];

    // Init the Quill RTE
    var quill = new Quill('#editor-container', {
      modules: {
        toolbar: toolbarOptions
      },
      placeholder: 'Enter the post details...',
      theme: 'snow'
    });

  });
})(jQuery);
