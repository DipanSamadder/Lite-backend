<script>
@if(Session::get('success') != '')
    dsldFlashNotification('success', '<?= Session::get('success'); ?>');
@elseif(Session::get('warning') != '')
    dsldFlashNotification('warning', '<?= Session::get('warning'); ?>');
@elseif(Session::get('info') != '')
    dsldFlashNotification('info', '<?= Session::get('info'); ?>');
@elseif(Session::get('error') != '')
    dsldFlashNotification('error', '<?= Session::get('error'); ?>');
@endif

function clear_cache(){
    DSLDAjaxSubmitFullLoader('{{ route("clear.cache") }}', '', 'GET', '1');
}

$(document).ready(function(){
    $('#upload_form').on('submit', function(event){
    event.preventDefault();
        var images = $('#upload_images').val();
        var formData = new FormData(this);
        let TotalFiles = $('#upload_images')[0].files.length; //Total files
        let files = $('#upload_images')[0];
        for (let i = 0; i < TotalFiles; i++) {
        formData.append('files' + i, files.files[i]);
        }
        formData.append('TotalFiles', TotalFiles);
        if(images != null && images != ''){
            $(this).addClass('btnloading');
            DSLDAjaxSubmit("{{ route('media.uploads') }}", formData, "POST", ".btnloading", 1);
            $(this)[0].reset();
            $('.dropify-render img').attr('src','');
            $('#DSLDImageUpload').modal('hide');
            get_files();
        }else{
            dsldFlashNotification('warning', 'Please select file. Then upload again.');
        }

    });

});
function logout(){
    $('.full_page_loader').fadeIn('slow');
    $.post('{{ route("logout") }}', { '_token':'{{ csrf_token() }}'}, 
        function(returnedData){
            $('.full_page_loader').fadeOut('slow');
            location.reload();
    });
}
$(document).ready(function() { $(".select2").select2(); });
</script>