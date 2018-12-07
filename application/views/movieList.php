<!DOCTYPE html>
<html>
<head>
    <title>Movies List</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/bootstrap.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Movies List</h2>
                </div>
                <div class="pull-right">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal">Create New Post</button>
                </div>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                <th>Title</th>
                <th>Year</th>
                <th>Description</th>
                <th>Image</th>
                <th width="200px">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

        <ul id="pagination" class="pagination-sm"></ul>
    </div>
    <link href="<?=base_url()?>css/toastr.min.css" rel="stylesheet">
    <script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/jquery.twbsPagination.min.js"></script>
    <script src="<?=base_url()?>/js/validator.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/toastr.min.js"></script>
    <script src="<?=base_url()?>js/postsAjax.js"></script> 
</body>
</html>
