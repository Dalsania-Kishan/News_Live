<script src="https://use.fontawesome.com/567fc88304.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.pack.js"></script>
<script src="2.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="3.css">


<div class="content">
     <h2>YouTube Search Engine</h2>
            <div id="custom-search-input">
                <div class="input-group col-md-12">
                    <form id="search-form" name="search-form" onsubmit="return searchYoutube();">
                        <input type="text" class="form-control" placeholder="Search...." id="search" />
                        <span class="input-group-btn">
                            <button class="btn btn-info btn-lg" type="submit" id="findNow">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </span>
                    </form>
                </div>
            </div>
      <div id="results"></div>
      <div id="buttons"></div>
</div>