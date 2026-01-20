<?php
if (!isset($pageTitle)) {
    $pageTitle = SITE_NAME;
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Portal destinasi, budaya, dan kuliner khas Tegal.">
  <title><?php echo e($pageTitle); ?></title>
  <link rel="stylesheet" href="<?php echo e(base_url('assets/vendor/bootstrap/css/bootstrap.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(base_url('assets/vendor/icons/bootstrap-icons.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(base_url('assets/css/style.css')); ?>">
</head>
<body>
