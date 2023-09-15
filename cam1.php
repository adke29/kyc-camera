<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="kycInterface d-flex">
        <div class="video-wrapper">
            <img src="" alt="result" class="result">
            <video id="cam1" autoplay playsinline></video>
            <video id="cam2" autoplay playsinline class='cam-rounded'></video>
        </div>

        <div class="loading my-auto mx-auto">
            <h3>Uploading <i class='fas fa-spinner fa-spin '></i></h3>
        </div>

        <div class="guidance my-auto px-5">
            <div class="d-flex py-4">
                <i class="far fa-face-smile h1 mx-3 my-auto"></i>
                <div class="guidance-text px-3">
                    <h3 class="mb-3">Smile</h3>
                    <p class="mb-0">You are in camera</p>
                </div>
            </div>
            <div class="buttons p-4">
                <div class="result">
                    <a href="" download="test.webm" id="download"><button id='submit' class='btn btn-primary'>Submit</button></a>
                    <button id='retake' class='btn btn-light'>Retake</button>
                </div>
                <h3 id='countdown'>3</h3>
                <button id="capture" class='btn btn-primary'>Take a Photo</button>
                <p id="askPermitText" class="text-danger py-3">*Please allow your browser to access your camera and reload this page</p>
            </div>
        </div>
    </div>
    <video src="" alt="resultvideo" class="result" controls></video>
    <script src="https://kit.fontawesome.com/c8d5a82795.js" crossorigin="anonymous"></script>




    <!-- <script
        src="https://kit.fontawesome.com/c8d5a82795.js"
        crossorigin="anonymous"
    ></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

    <script>
        // $("p:contains('Powered by WHMCompleteSolution')").hide()
        let camera = document.querySelector("#cam1");
        let camera2 = document.querySelector("#cam2");
        let capture = document.querySelector("#capture");
        let camera_stream = null;
        let media_recorder = null;
        let blobs_recorded = [];
        var imageBlob = null;
        var videoBlob = null;

        async function startCamera() {
            camera.style.display = 'inline-block';
            camera2.style.display = 'inline-block';
            $('#capture').show();
            $(".result").hide();
            $('.loading').hide();
            $('#countdown').hide();
            capture.disabled = true;
            capture.classList.toggle('btn-primary');
            //reset stream
            camera_stream = null;
            media_recorder = null;
            blobs_recorded = [];
            imageBlob = null;
            videoBlob = null;
            navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia; //alternative for mobile browser
            camera_stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    width: {
                        min: 640,
                        ideal: 640,
                        max: 640
                    },
                    height: {
                        min: 480,
                        ideal: 480,
                        max: 480
                    },
                    facingMode: "environment",
                },
                audio: false,
            });
            camera_stream2 = await navigator.mediaDevices.getUserMedia({
                video: {
                    width: {
                        min: 320,
                        ideal: 320,
                        max: 640
                    },
                    height: {
                        min: 400,
                        ideal: 400,
                        max: 480
                    },
                    facingMode: "environment",
                },
                audio: false,
            });
            capture.disabled = false;
            $('#askPermitText').hide();
            capture.classList.toggle('btn-primary');
            camera.srcObject = camera_stream;
            camera2.srcObject = camera_stream2;

        }

        function startRecording() {
            // set MIME type of recording as video/webm
            media_recorder = new MediaRecorder(camera_stream, {
                mimeType: "video/webm",
            });

            // event : new recorded video blob available
            media_recorder.addEventListener("dataavailable", function(e) {
                blobs_recorded.push(e.data);
            });

            // start recording with each recorded blob having 1 second video
            media_recorder.start(1000);
        }

        window.onload = startCamera();


        function getImage() {
            return new Promise((res) => {
                const canvas = document.createElement("canvas"); // create a canvas
                const ctx = canvas.getContext("2d"); // get its context
                canvas.width = camera.videoWidth; // set its size to the one of the video
                canvas.height = camera.videoHeight;
                ctx.drawImage(camera, 0, 0); // the video
                canvas.toBlob((blob) => {
                    const image_url = URL.createObjectURL(blob);
                    $('img.result').attr("src", image_url);
                    res(blob);

                }, "image/jpeg"); // request a Blob from the canvas
            });
        }

        function getVideo() {
            return new Promise((res) => {
                console.log(blobs_recorded);
                // if (blobs_recorded.length > 3) {
                //     blobs_recorded = blobs_recorded.slice(0, 3);
                // }
                console.log(blobs_recorded);
                var blobs = new Blob(blobs_recorded, {
                    type: "video/webm"
                });
                console.log(blobs);
                const video_url = URL.createObjectURL(blobs);
                $('video.result').attr("src", video_url);
                $('#download').attr("href", video_url);
                res(blobs);
            })
        }

        capture.addEventListener("click", async function() {
            console.log("capture");
            $('#countdown').text(3);
            $('#countdown').show();
            $('#capture').hide();
            startRecording();
            let counter = 3;
            let countdown = setInterval(function() {
                console.log(counter);
                counter--;
                $('#countdown').text(counter);
            }, 1500);
            setTimeout(async function() {
                clearInterval(countdown);
                $('#countdown').hide();
                media_recorder.stop();
                capture.disabled = true;

                imageBlob = await getImage();
                videoBlob = await getVideo();
                $('.result').show();
                camera.style.display = 'none';
                camera2.style.display = 'none';
            }, 4500);
            // for(var i = 3; i>0;i-- ){
            //     console.log(i);
                
            //     $('#countdown').text(await delay(i));
            // }
            
        });

        $("#submit").on("click", function() {
            $(".guidance").hide();
            $('.loading').show();

            var formData = new FormData();
            formData.append('image', imageBlob, 'image.jpeg');
            formData.append('video', videoBlob, 'video.webm');
            formData.append('type', '{$submitValue}');

            var xhr = new XMLHttpRequest();
            xhr.open("post", 'upload.php', true);
            xhr.onload = function(e) {
                console.log('File uploading completed!');
                window.location.replace("success.php");
            };

            console.log('File uploading started!');
            xhr.send(formData);
        });

        $('#retake').on('click', () => {
            startCamera();
        })
    </script>

</body>


</html>