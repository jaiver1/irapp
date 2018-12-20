<!-- Central Modal Large Info-->
 <div class="modal modal-top fade" id="modal_user" tabindex="-1" role="dialog" aria-labelledby="modal_user" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-notify modal-secondary" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <h3 class="heading lead"><i class="white-text fas fa-box-open mr-1"></i>Usuarios tipo "{{ $producto->nombre }}"</h3>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body">
                <div class="text-center">
                    <i class="fas fa-5x mb-3 animated rotateIn fa-users"></i>
                    <h3> Codigo: {{ $producto->tipo_referencia->nombre }} ({{ $producto->tipo_referencia->dimension }})</h3>
                </div>
                <hr/>
               

            </div>

            <!--Footer-->
            <div class="modal-footer">
   
                </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<!-- Central Modal Large Info-->
