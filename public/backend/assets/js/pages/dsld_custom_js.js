
$(function () {
    $('.dd').nestable();

    $('.dd').on('change', function () {
        is_edited();
        var $this = $(this);
        var serializedData = window.JSON.stringify($($this).nestable('serialize'));
        $('.menu_ordering_value').val(serializedData);
    });
});

function showConfirmMessage() {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this imaginary file!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          swal("Poof! Your imaginary file has been deleted!", {
            icon: "success",
          });
        } else {
          swal("Your imaginary file is safe!");
        }
    });
}

function DSLDAlertMessage(Content = '', type = 'error', flash = 1) {
    var heading = 'Success';
    if(type == 'error'){
         heading = 'Success';
    }
    if(type == 'warning'){
         heading = 'Warning';
    }
    if(flash==1){
        dsldFlashNotification(type, Content);
    }else if(flash==0){
        
    }else{
        swal(heading, Content, type);
    }   
}

function DSLDDeleteAlert(id, url, csrf) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this imaginary file!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            destroy(id, url, csrf);
        } else {
            return 0;
        }
    });    
}
function destroy(id, url, csrf){
    $.ajax({
        url: url,
        type: "post",
        data: {'_token': csrf, 'id':id},
        success: function(data) {
            dsldFlashNotification(data['status'], data['message']);
            if(data['status'] =='success'){
                get_pages();
            }
        }
    });
}
function DSLDStatusUpdate(id, status, url, csrf){
    $.ajax({
        url: url,
        type: "post",
        data: {'_token': csrf, 'id':id, 'status': status},
        success: function(data) {
            dsldFlashNotification(data['status'], data['message']);
            if(data['status'] =='success'){
                get_pages();
            }
        }
    });
}


function DSLDAjaxSubmit(url, parameters, method, Loader, flash = 1){
    DSLDButtonLoader(Loader, "start");
    $.ajax({
        url : url,
        type : method,
        cache : false,
        dataType: "JSON",
        contentType: false,
        processData: false,
        data: parameters,
        success: function (data) {
            if(data['status'] == 'success'){
                DSLDAlertMessage(data['content'], 'success', flash);
                return data['data'];
            }else{
                DSLDAlertMessage(data['content'], 'error', flash);
                return data['data'];
            }
            DSLDButtonLoader(Loader, "");
        }
    });
}

function DSLDAjaxSubmitFullLoader(url, parameters, method, flash = 1){
    $('.full_page_loader').fadeIn('slow');
    $.ajax({
        url : url,
        type : method,
        cache : false,
        dataType: "JSON",
        contentType: false,
        processData: false,
        data: parameters,
        success: function (data) {
            
            $('.full_page_loader').fadeOut('slow');
            if(data['status'] == 'success'){
                DSLDAlertMessage(data['message'], 'success', flash);
                return data['data'];
            }else{
                DSLDAlertMessage(data['message'], 'error', flash);
                return data['data'];
            }
        }
    });
}


function DSLDButtonLoader(item, action = null){
    if(action == 'start'){
        $('<div class="swal-button__loader"><div></div><div></div><div></div></div>').insertAfter(item); 
        $(item).next().attr('style', 'opacity:1;'); 
    }else{
        $(item).next().remove('div');
        $(item).removeClass('btnloading');
    }
}

function dsldFlashNotification(status, text = 'Welcome to our website') {
    var colorName = 'alert-danger';

    if (status == 'success') { 
        colorName = 'alert-success';
    }else if(status == 'warning'){
        colorName = 'alert-warning';
    }
    var placementFrom = 'bottom';
    var placementAlign = 'right';
    var animateEnter = 'animated fadeInDown';
    var animateExit = 'animated fadeOutUp';
    var allowDismiss = true;

    $.notify({
        message: text
    },
        {
            type: colorName,
            allow_dismiss: allowDismiss,
            newest_on_top: true,
            timer: 100,
            placement: {
                from: placementFrom,
                align: placementAlign
            },
            animate: {
                enter: animateEnter,
                exit: animateExit
            },
            template: '<div data-notify="container" style="z-index: 9999 !important;" class="bootstrap-notify-container alert alert-dismissible {0} ' + (allowDismiss ? "" : "") + '" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
            '</div>'
        });
}

$(function(){
    $('[data-toggle="add-more"]').each(function () {
        var $this = $(this);
        var content = $this.data("content");
        var target = $this.data("target");

        $this.on("click", function (e) {
            e.preventDefault();
            $(target).append(content);
        });
    });
});
$(function(){
    $(document).on(
        "click",
        '[data-toggle="remove-parent"]',
        function () {
            var $this = $(this);
            var parent = $this.data("parent");
            $this.closest(parent).remove();
        }
    );
});


function fullPageLoader(){

}