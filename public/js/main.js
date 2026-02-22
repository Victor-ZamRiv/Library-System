$(document).ready(function(){
    /* ==========================================================================
       1. INTERFAZ: SIDEBAR Y MENÚS (Código original)
       ========================================================================== */
    $('.btn-sideBar-SubMenu').on('click', function(e){
        e.preventDefault();
        var SubMenu=$(this).next('ul');
        var iconBtn=$(this).children('.zmdi-caret-down');
        if(SubMenu.hasClass('show-sideBar-SubMenu')){
            iconBtn.removeClass('zmdi-hc-rotate-180');
            SubMenu.removeClass('show-sideBar-SubMenu');
        }else{
            iconBtn.addClass('zmdi-hc-rotate-180');
            SubMenu.addClass('show-sideBar-SubMenu');
        }
    });

    $('.btn-menu-dashboard').on('click', function(e){
        e.preventDefault();
        var body=$('.dashboard-contentPage');
        var sidebar=$('.dashboard-sideBar');
        if(sidebar.css('pointer-events')=='none'){
            body.removeClass('no-paddin-left');
            sidebar.removeClass('hide-sidebar').addClass('show-sidebar');
        }else{
            body.addClass('no-paddin-left');
            sidebar.addClass('hide-sidebar').removeClass('show-sidebar');
        }
    });


    /* ==========================================================================
       3. INDICADORES: POPOVERS Y CONTROL DE MODALES
       ========================================================================== */
    // Inicializar Popovers (los textos que aparecen al pasar el mouse)
    var popoverOptions = {
        html: true,
        container: 'body',
        trigger: 'hover',
        placement: 'auto left'
    };

    $('.indicator-item').popover(popoverOptions);

    // Al hacer clic en una tarjeta de indicador, abrir el modal correspondiente
    $('.indicator-item').on('click', function() {
        var targetModal = $(this).data('target-modal');
        if (targetModal) {
            $(this).popover('hide'); // Evita que el popover quede flotando sobre el modal
            $(targetModal).modal('show');
        }
    });

    // Limpieza de Modales: Asegura que el fondo oscuro desaparezca correctamente
    $('.modal').on('hidden.bs.modal', function() {
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
    });
});

/* ==========================================================================
   4. SCROLL PERSONALIZADO (mCustomScrollbar)
   ========================================================================== */
(function($){
    $(window).on("load",function(){
        $(".dashboard-sideBar-ct").mCustomScrollbar({
            theme:"light-thin",
            scrollbarPosition: "inside",
            autoHideScrollbar: true,
            scrollButtons: {enable: true}
        });
        $(".dashboard-contentPage, .Notifications-body").mCustomScrollbar({
            theme:"dark-thin",
            scrollbarPosition: "inside",
            autoHideScrollbar: true,
            scrollButtons: {enable: true}
        });
    });
})(jQuery);