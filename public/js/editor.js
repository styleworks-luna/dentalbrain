$(function () {
    var token = $('meta[name="csrf-token"]').attr('content');

    $('#image').change(function () {
        var form = $('form')[0];
        var formData = new FormData(form);
        formData.append("image", $("#image")[0].files[0]);

        $.ajax({
            headers: {
                'X-CSRF-Token': token,
            },
            url: '/api/albatalk/recruit/editor/image',
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            data: formData,
            type: 'POST',
        }).then(res => {
            let path = res.url;
            var name = res.name;

            CKEDITOR.instances.editor.insertHtml(`<img src="${path}" alt="${name}">`)
        }).fail(err => {
            alert('오류가 발생하였습니다.')
        });
    });

    $('#file').change(function () {
        var form = $('form')[0];
        var formData = new FormData(form);
        formData.append("file", $("#file")[0].files[0]);

        $.ajax({
            headers: {
                'X-CSRF-Token': token,
            },
            url: '/api/albatalk/recruit/editor/file',
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            data: formData,
            type: 'POST',
        }).then(res => {
            var path = res.url;
            var name = res.name;
            CKEDITOR.instances.editor.insertHtml(`<a href="${path}" download>${name}</a>`)
        }).fail(err => {
            alert('오류가 발생하였습니다.');
        });
    });

})
