<?php
session_start();

if(!isset($_SESSION['type'])) {
    include 'headerGuest.php';
}
else if($_SESSION['type']==="admin")
    include 'headerAdmin.php';
else if($_SESSION['type']==="other")
    include 'headerOther.php';
else if($_SESSION['type']==="inner")
    include 'headerInner.php';
else
    include 'headerGuest.php'
?>
<script type="text/javascript" src="cemeteries.js"></script>

<script type="text/javascript">
    niz.push("cemeteries");
</script>


<section class="mbr-cards mbr-section mbr-section-nopadding" id="features1-x" data-rv-view="54" style="background-color: rgb(255, 255, 255); padding-top:90px">
    <div ng-controller="cemeteriesController" class="mbr-cards-row row">

      <div class="row">
        <label for="country">Country: </label><br>
        <select id="country" ng-model="country">
            <option value="all" >All</option>
            <option value="{{country.name}}" ng-repeat="country in countries">
              {{country.name}}
            </option>
        </select>

        <label for="region">Region: </label><br>
        <select id="region" ng-model="region">
            <option value="all" >All</option>
            <option value="{{region.name}}" ng-repeat="region in regions">
              {{region.name}}
            </option>
        </select>

        <label for="place">Place: </label><br>
        <select id="place" ng-model="place">
            <option value="all" >All</option>
            <option value="{{place.name}}" ng-repeat="place in places">
              {{place.name}}
            </option>
        </select>
      </div>

        <div class="mbr-testimonials mbr-section mbr-section-nopadding">
            <div class="container">
                <div class="row">
                    <div ng-repeat="cemetery in cemeteries"  class="col-xs-12 col-md-3 col-lg-3">
                        <div class="mbr-testimonial card card-block mbr-testimonial-lg">
                            <div class="card card-block">
                                <div class="card-img"><img src="assets/images/cemetery.jpg" class="card-img-top"></div>
                                <div class="card-block">
                                    <h4 class="card-title">{{cemetery.name}}</h4>
                                    <h5 class="card-subtitle">Country: {{cemetery.country}}</h5>
                                    <h5 class="card-subtitle">Region: {{cemetery.region}}</h5>
                                    <h5 class="card-subtitle">Place: {{cemetery.place}}</h5>
                                    <h5 class="card-subtitle">Description: {{cemetery.description}}</h5>
                                    <div class="card-btn">
                                        <a href="cemetery.php" class="btn btn-primary" ng-click="choose(cemetery.id)">MORE</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include('footer.php');
?>
