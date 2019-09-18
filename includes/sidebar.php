  <div class="col-md-4">

          <!-- Search Widget -->
          <div class="card mb-4">
            <h5 class="card-header">Search</h5>
            <div class="card-body">
                   <form name="search" action="search.php" method="post">
              <div class="input-group">
            
        <input type="text" name="searchtitle" class="form-control" placeholder="Search for..." required>
                <span class="input-group-btn">
                  <button class="btn btn-secondary" type="submit">Go!</button>
                </span>
              </form>
              </div>
            </div>
          </div>
          <div>
            <h5 >Recent News</h5>
            <div class="card mb-4" style="width:350px; height:400px; border:1px solid #ccc";>
                          
            <marquee  direction="up" onmouseover="this.stop();" onmouseout="this.start();">  
              <?php
              $query=mysqli_query($con,"select item_title as posttitle,item_desc as news_details,item_date as postingdate,item_id as pid,item_category as category ,image as PostImage from  (select * from news_bussiness UNION select * from news_politics UNION select * from news_sports UNION select * from news_movies )as mix order by item_date desc  LIMIT 10,7");
              if(mysqli_num_rows($query) > 0)  
                     {  
                          while($row = mysqli_fetch_array($query))  
                          {  ?>
                            <li>   <a href="news_details.php?nid=<?php echo htmlentities($row['pid'])?>"><?php echo htmlentities($row['posttitle']);?></a> 
                            </li> 
                        <?php  }  
                     }
              ?>
            </marquee>
          
          </div>

          <div  class="card mb-4">
            
          </div>
        </div>
        
      </div>
