@section('img_form')

    <!--Grid row-->
    <div class="row mt-5">

            <!--Grid column-->
            <div class="col-12">

                <!--Card-->
                <div class="card hoverable"> 
                    <!--Card content-->
                    <div class="card-body card-alta">
                            <div class="d-sm-flex justify-content-between">
                                    <h4><i class="far fa-image mr-2"></i>
                                    Imagen de perfil
                                </h4>                               
                                </div>
                                <hr/>
                                <div class="row center">
                                        <div class="col-12">
    <div id="body-overlay"><div><img src="{{ asset('img/dashboard/profile/loading.gif') }}" width="64px" height="64px"/></div></div>
<div class="bg-color-img">
<form id="uploadForm" action="{{ route('profile.uploadImagen',$usuario->id) }}" method="POST" accept-charset="UTF-8">
        <input name="_method" type="hidden" value="PUT">
        <input id="default_img" name="default_img" type="hidden" value="{{ ($usuario->imagen ? asset($usuario->imagen) : asset('img/dashboard/sidebar/user.jpg'))}}">
<div id="targetOuter" class="hoverable">
<div id="targetLayer"></div>
<img src="{{ asset('img/dashboard/profile/photo.png') }}"  class="icon-choose-image" />
<div class="icon-choose-image" >
<input name="imagen" id="userImage" type="file" class="inputFile" onChange="showPreview(this);" />
</div>
</div>
<div id="targetMessage"></div>
<div>
<button type="submit" class="btn btn-submit-img hoverable" style="">
<i class="fas fa-cloud-upload-alt"></i> Subir foto
</button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
<!--/.Card-->
</div>
<!--Grid column-->
</div>
<!--Grid row-->
@endsection

@section('img_script')
<script type="text/javascript">

 function showPreview(objFileInput) {
if (objFileInput.files[0]) {
    var fileReader = new FileReader();
    fileReader.onload = function (e) {
        var error_img = "{{ asset('img/dashboard/sidebar/user.jpg') }}";
        $('#blah').attr('src', e.target.result);
        $("#targetMessage").html("");
        $("#targetLayer").html('<img src="'+e.target.result+'" width="213px" height="213px" class="upload-preview" onerror="this.src=\''+error_img+'\'" />');
        $("#targetLayer").css('opacity','1');
        $(".icon-choose-image").css('opacity','0.5');
    }
    fileReader.readAsDataURL(objFileInput.files[0]);
}
}

$(document).ready(function (e) {
    var error_img = "{{ asset('img/dashboard/sidebar/user.jpg') }}";
    var default_img = $("#default_img").val();
    $("#targetLayer").html('<img src="'+default_img+'" width="213px" height="213px" class="upload-preview" onerror="this.src=\''+error_img+'\'" />');
    $("#targetLayer").css('opacity','1');
    $(".icon-choose-image").css('opacity','0.5');
});

 $("#uploadForm").on('submit',(function(e) {
        e.preventDefault();
      //$("#body-overlay").show();
      var url_send = "{{ route('profile.uploadImagen', $usuario->id) }}";
      var _token = "{{ csrf_token() }}";
      var error_img = "{{ asset('img/dashboard/sidebar/user.jpg') }}";
    var default_img = $("#default_img").val();
    inicio_carga();
  $.ajax({
    method: "POST",
    url: url_send,
    async:true,
    contentType:false, 
    processData:false,
    headers: {
        'X-CSRF-TOKEN': _token
    },
    data:  new FormData(this),
  })
    .done(function(response) {
      try{
        console.log(response);
        $("#targetLayer").css('opacity','1');
                $("#targetMessage").html("<span class='h5'><span class='badge "+response.style+" hoverable'>"+response.message+"</span></span>");
                if(response.status == 200){               
                    $("#targetLayer").html('<img src="'+response.url_img+'" width="213px" height="213px" class="upload-preview" onerror="this.src=\''+error_img+'\'" />');
                    $("#default_img").val(response.url_img);
                    var user = "{{ $usuario->id }}";
                    var session_user = "{{ Auth::user()->id }}";
                    var is_profile = "{{ \Request::is('profile') }}";
                    if(user == session_user){
                        $('#user-nav-img').attr('src',response.url_img);
                        if(is_profile){
                          $('#profile-avatar').attr('src',response.url_img);
                        }
                    }
                }else{
                    $("#targetLayer").html('<img src="'+default_img+'" width="213px" height="213px" class="upload-preview" onerror="this.src=\''+error_img+'\'" />');
                }

            //setInterval(function() {$("#body-overlay").hide(); },500);

    }
    catch(err) {
        console.log(err.message);
    }
    })
    .fail(function(response) {
      console.log(response.responseJSON);
      swal({
        title: 'Error '+response.status,
        text: response.statusText,
        type: 'error',
        confirmButtonText: '<i class="fa fa-check"></i> Continuar',
        showCloseButton: true,
        confirmButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        animation: false,
        customClass: 'animated zoomIn',
      });
    })
    .always(function() {
      fin_carga();
    });

    }));


</script>
    @endsection