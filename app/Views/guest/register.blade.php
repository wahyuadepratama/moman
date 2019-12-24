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

  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

</head>

<body class="text-center" style="margin:2" onload="loading()">
  <form class="pt-3" method="post" action="<?php $this->url('register/store') ?>">

    <?php $this->csrf_field() ?>

    <img class="mb-2" src="<?php $this->url('images/favicon.png') ?>" alt="" width="72" height="72" style="margin-top:25%">
    <h1 class="h3 mb-3 font-weight-normal">Please sign up</h1>

    <div class="form-group">
      <label for="inputEmail" class="sr-only">Jamaah Name</label>
      <input type="text" maxlength="30" name="name" class="form-control" placeholder="Jamaah Name" required="">
    </div>

    <div class="form-group">
      <label for="inputEmail" class="sr-only">Username</label>
      <input type="text" maxlength="15" name="username" class="form-control" placeholder="Username" required="">
    </div>

    <div class="form-group">
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" name="password" class="form-control" placeholder="Password" required="">
    </div>

    <div class="form-group">
      <label for="inputPassword" class="sr-only">Address</label>
      <input type="text" maxlength="60" name="address" class="form-control" placeholder="Address" required="">
    </div>

    <div class="form-group">
      <label for="inputPassword" class="sr-only">Phone</label>
      <input type="number" name="phone" class="form-control" placeholder="Phone number">
    </div>

    <div class="form-group">
      <select class="js-example-basic-single form-control" name="mosque">
        <?php foreach ($w as $value): ?>
          <option value="<?= $value->id ?>"><?= $value->name ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <select class="js-example-basic-single form-control" name="type">
        <option value="1">I live around this mosque area</option>
        <option value="2">I don't live around this mosque area</option>
      </select>
    </div>

    <script type="text/javascript">
      // In your Javascript (external .js resource or <script> tag)
      $(document).ready(function() {
        $('.js-example-basic-single').select2();
      });
    </script>

    <button class="btn btn-lg btn-success btn-block" type="submit" style="margin-top:5%">Register</button><br>
    <a href="<?php $this->url('login') ?>" class="btn btn-sm btn-success btn-block" type="submit">Login</a>

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
  <style media="screen">
    #nprogress .bar {
      background: #6cbd78cc;
    }
  </style>

</html>
