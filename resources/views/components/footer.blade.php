<footer class="page-footer font-small footer" style="z-index:10;bottom:0px;position:relative;width: -webkit-fill-available;">
<!-- Social buttons -->
<div class="primary-color">
    <div class="container">
        <!--Grid row-->
        <div class="row py-4 d-flex align-items-center">

            <!--Grid column-->
            <div class="col-md-6 col-lg-5 text-center text-md-left mb-4 mb-md-0">
                <h4 class="mb-0 white-text">Get connected with us on social networks!</h4>
            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-md-6 col-lg-7 text-center text-md-right">
                <!--Facebook-->
                <a class="fb-ic ml-0">
                    <i class="fa fa-facebook white-text mr-4"> </i>
                </a>
                <!--Twitter-->
                <a class="tw-ic">
                    <i class="fa fa-twitter white-text mr-4"> </i>
                </a>
                <!--Google +-->
                <a class="gplus-ic">
                    <i class="fa fa-google-plus white-text mr-4"> </i>
                </a>
                <!--Linkedin-->
                <a class="li-ic">
                    <i class="fa fa-linkedin white-text mr-4"> </i>
                </a>
                <!--Instagram-->
                <a class="ins-ic">
                    <i class="fa fa-instagram white-text mr-lg-4"> </i>
                </a>
            </div>
            <!--Grid column-->

        </div>
        <!--Grid row-->
    </div>
</div>
<!-- Social buttons -->

<!--Footer Links-->
<div class="container mt-5 mb-4 text-center text-md-left">
    <div class="row mt-3">

        <!--First column-->
        <div class="col-md-3 col-lg-4 col-xl-3 mb-4">
            <!-- <h6 class="text-uppercase font-weight-bold">
                <strong>ClassroomNg</strong>
            </h6> -->
            <a class="navbar-brand" href="/">
                <img src="{{ asset('mdb/img/logo.png')}}" class="img-responsive" style="width:200px"/>
            </a>
            <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
            <p>ClassroomNg is a platform designed for 
                educators to help them store course materials
                making them available to all.</p>
        </div>
        <!--/.First column-->

        <!--Second column-->
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
            <h6 class="text-uppercase font-weight-bold">
                <strong>Links</strong>
            </h6>
            <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
            <p>
                <a href="#!">About</a>
            </p>
            <p>
                <a href="#!">Contact Us</a>
            </p>
            <p>
                <a href="#!">Terms of Service</a>
            </p>
        </div>
        <!--/.Second column-->

        <!--Third column-->
        <div class="col-md-4 col-lg-3 col-xl-3">
            <h6 class="text-uppercase font-weight-bold">
                <strong>Contact</strong>
            </h6>
            <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
            <p>
                <i class="fa fa-home mr-3"></i> 7 Shadia Street, Off Adekunle Osomo Street, Soluyi, Gbagada, Lagos - Nigeria.</p>
            <p>
                <i class="fa fa-envelope mr-3"></i> info@classroomng.com</p>
            <p>
                <i class="fa fa-phone mr-3"></i> + 234 (0)812 657 8236</p>
        </div>
        <!--/.Third column-->

    </div>
</div>
<!--/.Footer Links-->

<!-- Copyright -->
<div class="footer-copyright text-center py-3">&copy; <?php echo Date("Y")?> Copyright:
    <a href="{{url('/')}}"> Classroomng.com</a>
</div>
<!-- Copyright -->
</footer>


      <!-- SCRIPTS -->
    <!-- JQuery -->
    <script type="text/javascript" src="{{ asset('mdb/js/jquery-3.3.1.min.js') }}"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="{{ asset('mdb/js/popper.min.js') }}"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="{{ asset('mdb/js/bootstrap.min.js') }}"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="{{ asset('mdb/js/mdb.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mdb/js/vanilla.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mdb/js/timeago.js') }}"></script>
    <script>
        $("time.timeago").timeago();
    </script>
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=x9v7l8yleqlv5fhsfbipacl93girudvql99u0wp7a64b8rix"></script>
    <script>tinymce.init({ 
        selector:'.wysiwyg',
        images_reuse_filename: false,
        images_upload_handler: function (blobInfo, success, failure) {
        var xhr, formData;

        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', 'postAcceptor.php');

        xhr.onload = function() {
        var json;

        if (xhr.status != 200) {
            failure('HTTP Error: ' + xhr.status);
            return;
        }

        json = JSON.parse(xhr.responseText);

        if (!json || typeof json.location != 'string') {
            failure('Invalid JSON: ' + xhr.responseText);
            return;
        }

        success(json.location);
        };

        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());

        xhr.send(formData);
    }
   });</script>
    <!-- google translate -->
    <script type="text/javascript"  src="//translate.google.com/translate_a/element.../js?cb=googleTranslateElementInit"></script>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
        }
    </script>
