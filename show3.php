<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>show3</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
</head>

<body>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#preview">
        Selfie
    </button>
    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#preview">
        ID Front
    </button>
    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#preview">
        ID Back
    </button>

    <!-- Modal -->
    <div class="modal fade" id="preview" tabindex="-1" role="dialog" aria-labelledby="previewImage">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="previewImage">Selfie</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="/savePhotoTest/getImage.php?id=1" alt="image" width="100%">
                        </div>
                        <div class="col-md-6">
                            <video src="https://test-videos.co.uk/vids/bigbuckbunny/mp4/h264/360/Big_Buck_Bunny_360_10s_30MB.mp4" width="100%" autoplay controls></video>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="/savePhotoTest/getImage.php?id=1" class="btn btn-warning" download="image.jpeg">Download Image</a>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-primary" id='downloadVideo'>Download Video</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

</html>