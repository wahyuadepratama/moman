<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Required meta tags -->
  <?php $this->include('partials/_header'); ?>
  <!-- end of required meta tags -->

  <!-- Cuztome css here -->
  <?php $this->include('style/_global'); ?>
  <!-- end custome -->

  <style media="screen">
  body,html{height:100%}body{display:-ms-flexbox;display:-webkit-box;display:flex;-ms-flex-align:center;-ms-flex-pack:center;-webkit-box-align:center;align-items:center;-webkit-box-pack:center;justify-content:center;padding-top:40px;padding-bottom:40px;background-color:#f5f5f5}.form-signin{width:100%;max-width:330px;padding:15px;margin:0 auto}.form-signin .checkbox{font-weight:400}.form-signin .form-control{position:relative;box-sizing:border-box;height:auto;padding:10px;font-size:16px}.form-signin .form-control:focus{z-index:2}.form-signin input[type=email]{margin-bottom:-1px;border-bottom-right-radius:0;border-bottom-left-radius:0}.form-signin input[type=password]{margin-bottom:10px;border-top-left-radius:0;border-top-right-radius:0}
  </style>

</head>
  <body class="text-center" onload="loading()">
    <form class="pt-3" method="post" action="<?php $this->url('admin/login') ?>">

      <?php $this->csrf_field() ?>

      <img class="mb-4" src="<?php $this->url('images/favicon.png') ?>" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Administrator</h1>
      <label for="inputEmail" class="sr-only">Username</label>
      <input type="text" name="username" class="form-control" placeholder="Username" required="" autofocus="">
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" name="password" class="form-control" placeholder="Password" required=""><br>

      <button class="btn btn-lg btn-success btn-block" type="submit">Sign in</button><br>

      <?php if (!empty($this->flash())): ?>
        <br><div class="alert alert-danger">
          <small><?php $this->flash('print') ?></small>
        </div>
      <?php endif; ?>

      <p class="mt-5 mb-3 text-muted">© 2018 - 2019</p>
    </form>
</body>

<script src="https://unpkg.com/nprogress@0.2.0/nprogress.js" charset="utf-8"></script>
<link rel="stylesheet" href="https://unpkg.com/nprogress@0.2.0/nprogress.css">
<style media="screen">#nprogress .bar {background: #6cbd78cc;}</style>
<script type="text/javascript">
  function loading() {
    NProgress.configure({ easing: 'ease', speed: 2000 });
    NProgress.configure({ showSpinner: false });
    NProgress.configure({ minimum: 0.9 });
    NProgress.start();
    NProgress.done();
    // setTimeout(function(){ NProgress.done(); }, 1000);
  }
</script>

</html>
