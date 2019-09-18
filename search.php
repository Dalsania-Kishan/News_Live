<?php 
session_start();
error_reporting(0);
include('includes/config.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>News Portal | Search  Page</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/modern-business.css" rel="stylesheet">
    </head>
  <body>
   <?php include('includes/header.php');?>
    <div class="container">
      <div class="row" style="margin-top: 4%">
        <div class="col-md-8">
            <?php 
              if($_POST['searchtitle']!='')
              {
                  $st=$_SESSION['searchtitle']=$_POST['searchtitle'];
              }
                $st;
              if (isset($_GET['pageno'])) 
              {
                $pageno = $_GET['pageno'];
              } 
              else 
              {
                $pageno = 1;
              }
              $no_of_records_per_page = 8;
              $offset = ($pageno-1) * $no_of_records_per_page;
              $total_pages_sql = "SELECT COUNT(*) FROM news_bussiness";
              $result = mysqli_query($con,$total_pages_sql);
              $total_rows = mysqli_fetch_array($result)[0];
              $total_pages = ceil($total_rows / $no_of_records_per_page);
              //$query=mysqli_query($con,"select  news_bussiness.item_title as posttitle,news_bussiness.item_desc as news_details, news_bussiness.item_date as postingdate,news_bussiness.item_id as pid,news_bussiness.item_category as category from  news_bussiness where news_bussiness.item_title like '%$st%'liMIT $offset, $no_of_records_per_page");
              $query=mysqli_query($con,"select item_title as posttitle,item_desc as news_details, item_date as postingdate,item_id as pid,item_category as category ,image as PostImage from (select * from news_bussiness UNION select * from news_politics UNION select * from news_sports UNION select * from news_movies  ) as mix where item_title like '%$st%'liMIT $offset, $no_of_records_per_page");
              $rowcount=mysqli_num_rows($query);
              if($rowcount==0)
              {
                echo "No record found";
              }
              else
              {
               while ($row=mysqli_fetch_array($query)) {
   ?>
             <div class="card mb-4" style="width:400px">
            <img class="card-img-top" src="<?php echo htmlentities($row['PostImage']);?>" alt="<?php echo htmlentities($row['posttitle']);?>">
            <div class="card-body">
              <h2 style="width:700px"><?php echo htmlentities($row['posttitle']);?></h2>
                 <p><b>Category : </b> <?php echo htmlentities($row['category']);?></a> </p>
       
              <a href="news_details.php?nid=<?php echo htmlentities($row['pid'])?>" class="btn btn-primary">Read More &rarr;</a>
            </div>
            <div class="card-footer text-muted">
              Posted on <?php echo htmlentities($row['postingdate']);?>         

              </div>
              <?php } ?>

              <ul class="pagination justify-content-center mb-4">
                  <li class="page-item"><a href="?pageno=1"  class="page-link">First</a></li>
                  <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?> page-item">
                      <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>" class="page-link">Prev</a>
                  </li>
                  <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?> page-item">
                      <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?> " class="page-link">Next</a>
                  </li>
                  <li class="page-item"><a href="?pageno=<?php echo $total_pages; ?>" class="page-link">Last</a></li>
              </ul>
              <?php } ?>
            </div>
            
          </div>
      </div>
        <?php include('includes/footer.php');?>
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    </head>
  </body>
</html>
