jQuery(document).ready(function($){
    $('#upload_imagem_popup').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            // Output to the console uploaded_image
            console.log(uploaded_image);
            var image_url = uploaded_image.toJSON().url;
            // Let's assign the url value to the input field
            
            $('#imagem-preview-popup-master').attr('src', image_url);

            
            $('#url-imagem-popup').val(image_url);
        });
    });

    jQuery('.imagem-preview').on('click', function(){
        $('#upload_imagem_popup').click();
    });

    jQuery('span.delete-imagem').on('click', function(){
        jQuery('.imagem-preview img').attr('src', null);
        
        jQuery('input#url-imagem-popup').val('');
    });

    $('.color_field').each(function(){
        $(this).wpColorPicker();
        });
});