@if( isset($dataManagerPage['business']['trainers']))

    <div class="list-single-main-item fl-wrap" id="sec2">
        <div class="list-single-main-item-title fl-wrap">
            <h3>Our Trainers</h3>
        </div>
        <div class="team-holder fl-wrap">
            <!-- team-item -->
            <div class="team-box">
                <div class="team-photo">
                    <img src="{{ URL::asset($themePath.'images/team/4.jpg')}}" alt="" class="respimg">
                </div>
                <div class="team-info">
                    <h3><a href="#">Alisa Gray</a></h3>
                    <h4>Trx/Pilates</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                        incididunt ut labore et dolore magna aliqua. </p>
                    <ul class="team-social">
                        <li><a href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fa fa-tumblr"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fa fa-behance"></i></a></li>
                    </ul>
                </div>
            </div>
            <!-- team-item  end-->
            <!-- team-item -->
            <div class="team-box">
                <div class="team-photo">
                    <img src="{{ URL::asset($themePath.'images/team/5.jpg')}}" alt="" class="respimg">
                </div>
                <div class="team-info">
                    <h3><a href="#">Austin Evon</a></h3>
                    <h4>Fitness / CrossFit</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                        incididunt ut labore et dolore magna aliqua. </p>
                    <ul class="team-social">
                        <li><a href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fa fa-tumblr"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fa fa-behance"></i></a></li>
                    </ul>
                </div>
            </div>
            <!-- team-item end  -->
            <!-- team-item -->
            <div class="team-box">
                <div class="team-photo">
                    <img src="{{ URL::asset($themePath.'images/team/6.jpg')}}" alt="" class="respimg">
                </div>
                <div class="team-info">
                    <h3><a href="#">Taylor Roberts</a></h3>
                    <h4>Feet Health studio</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                        incididunt ut labore et dolore magna aliqua. </p>
                    <ul class="team-social">
                        <li><a href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fa fa-tumblr"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fa fa-behance"></i></a></li>
                    </ul>
                </div>
            </div>
            <!-- team-item end  -->
        </div>
    </div>
@endif
