<!-- plugins:js -->
<script src="<?php $this->url('script/vendors/js/vendor.bundle.base.js'); ?>"></script>
<script src="<?php $this->url('script/vendors/js/vendor.bundle.addons.js'); ?>"></script>
<!-- endinject -->

<!-- inject:js -->
<script src="<?php $this->url('script/js/off-canvas.js'); ?>"></script>
<script src="<?php $this->url('script/js/misc.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript">
  function confirm(url){
    Swal.fire({
      title: 'Are you sure?',
      type: 'warning',
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {
        window.location = url;
      }
    })
  }
  function approve(url){
    Swal.fire({
      title: 'Change this jamaah to be stewardship?',
      type: 'question',
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Approve!'
    }).then((result) => {
      if (result.value) {
        window.location = url;
      }
    })
  }
  function notif(url, title, type, b){
    Swal.fire({
      title: title,
      type: type,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: b
    }).then((result) => {
      if (result.value) {
        window.location = url;
      }
    })
  }
  function loading() {
    NProgress.configure({ easing: 'ease', speed: 3000 });
    NProgress.configure({ showSpinner: false });
    NProgress.configure({ minimum: 0.9 });
    NProgress.start();
    $(window).on('load', function () {
      NProgress.done();
    });
    // setTimeout(function(){ NProgress.done(); }, 1000);
  }
</script>
<style media="screen">
  #nprogress .bar {
    background: #6cbd78cc;
  }
</style>
<!-- endinject -->
