define( [ 'NProgress', 'jquery' ], function ( NProgress, $ ) {

    
  $(document)
    .ajaxStart(function () {
      NProgress.start()
    })
    .ajaxStop(function () {
      NProgress.done()
    })

} );